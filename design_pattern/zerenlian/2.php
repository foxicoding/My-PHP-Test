<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/6
 * Time:12:19 下午
 */


//原文链接：https://blog.csdn.net/jhq0113/article/details/46454419

//申请Model
class Request
{
    //数量
    public $num;
    //申请类型
    public $requestType;
    //申请内容
    public $requestContent;
}

//抽象管理者
abstract class Manager
{
    protected $name;
    //管理者上级
    protected $manager;
    public function __construct($_name)
    {
        $this->name = $_name;
    }

    //设置管理者上级
    public function SetHeader(Manager $_mana)
    {
        $this->manager = $_mana;
    }

    //申请请求
    abstract public function Apply(Request $_req);

}

//经理
class CommonManager extends Manager
{
    public function __construct($_name)
    {
        parent::__construct($_name);
    }
    public function Apply(Request $_req)
    {
        if($_req->requestType=="请假" && $_req->num<=2)
        {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        }
        else
        {
            if(isset($this->manager))
            {
                $this->manager->Apply($_req);
            }
        }

    }
}

//总监
class MajorDomo extends Manager
{
    public function __construct($_name)
    {
        parent::__construct($_name);
    }

    public function Apply(Request $_req)
    {
        if ($_req->requestType == "请假" && $_req->num <= 5)
        {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        }
        else
        {
            if (isset($this->manager))
            {
                $this->manager->Apply($_req);
            }
        }

    }
}


//总经理
class GeneralManager extends Manager
{
    public function __construct($_name)
    {
        parent::__construct($_name);
    }

    public function Apply(Request $_req)
    {
        if ($_req->requestType == "请假")
        {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        }
        else if($_req->requestType=="加薪" && $_req->num <= 500)
        {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        }
        else if($_req->requestType=="加薪" && $_req->num>500)
        {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}再说吧。<br/>";
        }
    }
}



require_once "./Responsibility/Responsibility.php";
$jingli = new CommonManager("李经理");
$zongjian = new MajorDomo("郭总监");
$zongjingli = new GeneralManager("孙总");

//设置直接上级
$jingli->SetHeader($zongjian);
$zongjian->SetHeader($zongjingli);

//申请
$req1 = new Request();
$req1->requestType = "请假";
$req1->requestContent = "小菜请假！";
$req1->num = 1;
$jingli->Apply($req1);

$req2 = new Request();
$req2->requestType = "请假";
$req2->requestContent = "小菜请假！";
$req2->num = 4;
$jingli->Apply($req2);

$req3 = new Request();
$req3->requestType = "加薪";
$req3->requestContent = "小菜请求加薪！";
$req3->num = 500;
$jingli->Apply($req3);

$req4 = new Request();
$req4->requestType = "加薪";
$req4->requestContent = "小菜请求加薪！";
$req4->num = 1000;
$jingli->Apply($req4);