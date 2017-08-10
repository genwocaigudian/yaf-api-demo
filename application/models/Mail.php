<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/10
 * Time: 23:26
 */
require __DIR__ . '/../../vendor/autoload.php';
use Nette\Mail\Message;

class MailModel {
    public $error = 0;
    public $errmsg = '';
    private $_db = null;

    public function __construct(){
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=yaf_api", 'root', '123456');
    }

    public function send($uid, $title, $content) {
        $query = $this->_db->prepare("select `email` from `user` where `id`=? ");
        $query->execute([intval($uid)]);
        $ret = $query->fetchAll();

        if (!$ret || 1 != count($ret)) {
            $this->errno = -3003;
            $this->errmsg = "用户邮箱信息查找失败";
            return false;
        }

        $userEmail = $ret[0]['email'];
        if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $this->errno = -3004;
            $this->errmsg = "用户邮箱信息不符合标准，邮箱地址为：".$userEmail;
            return false;
        }

        $mail = new Message;
        $mail->setFrom('lemon <guoyunci_test@126.com>')
            ->addTo($userEmail)
            ->setSubject($title)
            ->setBody($content);

        $mailer = new Nette\Mail\SmtpMailer([
            'host' => 'smtp.126.com',
            'username' => 'guoyunci_test@126.com',
            'password' => 'phpapi123',
            'secure' => 'ssl',
        ]);
        $mailer->send($mail);
        return true;
    }
}