<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/11
 * Time: 15:32
 */

class SmsController extends Yaf_Controller_Abstract {
    public function indexAction() {

    }

    public function sendAction() {
        $submit = $this->getRequest()->getQuery('submit', 0);
        if(1 != $submit) {
            echo json_encode([
                "errno"=>-4001,
                "errmsg"=>"请通过正确渠道提交"
            ]);
            return false;
        }

        // 获取参数
        $uid = $this->getRequest()->getPost("uid", false);
        if(!$uid) {
            echo json_encode([
                "errno"=>-4002,
                "errmsg"=>"用户ID、短信内容均不能为空。"
            ]);
            return false;
        }

        $model = new SmsModel();
        if ($model->send(intval($uid))) {
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