<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/4
 * Time: 00:49
 */

class ArtController extends Yaf_Controller_Abstract {
    public function indexAction() {
        return $this->listAction();
    }

    public function addAction($artId = 0) {
        if(!$this->_isAdmin()) {
            echo json_encode([
                'errno' => -2000,
                'errmsg' => '需要管理员权限才能操作'
            ]);
            return false;
        }

        $submit = $this->getRequest()->getQuery('submit', '0');
        if(1 != $submit) {
            echo json_encode([
                'errno' => -2001,
                'errmsg' => '请通过正确渠道提交'
            ]);
            return false;
        }

        $title = $this->getRequest()->getPost('title', false);
        $content = $this->getRequest()->getPost('content', false);
        $author = $this->getRequest()->getPost('author', false);
        $cate = $this->getRequest()->getPost('cate', false);

        if(!$title || !$content || !$author || !$cate) {
            echo json_encode([
                'errno' => -2002,
                'errmsg' => '标题,内容,作者,分类信息不可为空'
            ]);
            return false;
        }

        //调用 model, 做登录验证
        $model = new ArtModel();
        if($lastId = $model->add(trim($title), trim($content), trim($author), trim($cate), $artId)) {
            echo json_encode([
                'errno' => 0,
                'errmsg' => '',
                'data' => ['lastId' => $lastId]
            ]);
        } else {
            echo json_encode([
                'errno' => $model->errno,
                'errmsg' => $model->errmsg
            ]);
        }
        return true;
    }

    public function editAction() {
        if(!$this->_isAdmin()) {
            echo json_encode([
                'errno' => -2000,
                'errmsg' => '需要管理员权限才能操作'
            ]);
            return false;
        }

        $artId = $this->getRequest()->getQuery('artId', 0);
        if(is_numeric($artId) && $artId) {
            return $this->addAction($artId);
        } else {
            echo json_encode([
                'errno' => -2003,
                'errmsg' => '缺少必要的文章 id 参数'
            ]);
        }

        return true;
    }

    public function delAction() {
        if(!$this->_isAdmin()) {
            echo json_encode([
                'errno' => -2000,
                'errmsg' => '需要管理员权限才能操作'
            ]);
            return false;
        }

        $artId = $this->getRequest()->getQuery("artId", 0);
        if(is_numeric($artId) && $artId) {
            $model = new ArtModel();
            if($model->del($artId)) {
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
        } else {
            echo json_encode([
                "errno"=>-2003,
                "errmsg"=>"缺少必要的文章标题参数"
            ]);
        }
        return true;
    }

    public function statusAction(){
        if(!$this->_isAdmin()) {
            echo json_encode([
                "errno"=>-2000,
                "errmsg"=>"需要管理员权限才可以操作"
            ]);
            return false;
        }

        $artId = $this->getRequest()->getQuery("artId", 0);
        $status = $this->getRequest()->getQuery("status", "offline");

        if(is_numeric($artId) && $artId) {
            $model = new ArtModel();
            if($model->status($artId, $status)) {
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
        } else {
            echo json_encode([
                "errno"=>-2003,
                "errmsg"=>"缺少必要的文章标题参数"
            ]);
        }
        return false;
    }
    public function getAction(){
        $artId = $this->getRequest()->getQuery("artId", 0);

        if(is_numeric($artId) && $artId) {
            $model = new ArtModel();
            if($data=$model->get($artId)) {
                echo json_encode([
                    "errno"=>0,
                    "errmsg"=>"",
                    "data"=>$data,
                ]);
            } else {
                echo json_encode([
                    "errno"=>-2009,
                    "errmsg"=>"获取文章信息失败"
                ]);
            }
        } else {
            echo json_encode([
                "errno"=>-2003,
                "errmsg"=>"缺少必要的文章标题参数"
            ]);
        }
        return true;
    }
    public function listAction(){
        $pageNo = $this->getRequest()->getQuery("pageNo", 0);
        $pageSize = $this->getRequest()->getQuery("pageSize", 10);
        $cate = $this->getRequest()->getQuery("cate", 0);
        $status = $this->getRequest()->getQuery("status", "online");

        $model = new ArtModel();
        if($data=$model->list($pageNo, $pageSize, $cate, $status)) {
            echo json_encode([
                "errno"=>0,
                "errmsg"=>"",
                "data"=>$data,
            ]);
        } else {
            echo json_encode([
                "errno"=>$model->errno,
                "errmsg"=>$model->errmsg
            ]);
        }
        return false;
    }

    private function _isAdmin() {
        return true;
    }
}