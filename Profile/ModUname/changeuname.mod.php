<?php
$errors = [];
if (isset($_POST['submitUnameChange'])  && isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

    if (Database::readRowQuery("SELECT COUNT(id) FROM users WHERE uname LIKE ?", [$_POST['newuname']]) != 0)
        $errors[] = "UserName already exist.";
    else if (!Auth::usernameValid($_POST['newuname']))
    $errors[] = 'Please enter a valid Username.';
    else if (Database::readRowQuery('SELECT pass FROM users WHERE id LIKE ?', [$_SESSION['user']['id']]) != hash('whirlpool', $_POST['pass']))
        $errors[] = "PassWord is incorrect.";
    else if (empty($_POST['newuname']))
            $errors[] = 'Please enter an Username.';
    else {
        Auth::changeUname($_POST['newuname'], $_SESSION['user']['id']);
        $_SESSION['user']['uname'] = $_POST['newuname'];
        echo "<div class='succes'><p>Your Username has been changed.</p></div>";
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