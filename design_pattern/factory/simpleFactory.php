<?php
/**
 * author:ljb
 */

/**
 * 简单工厂模式最大的优点在于实现对象的创建和对象的使用分离，将对象的创建交给专门的工厂类负责，
 * 但是其最大的缺点在于工厂类不够灵活，增加新的具体产品需要修改工厂类的判断逻辑代码，
 * 而且产品较多时，工厂方法代码逻辑将会非常复杂。
 * 链接：https://www.jianshu.com/p/70f7fd47f2e2
 */

namespace design_pattern\factory\simpleFactory;

interface People{
    public function say();
}

class Man implements People
{

    public function say()
    {
        echo 'this is a man';
    }

}

class Woman implements People
{
    public function say()
    {
        echo 'this is a woman';
    }
}

class SimpleFactory
{
    public static function create($sex)
    {
        if ($sex == 'man'){
            return new Man();
        }
        if ($sex == 'woman'){
            return new Woman();
        }
    }
}

//具体调用
$man = SimpleFactory::create('man');
$man->say();
$woman = SimpleFactory::create('woman');
$woman->say();