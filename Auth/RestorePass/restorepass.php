<?php
if (isset($_SESSION['user'])) {
    header('Location: /gallery/');
}
?>

<link rel="stylesheet" href="<?= C_AUTH . '/RestorePass/restorepass.css?' . time(); ?>">


<?php require_once(S_AUTH . '/RestorePass/restorepass.mod.php') ?>

<form class="restorePassForm" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <label for="newpass1">New Password</label>
    <input required id="newpass1"  type="password" name="newpass1">

    <label for="newpass2">Repeat Password</label>
    <input required id="newpass2" type="password" name="newpass2">

    <input id="restorepassword" type="submit" value="restore" name="restorepassword">
</form>