<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
}
?>

<?php require_once(S_PROF . '/ModMail/changemail.mod.php'); ?>

<?php $_SESSION['token'] = $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();?>

<form action="/profile/changemail/" method="post" class="form">
    <label for="mail">New E-Mail</label>
    <input required id="mail" type="email" name="newmail">

    <label for="pass">Password</label>
    <input required id="pass" type="password" name="pass">

    <input required type="hidden" name="token" value="<?= $token ?>">

    <input class="butt" id="submitMailChange" type="submit" value="Change" name="submitMailChange">
</form>