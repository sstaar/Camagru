<?php
$errors = [];
if (isset($_POST['submitMailChange']) && isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {


    if (Database::readRowQuery('SELECT pass FROM users WHERE id LIKE ?', [$_SESSION['user']['id']]) != hash('whirlpool', $_POST['pass']))
        $errors[] = "PassWord is incorrect.";
    else if (empty($_POST['newmail']))
        $errors[] = 'Please enter an E-Mail.';
    else if (!filter_var($_POST['newmail'], FILTER_VALIDATE_EMAIL))
        $errors[] = 'Please enter a valid E-Mail.';
    else {
        Auth::changeEmail($_POST['newmail'], $_SESSION['user']['mail']);
        $_SESSION['user']['mail'] = $_POST['newmail'];
        echo "<div class='succes'><p>Your E-mail has been changed.</p></div>";
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