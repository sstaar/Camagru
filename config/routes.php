<?php

$routes = [];

function    route($action, $callback) {

    global $routes;

    $action = trim($action, '/');

    $routes[$action] = $callback;
}

function    dispatch($action) {
    global $routes;

    if ($action === null)
        return ;
    $action = trim($action, '/');

    if (isset($routes[$action]))
    {
        
        $callback = $routes[$action];
        require_once(call_user_func($callback));
    }
    else {
        echo "<div class='errors'><h1>404</h1></div>";
    }
}

//This part is for routing the pages

route('/register', function () {
    return (S_AUTH . '/Register/register.php');
});

route('/login', function () {
    return (S_AUTH . '/Login/login.php');
});

route('/forgotpass', function () {
    return (S_AUTH . '/ForgotPass/forgotpass.php');
});

route('/restorepass', function () {
    return (S_AUTH . '/RestorePass/restorepass.php');
});

route('/logout', function () {
    return (S_AUTH . '/Logout/logout.php');
});

route('', function () {
    return (S_AUTH . '/Login/login.php');
});

route('/cam', function () {
    return (S_CAM . '/camera.php');
});

route('/gallery/', function () {
    return (S_GAL . '/Files/gallery.php');
});

route('/profile/', function () {
    return (S_PROF . '/profile.php');
});

route('/profile/changeusername/', function () {
    return (S_PROF . '/ModUname/changeuname.php');
});

route('/profile/changemail/', function () {
    return (S_PROF . '/ModMail/changemail.php');
});

route('/profile/changepass', function () {
    return (S_PROF . '/ModPass/changepass.php');
});

//---------------------------------
//This part is for ajax POST method

route('/like', function () {
    if ($_SESSION['user']['id'] == $_POST['user_id'] && Database::readRowQuery('SELECT COUNT(id) FROM likes WHERE post_id LIKE ? AND user_id LIKE ?', [ $_POST['post_id'], $_POST['user_id'] ]) != 1)
        Post::likePost($_POST['post_id'], $_POST['user_id']);
    else
        Database::nonQuery('DELETE FROM likes WHERE post_id LIKE ? AND user_id LIKE ?', [ $_POST['post_id'], $_POST['user_id'] ]);
    return (S_ROOT . '/empty.php');
});

route('/comment', function () {
    if ($_SESSION['user']['id'] == $_POST['user_id']) {
        Post::commentPost($_POST['user_id'], $_POST['post_id'], $_POST['text']);
        if (Database::readRowQuery('SELECT receives FROM users WHERE id LIKE ?', [ $_POST['ownerId'] ]) == 1) {
            $ownerMail = Database::readRowQuery('SELECT mail FROM users WHERE id LIKE ?', [ $_POST['ownerId'] ]);
            mail($ownerMail, 'Comment', 'Your post has been commented by' . $_SESSION['user']['uname']);
        }
    }
    return (S_ROOT . '/empty.php');
});

route('/deletePost', function () {
    $postUser = Database::readRowQuery('SELECT user_id FROM posts WHERE id LIKE ?', [ $_POST['post_id'] ]);
    echo $postUser;
    if ($_SESSION['user']['id'] == $postUser)
        Post::deletePost($_POST['post_id']);
    return (S_ROOT . '/empty.php');
});

route('/capture', function () {
    $parts = rawurldecode($_POST['data']);
    $parts = explode(";base64,", $parts);
    $name = $_SESSION['user']['id'] . '/' . str_shuffle('UnexpectedValueException') . time() . '.png';
    $imageName = S_GAL . '/Users/' . $name;
    file_put_contents($imageName, base64_decode($parts[1]));
    $size = filesize($imageName);
    if ($size && $size > 5242880) {
        echo "<div class='errors'><p>Image too big.</p></div>";
        unlink($imageName);
        return (S_ROOT . '/empty.php');
    }
    else if (!$size) {
        echo "<div class='errors'><p>Something is wrong.</p></div>";
        unlink($imageName);
        return (S_ROOT . '/empty.php');
    }
    $filter = $_POST['filter'];
    $imgRes = imagecreatefrompng($imageName);
    $filtRes = imagecreatefrompng($filter);
    imagecopy($imgRes, $filtRes, 100, 300, 0, 0, 200, 200);
    imagepng($imgRes, $imageName);
    Post::storePost($_SESSION['user'], [ $name ], "ALLO");
    return (S_ROOT . '/empty.php');
});

route('/activation', function () {
    $uname = $_GET['username'];
    $token = $_GET['token'];
    if (Database::readRowQuery('SELECT activated FROM users WHERE uname LIKE ?', [ $uname ]) == 1) {
        echo "<div class='errors'><p>Account already active.</p></div>";
        return (S_ROOT . '/empty.php');
    }
    if (Auth::activate($uname, $token))
        echo "<div class='succes'><p>Account activated.</p></div>";
    else
        echo "<div class='errors'><p>Something is wrong.</p></div>";
    return (S_ROOT . '/empty.php');
});

route('/restorepass', function () {
    $uname = $_GET['username'];
    $token = $_GET['token'];
    if ($token === 0 || Database::readRowQuery('SELECT token FROM users WHERE uname LIKE ?', [ $uname ]) != $token) {
        echo "<div class='errors'><p>Something is wrong.</p></div>";
        return (S_ROOT . '/empty.php');
    }
    else {
        return (S_AUTH . '/RestorePass/restorepass.php');
    }
});

route('/changerec', function () {
    if (Database::readRowQuery('SELECT receives FROM users WHERE uname LIKE ?', [ $_SESSION['user']['uname'] ]) == 1)
        Database::nonQuery('UPDATE users SET receives=? WHERE uname LIKE ?', [ 0, $_SESSION['user']['uname'] ]);
    else
        Database::nonQuery('UPDATE users SET receives=? WHERE uname LIKE ?', [ 1, $_SESSION['user']['uname'] ]);
    return (S_ROOT . '/empty.php');
});

?>
