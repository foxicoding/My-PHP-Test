<?php

/**
 * author:ljb
 */

/**
 *
 * 单例对于PHP来说一般情况下毫无意义，只是一次请求多次调用一个类的时候会有用
 *
 */

/*****************************饿汉式*******************************
     *所谓饿汉式，就是直接创建出类的实例化；
     *是否 Lazy 初始化：否
     *是否多线程安全：是
     *实现难度：易
     *描述：这种方式比较常用，但容易产生垃圾对象。
     *优点：没有加锁，执行效率会提高。
     *缺点：类加载时就初始化，浪费内存。
     *它基于 classloder 机制避免了多线程的同步问题，
     *不过，instance 在类装载时就实例化，虽然导致类装载的原因有很多种，
     *在单例模式中大多数都是调用 getInstance 方法，
     *但是也不能确定有其他的方式（或者其他的静态方法）导致类装载，
     *这时候初始化 instance 显然没有达到 lazy loading 的效果。
 */
class SingletonEH
{
    private static $singleton = 'self';  //此处应该初始化对象，但是垃圾PHP不支持这样弄，所以，饿汉模式PHP不能支持。

    private function __construct()
    {

    }
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {
        return self::$singleton;
    }
}

/***************************************懒汉式**********************************
     *所谓懒汉式，就是在需要的时候再创建类的实例化，PHP经常用的就是懒汉模式
     *是否 Lazy 初始化：是
     *是否多线程安全：否
     *实现难度：易
     *描述：这种方式是最基本的实现方式，这种实现最大的问题就是不支持多线程。因为没有加锁 synchronized，所以严格意义上它并不算单例模式。
     *这种方式 lazy loading 很明显，不要求线程安全，在多线程不能正常工作。
 */
class SingletonLH
{
    public static $singleton = NULL;

    private function __construct()
    {

    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {
        if (self::$singleton == NULL){
            self::$singleton = new self();
        }
        return self::$singleton;
    }
}