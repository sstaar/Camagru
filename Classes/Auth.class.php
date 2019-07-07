<?php

class Auth {
    
    public static function      unameExist($uname) {
        $res = Database::readQuery('SELECT * FROM users WHERE uname LIKE ?', [ $uname ]);
        if (count($res) == 0)
            return (false);
        else
            return (true);
    }

    public static function      createAcc($uname, $mail, $pass, $token) {
        Database::nonQuery('INSERT INTO users (
            uname,
            pass,
            mail,
            receives,
            activated,
            token
        ) VALUES (? ,? , ?, 1, 0, ?)', [
            $uname,
            hash('whirlpool', $pass),
            $mail,
            $token
        ]);
    }

    public static function      connect($uname, $pass) {
        $res = Database::readQuery('SELECT * FROM users WHERE uname LIKE ? AND pass LIKE ? ', [ $uname, hash('whirlpool', $pass) ]);
        if (count($res) == 0)
            return (false);
        $res = $res[0];
        return ([
            'id' => $res['id'],
            'uname' => $res['uname'],
            'mail' => $res['mail'],
            'activated' => $res['activated']
        ]);
    }

    public static function      activate($uname, $token) {
        $res = Database::readRowQuery('SELECT token FROM users WHERE uname LIKE ?', [ $uname ]);
        if ($token == $res) {
            Database::nonQuery('UPDATE users SET activated=1, token=0 WHERE uname LIKE ?', [ $uname ]);
            return (true);
        }
        else
            return (false);
    }

    public static function      changePass($new, $id) {
        Database::nonQuery('UPDATE users SET pass=? WHERE id LIKE ?', [ hash('whirlpool', $new), $id ]);
    }

    public static function      changeUname($new, $id) {
        Database::nonQuery('UPDATE users SET uname=? WHERE id LIKE ?', [ $new, $id ]);
    }

    public static function      changeEmail($new, $id) {
        Database::nonQuery('UPDATE users SET mail=? WHERE id LIKE ?', [ $new, $id ]);
    }

    public static function      passwordValid($pass) {
        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/", $pass) != 1)
            return (false);
        return (true);
    }

    public static function      usernameValid($uname) {
        if (strlen($uname) <= 4 || preg_match("/^\d*[a-zA-Z][a-zA-Z\d]*$/", $uname) != 1)
            return (false);
        return (true);
    }

}

?>
