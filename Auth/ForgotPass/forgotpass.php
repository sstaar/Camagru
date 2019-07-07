<?php
if (isset($_SESSION['user'])) {
    header('Location: /gallery');
}
?>

<?php require_once(S_AUTH . '/ForgotPass/forgotpass.mod.php'); ?>

<?php $_SESSION['token'] = $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();?>

<form action="/forgotpass/" method="post" class="form">
    <label for="uname">Username</label>
    <input required id="uname" type="text" name="forgotuname">

    <input required type="hidden" name="token" value="<?= $token ?>">

    <input class="butt" id="forgotpassword" type="submit" value="send" name="forgotpassword">
</form>

