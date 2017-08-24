<?php
/**
 * Created by PhpStorm.
 * User: likun
 * Date: 2017/8/24
 * Time: 22:31
 */

class Err_Map {
    const ERRMAP = [
        1001 => '请通过正确渠道提交',
        1002 => '用户名和密码必须传递',
        1003 => '用户查找失败',
        1004 => '密码错误',
        1005 => '用户名已存在',
        1006 => '密码太短, 请设置至少8位的密码',
        1007 => '注册失败, 写入数据失败'
    ];

    public static function get($code) {
        if(isset(self::ERRMAP[$code])) {
            return [
                'errno' => 0-$code,
                'errmsg' => self::ERRMAP[$code]
            ];
        }
        return [
            'errno' => 0-$code,
            'errmsg' => 'undefined this error number'
        ];
    }
}