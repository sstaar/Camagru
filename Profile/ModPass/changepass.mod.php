<?php
$errors = [];
if (isset($_POST['submitPassChange']) && isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
    

    if (Database::readRowQuery('SELECT pass FROM users WHERE id LIKE ?', [ $_SESSION['user']['id'] ]) != hash('whirlpool', $_POST['oldpass']))
        $errors[] = "Old PassWord in incorrect.";
    else if (!Auth::passwordValid($_POST['newpass1']))
        $errors[] = 'Password not strong enough.';
    else if ($_POST['newpass1'] != $_POST['newpass1'])
        $errors[] = "PassWords does't match.";
    else {
        Auth::changePass($_POST['newpass1'], $_SESSION['user']['id']);
        echo "<div class='succes'><p>Your Password has been changed.</p></div>";
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