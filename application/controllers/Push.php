<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/15
 * Time: 11:46
 */

class PushController extends Yaf_Controller_Abstract {

    public function singleAction() {

        // 获取参数
        $cid = $this->getRequest()->getPost("cid", "");
        $msg = $this->getRequest()->getPost("msg", "");

        if(!$cid || !$msg) {
            echo json_encode([
                "errno"=>-5002,
                "errmsg"=>"请输入推送用户的设备ID与要推送的内容"
            ]);
            return false;
        }

        $model = new PushModel();
        if ($model->single($cid, $msg)) {
            echo json_encode([
                "errno"=>0,
                "errmsg"=>"",
            ]);
        } else {
            echo json_encode([
                "errno"=>$model->errno,
                "errmsg"=>$model->errmsg,
            ]);
        }
        return true;
    }

    public function toallAction() {

        // 获取参数
        $msg = $this->getRequest()->getPost("msg", "");

        if(!$msg) {
            echo json_encode([
                "errno"=>-5002,
                "errmsg"=>"请输入要推送的内容"
            ]);
            return false;
        }

        $model = new PushModel();
        if ($model->toall($msg)) {
            echo json_encode([
                "errno"=>0,
                "errmsg"=>"",
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