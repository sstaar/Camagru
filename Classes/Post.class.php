<?php

class Post {

    public static function      storePost($user, $imgs, $text) {
        if (empty($text))
            $text = "TEST.";
        Database::nonQuery('INSERT INTO posts (
            user_id, `date`, `text`
        ) VALUES (? , UTC_TIMESTAMP(), ?)', [ $user['id'], $text ]);
        $postId = Database::lastId();
        foreach ($imgs as $img) {
            Image::storeImage($postId, $img);
        }
    }

    public static function      getAllPosts($page) {
        $res = [];
        $posts = Database::readQuery('SELECT id, user_id, DATE_FORMAT(`date`, "%y-%m-%d %H:%i") as `date`, `text` FROM posts ORDER BY posts.date DESC LIMIT ? , ?', [ $page * POSTS_PAGE, POSTS_PAGE ]);
        foreach ($posts as $post) {
            $res[] = [
                'id' => $post['id'],
                'user_id' => $post['user_id'],
                'user' => Database::readQuery('SELECT uname FROM users WHERE id LIKE ?', [ $post['user_id'] ])[0]['uname'],
                'filenames' => Database::readQuery('SELECT filename FROM photos INNER JOIN post_photos ON photos.id = post_photos.photo_id INNER JOIN posts ON posts.id = post_photos.post_id WHERE posts.id = ?', [ $post['id'] ]),
                'date' => $post['date'],
                'text' => $post['text']
            ];
        }
        return ($res);
    }

    public static function      getUserPosts($userId) {
        $posts = Database::readQuery('SELECT * FROM posts WHERE user_id LIKE ?', [ $userId ]);
        $res = [];
        foreach ($posts as $post) {
            $res[] = Database::readQuery('SELECT filename, post_id FROM photos INNER JOIN post_photos ON photos.id = post_photos.photo_id INNER JOIN posts ON posts.id = post_photos.post_id WHERE posts.id LIKE ? ORDER BY `date` DESC', [ $post['id'] ]);
        }
        return ($res);
    }

    public static function      likePost($postId, $userId) {
        Database::nonQuery('INSERT INTO likes (post_id, user_id) VALUES (?, ?)', [ $postId, $userId ]);
    }

    public static function      getPostLikes($postId) {
        $res = Database::readRowQuery('Select COUNT(id) as likes FROM likes WHERE post_id LIKE ?', [ $postId ]);
        return ($res);
    }

    public static function      commentPost($userId, $postId, $text) {
        Database::nonQuery('INSERT INTO comments (
            post_id, user_id, `text`, `date`
        ) VALUES (?, ?, ?, UTC_TIMESTAMP())', [ $postId, $userId, $text ]);
    }

    public static function      getPostComments($postId) {
        $res = Database::readQuery('SELECT `text`, DATE_FORMAT(`date`, "%y-%m-%d %H:%i") as `date`, uname FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.post_id LIKE ? ORDER BY `date` ASC', [ $postId ]);
        return ($res);
    }

    public static function      deletePost($postId) {
        $imgs = Database::readQuery('SELECT photo_id, filename FROM posts INNER JOIN post_photos ON posts.id = post_photos.post_id INNER JOIN photos ON photos.id = post_photos.photo_id WHERE posts.id LIKE ?', [ $postId ]);
        foreach ($imgs as $img) {
            Database::nonQuery('DELETE FROM photos WHERE id LIKE ?', [ $img['photo_id'] ]);
            unlink(S_GAL . '/Users/' . $img['filename']);
        }
        Database::nonQuery('DELETE FROM likes WHERE post_id LIKE ?', [ $postId ]);
        Database::nonQuery('DELETE FROM comments WHERE post_id LIKE ?', [ $postId ]);
        Database::nonQuery('DELETE FROM posts WHERE id LIKE ?', [ $postId ]);
    }

}

?>