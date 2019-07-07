<?php
if (isset($_SESSION['user'])) {
    header('Location: /gallery/');
}
?>

<?php require_once(S_AUTH . '/Login/login.mod.php'); ?>

<?php
if (isset($_SESSION['user'])) {
    header('Location: /gallery/');
}
?>

<form action="/login" method="post" class="form">
    <label for="uname">UserName
    </label>
    <input required id="uname" type="text" name="uname" >

    <label for="pass">Password
    </label>
    <input required id="pass" type="password" name="pass" >

    <input class="butt" required id="submitLog" type="submit" name="submitLog" value="OK" >
</form>