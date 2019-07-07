<?php
$errors = [];

if (isset($_POST['submitReg']) && isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
    $uname = $_POST['uname'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];

    if (empty($uname))
        $errors[] = 'Please enter a UserName.';
    else if (!Auth::usernameValid($uname))
        $errors[] = 'Please enter a valid UserName.';
    elseif (Auth::unameExist($uname))
        $errors[] = 'UserName already exists.';
    
    if (!Auth::passwordValid($pass))
        $errors[] = 'Password not strong enough.';

    if (empty($pass))
        $errors[] = 'Please enter a PassWord.';
    else if ($pass != $repass)
        $errors[] = 'PassWords do not match.';

    if (empty($mail))
        $errors[] = 'Please enter an E-Mail.';
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid E-Mail.';
    }

    if (count($errors) == 0) {
        $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();
        $actLink = "http://$_SERVER[HTTP_HOST]" . '/activation?username=' . $uname . '&token=' . $token;
        mail($mail, 'Account activation', $actLink);
        Auth::createAcc($uname, $mail, $pass, $token);
        echo "<div class='succes'><p>Account created and needs to be activated.</p><p>Please check your E-mail.</p></div>";
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