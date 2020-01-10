<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/9
 * Time:6:49 下午
 */

/**
 * Trait也可以互相组合，还可以使用抽象方法，静态属性，静态方法等
 */

trait Cat{
    public function eat(){
        echo "This is Cat eat";
    }
}

trait Dog
{
    use Cat;
    public function drive()
    {
        echo 'this is dog drive';
    }
    abstract public function getName();
    public function test()
    {
        static $num = 0;
        $num++;
        echo $num;
    }
    public static function say()
    {
        echo 'this is dog say';
    }
}

class Animal
{
    use Dog;
    public function getName()
    {
        echo 'this is animal name';
    }
}

$animal = new animal();
$animal->getName();
echo "<br/>";
$animal->eat();
echo "<br/>";
$animal->drive();
echo "<br/>";
$animal::say();
echo "<br/>";
$animal->test();
echo "<br/>";
$animal->test();
echo "<br/>";
$animal->test();