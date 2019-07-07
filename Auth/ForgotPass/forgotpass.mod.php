<?php
$errors = [];

if (isset($_POST['forgotpassword']) && isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
    

    if (Database::readRowQuery('SELECT COUNT(id) FROM users WHERE uname LIKE ?', [ $_POST['forgotuname'] ]) == 0)
        $errors[] = "Username does not exist";
    else if (Database::readRowQuery('SELECT activated FROM users WHERE uname LIKE ?', [ $_POST['forgotuname'] ]) == 0)
        $errors[] = "Account not activated.";
    else {
        
        $mail = Database::readRowQuery('SELECT mail FROM users WHERE uname LIKE ?', [ $_POST['forgotuname'] ]);
        $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();
        Database::nonQuery('UPDATE users SET token=? WHERE uname LIKE ?', [ $token, $_POST['forgotuname'] ]);
        $actLink = "http://$_SERVER[HTTP_HOST]" . '/restorepass?username=' . $_POST['forgotuname'] . '&token=' . $token;
        mail($mail, 'Password restoration', $actLink);
        echo "<div class='succes'><p>Check your E-mail to restore your password.</p></div>";
    }
}

?>

<?php if (count($errors) != 0) : ?>
    <div class="errors">
        <?php foreach ($errors as $error) : ?>
            <p><?= $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>