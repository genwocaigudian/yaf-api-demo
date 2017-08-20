<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/7/31
 * Time: 17:53
 */

class UserModel {
    public $errno = 0;
    public $errmsg = '';
    private $_db = null;

    public function __construct() {
        $this->_db = new PDO('mysql:host=127.0.0.1;dbname=yaf_api', 'root', '123456');
    }

    public function login($uname, $pwd) {
        $query = $this->_db->prepare("select `id`,`pwd` from `user` where `name`= ? ");
        $query->execute([$uname]);
        $ret = $query->fetchAll();

        if(!$ret || 1!=count($ret)) {
            $this->errno = -1003;
            $this->errmsg = '用户查找失败';
            return false;
        }

        $userInfo = $ret[0];
        if(Common_Password::pwdEncode($pwd) != $userInfo['pwd']) {
            $this->errno = -1004;
            $this->errmsg = '密码错误';
            return false;
        }
        return intval($userInfo[0]);
    }

    public function register($uname, $pwd) {
        $query = $this->_db->prepare("select count(*) as c from `user` where `name`= ? ");
        $query->execute([$uname]);
        $count = $query->fetchAll();

        if(0 != $count[0]['c']) {
            $this->errno = -1005;
            $this->errmsg = '用户名已存在';
            return false;
        }

        if(8 > strlen($pwd)) {
            $this->errno = -1006;
            $this->errmsg = '密码太短, 请设置至少8位的密码';
            return false;
        }

        $pwd = Common_Password::pwdEncode($pwd);

        $query = $this->_db->prepare("insert into `user` (`id`, `name`, `pwd`, `reg_time`) VALUES (null, ?, ?, ?)");
        $ret = $query->execute([$uname, $pwd, date('Y-m-d H:i:s')]);

        if(!$ret) {
            $this->errno = -1007;
            $this->errmsg = '注册失败, 写入数据失败';
            return false;
        }

        return true;
    }
}