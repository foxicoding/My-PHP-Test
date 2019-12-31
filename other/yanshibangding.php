<?php


/**
 *
 * PHP 静态样式绑定
 */


class A
{
    public static function who()
    {
        echo __CLASS__;
    }

    public static function test()
    {
        self::who();      //输出A
        static::who();    //输出B
    }
}

class B extends A
{
    public static function who()
    {
        echo __CLASS__;
    }
}

B::test();

