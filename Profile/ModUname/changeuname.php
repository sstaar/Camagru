<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
}
?>

<?php require_once(S_PROF . '/ModUname/changeuname.mod.php'); ?>

<?php $_SESSION['token'] = $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();?>

<form action="/profile/changeusername/" method="post" class="form">
    <label for="uname">New UserName</label>
    <p>Only letters and numbers.</p>
    <input required id="uname" type="text" name="newuname">

    <label for="pass">Password</label>
    <input required id="pass" type="password" name="pass">

    <input required type="hidden" name="token" value="<?= $token ?>">

    <input class="butt" id="submitUnameChange" type="submit" value="Change" name="submitUnameChange">
</form>