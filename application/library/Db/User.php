<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/21
 * Time: 23:18
 */

class Db_User extends Db_Base {

    public function find($uname) {
        $query = self::getDb()->prepare("select `id`,`pwd` from `user` where `name`= ? ");
        $query->execute([$uname]);
        $ret = $query->fetchAll();
        if(!$ret || 1 != count($ret)) {
            list(self::$errno, self::$errmsg) = array_values(Err_Map::get(1003));
            return false;
        }
        return $ret[0];
    }

    public function checkExists($uname) {
        $query = self::getDb()->prepare("select count(*) as c from `user` where `name`= ? ");
        $query->execute([$uname]);
        $count = $query->fetchAll();
        if(0 != $count[0]['c']) {
            list(self::$errno, self::$errmsg) = array_values(Err_Map::get(1005));
            return false;
        }
        return true;
    }

    public function addUser($uname, $password, $datetime) {
        $query = self::getDb()->prepare("insert into `user` (`id`, `name`, `pwd`, `reg_time`) VALUES (null, ?, ?, ?)");
        $ret = $query->execute([$uname, $password, $datetime]);
        if(!$ret) {
            list(self::$errno, self::$errmsg) = array_values(Err_Map::get(1007));
            return false;
        }
        return true;
    }
}