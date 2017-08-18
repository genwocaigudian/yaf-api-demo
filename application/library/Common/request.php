<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/18
 * Time: 14:27
 */

class Common_Request {
    public static function request($key, $default=null, $type=null) {
        if('get'==$type) {
            $result = isset($_GET[$key]) ? trim($_GET[$key]) : null;
        } elseif('post'==$type) {
            $result = isset($_POST[$key]) ? trim($_POST[$key]) : null;
        } else {
            $result = isset($_REQUEST[$key]) ? trim($_REQUEST[$key]) : null;
        }

        if(null!=$default && null==$result) {
            $result = $default;
        }
        return $result;
    }

    public static function getRequest($key, $default=null) {
        return self::request($key, $default, 'get');
    }

    public static function postRequest($key, $default=null) {
        return self::request($key, $default, 'post');
    }
}