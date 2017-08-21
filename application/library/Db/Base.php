<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/21
 * Time: 23:13
 */

class Db_Base {

    public static $errno = 0;
    public static $errmsg = '';
    public static $db = null;

    public static function getDb() {
        if(null == self::$db) {
            self::$db = new PDO("mysql:host=127.0.0.1;dbname=yaf_api", "root", '123456');
        }
        return self::$db;
    }

    public function errno() {
        return self::$errno;
    }

    public function errmsg() {
        return self::$errmsg;
    }
}