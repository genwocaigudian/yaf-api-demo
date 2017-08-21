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
    private $_dao = null;

    public function __construct() {
        $this->_dao = new Db_User();
    }

    public function login($uname, $pwd) {
        $userInfo = $this->_dao->find($uname);

        if(!$userInfo) {
            $this->errno = $this->_dao->errno();
            $this->errmsg = $this->_dao->errmsg();
            return false;
        }

        if(Common_Password::pwdEncode($pwd) != $userInfo['pwd']) {
            $this->errno = -1004;
            $this->errmsg = '密码错误';
            return false;
        }
        return intval($userInfo[0]);
    }

    public function register($uname, $pwd) {
        if(!$this->_dao->checkExists($uname)) {
            $this->errno = $this->_dao->errno();
            $this->errmsg = $this->_dao->errmsg();
            return false;
        }

        if(8 > strlen($pwd)) {
            $this->errno = -1006;
            $this->errmsg = '密码太短, 请设置至少8位的密码';
            return false;
        }

        $pwd = Common_Password::pwdEncode($pwd);

        if(!$this->_dao->addUser($uname, $pwd, date('Y:m:d H:i:s'))) {
            $this->errno = $this->_dao->errno();
            $this->errmsg = $this->_dao->errmsg();
            return false;
        }

        return true;
    }
}