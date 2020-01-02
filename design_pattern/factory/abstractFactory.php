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
