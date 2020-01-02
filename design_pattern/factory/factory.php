<?php
/**
 * author:ljb
 */
/**
 * 此模式中，通过定义一个抽象的核心工厂类，并定义创建产品对象的接口，创建具体产品实例的工作延迟到其工厂子类去完成。
 * 这样做的好处是核心类只关注工厂类的接口定义，而具体的产品实例交给具体的工厂子类去创建。
 * 当系统需要新增一个产品是，无需修改现有系统代码，只需要添加一个具体产品类和其对应的工厂子类，
 * 使系统的扩展性变得很好，符合面向对象编程的开闭原则
 * 链接：https://www.jianshu.com/p/70f7fd47f2e2
 */

/**
 * 工厂方法模式是简单工厂模式的进一步抽象和推广。
 * 由于使用了面向对象的多态性，工厂方法模式保持了简单工厂模式的优点，而且克服了它的缺点。
 * 在工厂方法模式中，核心的工厂类不再负责所有产品的创建，而是将具体创建工作交给子类去做。
 * 这个核心类仅仅负责给出具体工厂必须实现的接口，而不负责产品类被实例化这种细节，
 * 这使得工厂方法模式可以允许系统在不修改工厂角色的情况下引进新产品。
 */

namespace design_pattern\factory\factory;

interface People
{
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
        echo 'this is woman';
    }
}

//与简单工厂模式相比，区别在于，此处将对象的创建抽象成一个接口
interface PeopleFactory
{
    public function create();
}

class ManFactory implements PeopleFactory
{
    public function create()
    {
        return new Man();
    }
}

class WomanFactory implements PeopleFactory
{
    public function create()
    {
        return new Woman();
    }
}

class Client
{
    public function test()
    {
        $manFactory = new ManFactory();
        $man = $manFactory->create();
        $man->say();
        $womanFactory = new WomanFactory();
        $woman = $womanFactory->create();
        $woman->say();
    }
}

(new Client())->test();