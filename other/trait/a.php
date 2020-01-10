<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/7
 * Time:4:24 下午
 */

/**
 * php从以前到现在一直都是单继承的语言，无法同时从两个基类中继承属性和方法，为了解决这个问题，php出了Trait这个特性
 * Trait 是为类似 PHP 的单继承语言而准备的一种代码复用机制。
 * Trait 为了减少单继承语言的限制，使开发人员能够自由地在不同层次结构内独立的类中复用 method。
 * Trait 和 Class 组合的语义定义了一种减少复杂性的方式，避免传统多继承和 Mixin 类相关典型问题。
 * Trait 和 Class 相似，但仅仅旨在用细粒度和一致的方式来组合功能。
 * 无法通过 trait 自身来实例化。它为传统继承增加了水平特性的组合；也就是说，应用的几个 Class 之间不需要继承。
 * 链接：https://www.jianshu.com/p/fc053b2d7fd1
 */

trait Dog
{
    public $name = 'dog';

    public function bark()
    {
        echo 'this is a dog';
    }
}

class Animal
{
    public function eat()
    {
        echo 'this is animal eat';
    }
}

class Cat extends Animal
{
    use Dog;
    public function drive()
    {
        echo 'this is cat drive';
    }
}

$cat = new Cat();
$cat->drive();
echo '<br/>';
$cat->eat();
echo '<br/>';
$cat->bark();
echo '<br/>';
