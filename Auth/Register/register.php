<?php
if (isset($_SESSION['user'])) {
    header('Location: /gallery/');
}
?>

<?php require_once(S_AUTH . '/Register/register.mod.php'); ?>

<?php $_SESSION['token'] = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();?>

<form action="/register" method="post" class="form">
    <label for="uname">UserName</label>
    <p>Only letters and numbers.</p>
    <input required id="uname" type="text" name="uname" >

    <label for="mail">E-Mail</label>
    <input required id="mail" type="email" name="mail" >

    <label for="pass">Password</label>
    <p>At least an uppercase, lowercase and a digit.</p>
    <input required id="pass" type="password" name="pass" >

    <label for="repass">Password confirmation</label>
    <input required id="repass" type="password" name="repass" >

    <input required type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

    <input class="butt" id="submitReg" type="submit" name="submitReg" value="Submit" >
</form>