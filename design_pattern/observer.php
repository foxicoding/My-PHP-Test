<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/2
 * Time:11:06 上午
 */

/**
 * 模式定义
 * 观察者模式（observer pattern）:
 * 定义对象间的一种一对多（或一对一）的依赖关系，当被观察者状态发生改变时，注册的观察者都会被通知。
 * 链接：https://segmentfault.com/a/1190000012817402
 */

/**
 * 模式动机
 * 建立一种对象和对象之间的依赖关系，一个对象发生改变时将自动通知其他对象，其他对象收到通知各自处理自己的业务逻辑。
 * 这里发生改变的对象称为被观察者，被通知的对象称为观察者。
 * 这些观察者之间没有关系，可以根据业务需求添加或删除观察者，便于系统维护和扩展。
 */

/**
 * 模式结构
    Subject(目标)
    ConcreteSubject(具体目标)
    Observer: 观察者
    ConcreteObserver:具体观察者
 */

/**
 * 代码示例
 * 代码实现的场景：假设有个一个商人卖东西，他的用户有穷人和富人两类，商人的商品可能会涨价也可能会降价 价格波动对穷人和富人的购买行为有不同的影响。
   分析：这里的观者目标是 商品价格 ，被观察者是穷人和富人，商品价格变化将会通知穷人和富人，穷人富人对购买做出不同的反映
 */

//目标
interface Observables
{
    public function attach(Observer $ob); //添加观察者
    public function detach(Observer $ob); //删除观察者
    public function notify(); //通知观察者
}

//具体的目标
class Saler implements Observables
{
    protected $ob = [];
    protected $range = 0;
    public function attach(Observer $ob)
    {
        $this->ob[] = $ob;
    }
    public function detach(Observer $ob)
    {
       foreach ($this->ob as $k => $v){
           if ($v == $ob){
               unset($this->ob[$k]);
           }
       }
    }
    public function notify()
    {
        if ($this->range != 0) {
            foreach ($this->ob as $k => $v) {
                $v->update($this);
            }
        }
    }
    public function incrPrice($range)
    {
        $this->range = $range;
    }

    public function getRange()
    {
        return $this->range;
    }
}

//观察者
interface Observer
{
    public function update(Observables $obv);
}

class PoorBuyer implements Observer
{
    public function update(Observables $obv)
    {
        if ($obv->getRange() > 0) {
            echo '穷人：涨价不买了</br>';
        }else{
            echo '穷人：降价了赶紧买</br>';
        }
    }
}

class RichBuyer implements Observer
{
    public function update(Observables $obv)
    {
        echo '富人：价格波动没关系，继续购买<br>';
    }
}
$saler = new Saler();
$saler->attach(new PoorBuyer());
$saler->attach(new RichBuyer());
$saler->incrPrice(-1);
$saler->notify();