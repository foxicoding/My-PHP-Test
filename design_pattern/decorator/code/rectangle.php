<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:2:52 下午
 */

namespace design_pattern\decorator\code;

/**
 * 长方形具体实现类
 * Class Rectangle
 * @package design_pattern\decorator
 */
class rectangle implements shape
{
    public function Draw()
    {
        'this is a rectangle';
    }
}