<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/16
 * Time: 11:35
 */

class IpModel {
    public $errno = 0;
    public $errmsg = '';

    public function __construct() {
    }

    public function get($ip) {
        $rep = ThirdParty_Ip::find($ip);
        return $rep;
    }
}