<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/6
 * Time:11:43 上午
 */

/**
 * 责任链模式
 * 是一种对象的行为模式。
 * 在责任链模式里面很多对象由每一个对象对其下家的引用而连接起来形成一条链。
 * 请求在这个链上传递，知道链上的某个对象决定处理此请求。
 * 发出请求的这个客户端，并不知道链上的哪个对象可以处理此请求，这使得系统可以在不影响客户端的前提下，动态的重新组织和分配责任
 */

/**
 * 情景
 *
 * 建立一个对象链，按照指定顺序处理调用；如果其中有一个对象无法处理当前的情况，移交下一个对象处理
 */

/**
 * 例子
 *
 * 日志框架，每个链元素自主决定如何处理日志消息。
 * 垃圾邮件过滤器。
 * 缓存：例如第一个对象是一个 Memcached 接口实例，如果 “丢失” 它会委托数据库接口处理这个调用。
 * 举报处理系统
 */

abstract class Handler
{
    private $successor = null;

    public function __construct(Handler $handler = null)
    {
        $this->successor = $handler;
    }

    final public function handle($request)
    {
        $processed = $this->processing($request);
        if ($processed === null){
            // 请求尚未被目前的处理器处理 => 传递到下一个处理器。
            if ($this->successor !== null){
                $processed = $this->successor->processing($request);
            }
        }
        return $processed;
    }

    abstract protected function processing($request);
}


/**
 * 具体处理类1
 * Class ConcreteHandler1
 */
class ConcreteHandler1 extends  Handler
{
    protected function processing($request){
        if ($request < 0) {
            echo "当前对象1：举报处理完毕" . '<br>';
            return $this;
        }

        return null;
    }
}

/**
 * 具体处理类2
 * Class ConcreteHandler12
 */
class ConcreteHandler2 extends  Handler
{
    protected function processing($request){
        if ($request > 0) {
            echo "当前对象2：举报处理完毕" . '<br>';
            return $this;
        }
        return null;
    }
}


//设置责任链上下家
$handler1 = new ConcreteHandler1(
    new ConcreteHandler2()
);

$request = [1, -1, 2];
foreach ($request as $value) {
    $handler1->handle($value);
}
