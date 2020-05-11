<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/9
 * Time:6:26 下午
 */


/**
 * 测试Trait、基类和本类对同名属性或方法的处理
 */

/**
 * Trait中的方法会覆盖 基类中的同名方法，而本类会覆盖Trait中同名方法
 * 注意点：当trait定义了属性后，类就不能定义同样名称的属性，否则会产生 fatal error，
 * 除非是设置成相同可见度、相同默认值。不过在php7之前，即使这样设置，还是会产生E_STRICT 的提醒

 */

trait Dog
{
    public $name = 'dog';
    public function drive()
    {
        echo 'this is dog drive';
    }
    public function eat()
    {
        echo 'this is dog eat';
    }
}

class Animal
{
    public function drive()
    {
        echo 'this is animal drive';
    }
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
        echo 'this is animal drive aaa';
    }
}

$cat = new Cat();
$cat->drive();
echo '<br/>';
$cat->eat();