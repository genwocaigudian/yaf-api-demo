<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/16
 * Time: 11:34
 */

class IpController extends Yaf_Controller_Abstract {
    public function indexAction() {

    }

    public function getAction() {
        // 获取参数
        $ip = $this->getRequest()->getPost("ip", "");
        if(!$ip || !filter_var($ip, FILTER_VALIDATE_IP)) {
            echo json_encode([
                "errno"=>-6002,
                "errmsg"=>"请传递正确的 ip 地址"
            ]);
            return false;
        }

        $model = new IpModel();
        if ($data = $model->get(trim($ip))) {
            echo json_encode([
                "errno"=>0,
                "errmsg"=>"",
                "data"=>$data
            ]);
        } else {
            echo json_encode([
                "errno"=>$model->errno,
                "errmsg"=>$model->errmsg,
            ]);
        }
        return true;
    }
}