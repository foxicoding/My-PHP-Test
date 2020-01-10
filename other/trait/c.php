<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/9
 * Time:6:37 下午
 */


/**
 * 一个类可以组合多个Trait，通过逗号相隔

    use trait1,trait2
    当不同的trait中，却有着同名的方法或属性，会产生冲突，可以使用insteadof或 as进行解决，
    insteadof 是进行替代，而as是给它取别名

 */
trait trait1{
    public function eat(){
        echo "This is trait1 eat";
    }
    public function drive(){
        echo "This is trait1 drive";
    }
}
trait trait2{
    public function eat(){
        echo "This is trait2 eat";
    }
    public function drive(){
        echo "This is trait2 drive";
    }
}

class Cat
{
    use trait1,trait2
    {
        trait1::eat insteadof trait2;
        trait1::drive insteadof trait2;
    }
}

class Dog
{
    use trait1,trait2
    {
        trait1::eat insteadof trait2;
        trait1::drive insteadof trait2;
        trait2::eat as eaten;
        trait2::drive as drvien;
    }
}

$cat = new Cat();
$cat->eat();
echo '<br/>';
$cat->drive();
echo "<br/>";
echo "<br/>";
echo "<br/>";
$dog = new Dog();
$dog->eat();
echo "<br/>";
$dog->drive();
echo "<br/>";
$dog->eaten();
echo "<br/>";
$dog->drvien();
echo "<br/>";