<?php
/**
 * *****************************************************************
 * 这不是一个自由软件,谢绝修改再发布.
 * @Created by PhpStorm
 * @Name    :   AuthBarCode.class.php
 * @Email   :   28386631@qq.com
 * @Author  :  along
 * @Date    :   2017-01-19 14:42 
 * @Link    :   http://ServPHP.LinkUrl.cn
 * *****************************************************************
 */

namespace Common\BarCode;
use Think\Think;
use Think\Exception;

abstract class AuthBarCode extends Think
{
    public static function getInstance($type, $token = null)
    {
        $name = ucfirst(strtolower($type)) . 'BarCode';
        $name ='Common\BarCode'.'\\'.$name;
        if (class_exists($name))
        {
            return new $name($token);
        }else {
            self::halt(L('_CLASS_NOT_EXIST_') . ':' . $name);
        }

    }

}