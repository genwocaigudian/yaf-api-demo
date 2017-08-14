<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/11
 * Time: 15:40
 */

require __DIR__ . '/../../vendor/autoload.php';
use \Yunpian\Sdk\YunpianClient;

class SmsModel {
    public $errno = 0;
    public $errmsg = '';
    private $_db = null;

    public function __construct() {
        $this->_db = new PDO('mysql:host=127.0.0.1;dbname=yaf_api', 'root', '123456');
    }

    public function send($uid) {
        $query = $this->_db->prepare("select `mobile` from `user` where `id`=? ");
        $query->execute([intval($uid)]);
        $ret = $query->fetchAll();

        if (!$ret || 1 != count($ret)) {
            $this->errno = -4003;
            $this->errmsg = "用户邮箱信息查找失败";
            return false;
        }

        $userMobile = $ret[0]['mobile'];
        if(!$userMobile || !is_numeric($userMobile) || 11 != strlen($userMobile)) {
            $this->errno = -4004;
            $this->errmsg = "用户手机号信息不符合标准，手机号为：".(!$userMobile?"空":$userMobile);
            return false;
        }

        //需要传入 apikey
        $apikey = '';

        //初始化client,apikey作为所有请求的默认值
        $clnt = YunpianClient::create($apikey);

        $param = [YunpianClient::MOBILE => $userMobile,YunpianClient::TEXT => '【云片网】您的验证码是4321'];
        $r = $clnt->sms()->single_send($param);
//        var_dump($r);


        return true;
    }
}