<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:2:51 下午
 */


namespace design_pattern\decorator\code;

/**
 * 圆形具体实现类
 * Class Circle
 * @package design_pattern\decorator
 */
class circle implements shape
{
    public function Draw()
    {
        echo 'this is a circle';
    }
}