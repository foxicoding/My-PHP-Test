<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/9
 * Time:6:44 下午
 */

/**
 * as 还可以修改方法的访问控制
 */

trait Animal
{
    public function eat()
    {
        echo 'this is animal eat';
    }
}

class Dog
{
    use Animal
    {
        eat as protected;
    }
}

class Cat
{
    use Animal
    {
        Animal::eat as private eaten;
    }
}
$dog = new Dog();
//$dog->eat();//报错，因为已经把eat改成了保护

$cat = new Cat();
$cat->eat();//正常运行，不会修改原先的访问控制
//$cat->eaten();//报错，已经改成了私有的访问控制