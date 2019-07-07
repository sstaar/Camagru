<?php

class Database {

    private static $_con = null;

    public function     __construct() {
        
    }

    public static function      lastId() {
        $stm = self::$_con->query("SELECT LAST_INSERT_ID()");
        return ($stm->fetchColumn());
    }

    public static function     init() {
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        try  {
            self::$_con = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            self::$_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return (true);
        } catch (PDOException $e) {
            if (isset($e))
                return (false);
        }
    }

    public static function     nonQuery($query, $params = []) {
        $stm = self::$_con->prepare($query);
        $result = $stm->execute($params);
        $stm->closeCursor();
        if ($result === false)
            return (false);
        return (true);
    }

    public static function     readQuery($query, $params = []) {
        $stm = self::$_con->prepare($query);
        $error = $stm->execute($params) === false;
        if ($error === false)
            $result = $stm->fetchAll();
        $stm->closeCursor();
        if ($error === false)
            return ($result);
        return (false);
    }

    public static function     readRowQuery($query, $params = []) {
        $stm = self::$_con->prepare($query);
        $error = $stm->execute($params) === false;
        if ($error === false)
            $result = $stm->fetchColumn();
        $stm->closeCursor();
        if ($error === false)
            return ($result);
        return (false);
    }

}

?>