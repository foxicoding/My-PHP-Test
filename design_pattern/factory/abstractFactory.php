<?php
/**
 * author:ljb
 */

/**
 * 提供一个创建一系列相关或相互依赖对象的接口，而无须指定它们具体的类
 * 抽象工厂模式又称为Kit模式，属于对象创建型模式。
 * 此模式是对工厂方法模式的进一步扩展。
 * 在工厂方法模式中，一个具体的工厂负责生产一类具体的产品，即一对一的关系，
 * 但是，如果需要一个具体的工厂生产多种产品对象，那么就需要用到抽象工厂模式了。
 * 链接：https://www.jianshu.com/p/70f7fd47f2e2
 */

/**
 * 要生产一个新的产品，抽象工厂模式并不比工厂方法模式更为便捷，那么抽象工厂模式的好处在哪呢?
 * 它优点就是在于是增加固定类型产品的不同具体工厂比较方便，
 * 比如我要增加一个生产同样类型产品的具体工厂Product2Factory，那么就再建一个Product2Factory类继承Factory就可以了。
 */


interface TV
{
    public function open();
    public function watch();
}

class HaierTv implements TV
{
    public function open()
    {
        echo "Open Haier TV <br>";
    }
    public function watch()
    {
        echo "I'm watching TV <br>";
    }
}

interface PC
{
    public function work();
    public function play();
}

class LenovoPC implements PC
{
    public function work()
    {
        echo "I'm working on a Lenovo computer <br>";
    }
    public function play()
    {
        echo "Lenovo computers can be used to play games <br>";
    }
}

abstract class Factory
{
    abstract public static function createTV();
    abstract public static function createPC();
}

class ProductFactory extends Factory
{
    public static function createTV()
    {
        return new HaierTv();
    }
    public static function createPC()
    {
        return new LenovoPC();
    }
}
$newTv = ProductFactory::createTV();
$newTv->open();
$newTv->watch();

$newPc = ProductFactory::createPc();
$newPc->work();
$newPc->play();
