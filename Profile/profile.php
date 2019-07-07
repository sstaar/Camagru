<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
}
?>

<link rel="stylesheet" href="<?= C_PROF . '/profile.css?' . time(); ?>">

<div class="profile">
    <a href="/profile/changepass">Change your password</a>
    <a href="/profile/changeusername">Change your username</a>
    <a href="/profile/changemail">Change your E-mail</a>

    <?php if (Database::readRowQuery('SELECT receives FROM users WHERE uname LIKE ?', [$_SESSION['user']['uname']]) == 1) : ?>
        <button id="activated" onclick="changeRec(1)">Desactivate recieving mails when commented on your posts</button>
    <?php else : ?>
        <button id="desactivated" onclick="changeRec(2)">Activate recieving mails when commented on your posts</button>
    <?php endif; ?>
</div>

<script>
    function changeRec(type) {
        let xtp = new XMLHttpRequest();
        xtp.open('POST', '/changerec', true);
        let data = '';
        xtp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xtp.send(data);

        //DOM
        if (type == 1) {
            document.getElementById("activated").innerHTML = "Activate recieving mails when commented on your posts";
            
        }
        else if (type == 2)
            document.getElementById("desactivated").innerHTML = "Desactivate recieving mails when commented on your posts";
    }
</script>