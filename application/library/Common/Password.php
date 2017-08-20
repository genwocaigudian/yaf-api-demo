<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/20
 * Time: 21:46
 */

class Common_Password {
    const SALT = 'salt-xxxx-';

    public static function pwdEncode($pwd) {
        return md5(self::SALT . $pwd);
    }
}