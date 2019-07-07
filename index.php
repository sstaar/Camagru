
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link rel="stylesheet" href="/main.css? <?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>



<body>

    <?php

    session_start();
    require_once("config/config.php");
    require_once(S_CONFIG . '/database.php');
    require_once(S_CLASS . '/Database.class.php');
    require_once(S_CLASS . '/Auth.class.php');
    require_once(S_CLASS . '/Image.class.php');
    require_once(S_CLASS . '/Post.class.php');
    require_once(S_CONFIG . '/routes.php');

    if (!Database::init()) {
        echo "<div class='errors'><p>Something is wrong.</p></div>";
        exit ;
    }

    if (isset($_SESSION['user']) && Database::readRowQuery('SELECT COUNT(id) FROM users WHERE uname LIKE ? AND id LIKE ?', [
        $_SESSION['user']['uname'],
        $_SESSION['user']['id']
    ]) != 1)
        $_SESSION['user'] = null;

    ?>

    <header>
        <nav>
            <div class="nav">
                <a href="/gallery/">Gallery</a>
                <?php if (isset($_SESSION['user'])) : ?>
                    <a href="/cam/">Camera</a>
                    <a href="/profile/">Profile</a>
                    <a href="/logout/">Logout</a>
                <?php else : ?>
                    <a href="/login/">Login</a>
                    <a href="/register/">Register</a>
                    <a href="/forgotpass/">Forgot your Password</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <?php
        if (isset($_GET['url']))
            $action = $_GET['url'];
        else
            $action = 'gallery';

        dispatch($action);
        ?>
    </main>

    <footer>
        <p>Copyright © 2019 helbouaz</p>
    </footer>
</body>