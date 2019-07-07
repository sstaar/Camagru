<?php

$errors = [];

if (isset($_POST['restorepassword'])) {
    if ($_POST['newpass1'] != $_POST['newpass2'])
        $errors[] = "Passwords does not match.";
    else if (!Auth::passwordValid($_POST['newpass1']))
        $errors[] = 'Password not strong enough.';
    else if ($_GET['token']!== 0 && Database::readRowQuery('SELECT token FROM users WHERE uname LIKE ?', [ $_GET['username'] ]) === $_GET['token']){
        Database::nonQuery('UPDATE users SET pass=?, token=0 WHERE uname LIKE ?', [ hash('whirlpool', $_POST['newpass1']), $_GET['username'] ]);
        echo "<div class='succes'><p>Password changed.</p></div>";
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