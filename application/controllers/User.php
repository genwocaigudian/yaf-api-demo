<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/7/31
 * Time: 17:06
 */

class UserController extends Yaf_Controller_Abstract {

    public function indexAction() {
        return $this->loginAction();
    }

    public function loginAction() {
        $submit = Common_Request::getRequest('submit', '0');
        if(1 != $submit) {
            echo Common_Request::response(-1001, '请通过正确渠道提交');
            return false;
        }

        $uname = Common_Request::postRequest('uname', false);
        $pwd = Common_Request::postRequest('pwd', false);

        if(!$uname || !$pwd) {
            echo json_encode([
                'errno' => -1002,
                'errmsg' => '用户名和密码必须传递'
            ]);
            return false;
        }

        $model = new UserModel();
        $uid = $model->login(trim($uname), trim($pwd));
        if($uid) {
            session_start();
            $_SESSION['user_token'] = md5('salt' . $_SERVER['REQUEST_TIME'] . $uid);
            $_SESSION['user_token_time'] = $_SERVER['REQUEST_TIME'];
            $_SESSION['user_id'] = $uid;
            echo json_encode([
                'errno' => 0,
                'errmsg' => '',
                'data' => ['name' => $uname]
            ]);
        } else {
            echo json_encode([
                'errno' => $model->errno,
                'errmsg' => $model->errmsg
            ]);
        }

        return false;
    }

    public function registerAction() {
        //获取参数
        $uname = $this->getRequest()->getPost('uname', false);
        $pwd = $this->getRequest()->getPost('pwd', false);

        if(!$uname || !$pwd) {
            echo json_encode([
                'errno' => -1002,
                'errmsg' => '用户名和密码必须传递'
            ]);
        }

        //调用 model, 做登录验证
        $model = new UserModel();
        if($model->register(trim($uname), trim($pwd))) {
            echo json_encode([
                'errno' => 0,
                'errmsg' => '',
                'data' => [
                    'name' => $uname
                ]
            ]);
        } else {
            echo json_encode([
                'errno' => $model->errno,
                'errmsg' => $model->errmsg
            ]);
        }
        return false;
    }
}