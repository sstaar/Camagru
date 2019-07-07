<link rel="stylesheet" href="/main.css? <?php echo time(); ?>">

<?php

require_once("database.php");

$query_string =<<< EOF

CREATE DATABASE db_helbouaz;

CREATE TABLE IF NOT EXISTS db_helbouaz.users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    uname VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    receives INT NOT NULL,
    activated INT NOT NULL,
    token VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS db_helbouaz.posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(255) NOT NULL,
    date DATETIME,
    text VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS db_helbouaz.photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS db_helbouaz.post_photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    photo_id INT NOT NULL,
    UNIQUE(post_id, photo_id)
);

CREATE TABLE IF NOT EXISTS db_helbouaz.likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    UNIQUE(post_id, user_id)
);

CREATE TABLE IF NOT EXISTS db_helbouaz.comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    text VARCHAR(500) NOT NULL,
    date DATETIME
);

EOF;

try {
    $con = new PDO("mysql:host=127.0.0.1", $DB_USER, $DB_PASSWORD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query($query_string);
    header('Location: /gallery/');
} catch (PDOException $e) {
    if (isset($e))
        echo "<div class='errors'><p>Something is wrong.</p></div>";
}

?>