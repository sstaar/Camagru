<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
}
?>

<?php require_once(S_PROF . '/ModPass/changepass.mod.php'); ?>

<?php $_SESSION['token'] = $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();?>

<form action="/profile/changepass" method="post" class="form">
    <label for="oldpass">Old Password</label>
    <input required id="oldpass" type="password" name="oldpass">

    <label for="newpass">New Password</label>
    <p>At least an uppercase, lowercase and a digit.</p>
    <input required id="newpass" type="password" name="newpass1">

    <label for="renewpass">Password Confirmation</label>
    <input required id="renewpass" type="password" name="newpass2">

    <input required type="hidden" name="token" value="<?= $token ?>">

    <input class="butt" id="submitPassChange" type="submit" value="Change" name="submitPassChange">
</form>