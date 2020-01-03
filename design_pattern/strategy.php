<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/3
 * Time:11:45 上午
 */

/**
 * 定义一系列的算法，把它们一个个封装起来，并且使它们可相互替换。策略模式可以使算法可独立于使用它的客户而变化
 * 策略模式变化的是算法
 * 链接：https://www.cnblogs.com/zyiii/p/8822524.html
 *     https://www.cnblogs.com/itsuibi/p/11057409.html
 */

/**
 * 策略模式中主要角色
 * 抽象策略(Strategy）角色：定义所有支持的算法的公共接口。通常是以一个接口或抽象来实现。
 *
 * Context使用这个接口来调用其ConcreteStrategy定义的算法
 *
 * 具体策略(ConcreteStrategy)角色：以Strategy接口实现某具体算法
 *
 * 环境(Context)角色：持有一个Strategy类的引用，用一个ConcreteStrategy对象来配置
 */

/**
 * 策略模式的优点：
 * 1、策略模式提供了管理相关的算法族的办法
 * 2、策略模式提供了可以替换继承关系的办法 将算封闭在独立的Strategy类中使得你可以独立于其Context改变它
 * 3、使用策略模式可以避免使用多重条件转移语句
 */

/**
 * 策略模式的缺点：
 * 1、客户必须了解所有的策略 这是策略模式一个潜在的缺点
 * 2、Strategy和Context之间的通信开销
 * 3、策略模式会造成很多的策略类
 */

/**
 * 策略模式适用场景
 * 1、许多相关的类仅仅是行为有异。“策略”提供了一种用多个行为中的一个行为来配置一个类的方法
 * 2、需要使用一个算法的不同变体。
 * 3、算法使用客户不应该知道的数据。可使用策略模式以避免暴露复杂的，与算法相关的数据结构
 * 4、一个类定义了多种行为，并且 这些行为在这个类的操作中以多个形式出现。将相关的条件分支移和它们各自的Strategy类中以代替这些条件语句
 */

interface Strategy {
    public function doOperation($int1,$int2);
}

class OperationAdd implements Strategy
{
    public function doOperation($int1, $int2)
    {
        return $int1 + $int2;
    }
}

class OperationSub implements Strategy
{
    public function doOperation($int1, $int2)
    {
        return $int1 - $int2;
    }
}

class Context
{
    public $strategy;
    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }
    public function execStrategy($int1,$int2)
    {
        return $this->strategy->doOperation($int1, $int2);
    }
}

$add = new OperationAdd();
$context_add = new Context($add);
echo $context_add->execStrategy(5,3);

$sub = new OperationSub();
$context_sub = new Context($sub);
echo $context_sub->execStrategy(5,3);
