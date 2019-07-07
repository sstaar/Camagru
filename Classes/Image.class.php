<?php

class Image {

    public static function storeImage($postId, $filename) {
        Database::nonQuery('INSERT INTO photos (filename) VALUES (?)', [ $filename ]);
        Database::nonQuery('INSERT INTO post_photos ( post_id, photo_id) VALUES (?, ?)', [ $postId, Database::lastId() ]);
    }

}

?>