<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/5
 * Time:12:34 下午
 */

/**
 * 外观模式
 * 为子系统中的一组接口提供一个一致的界面，Facade模式定义了一个高层接口，这个接口使得这一子系统更加容易使用
 * 链接：https://cloud.tencent.com/developer/article/1526806
 */

class Send
{

    private $aliYunService;
    private $jiGuangService;

    private $message;
    private $push;

    public function __construct()
    {
        $this->aliYunService = new AliYunService();
        $this->jiGuangService = new JiGuangService();

        $this->message = new MessageInfo();
        $this->push = new PushInfo();
    }

    public function PushAndSendAliYun()
    {
        $this->message->Send($this->aliYunService);
        $this->push->Push($this->aliYunService);
    }

    public function PushAndSendJiGuang()
    {
        $this->message->Send($this->jiGuangService);
        $this->push->Push($this->jiGuangService);
    }
}

class MessageInfo
{
    public function Send($service)
    {
        $service->Send();
    }
}

class PushInfo
{
    public function Push($service)
    {
        $service->Push();
    }
}

class AliYunService
{
    public function Send()
    {
        echo '发送阿里云短信！', PHP_EOL;
    }
    public function Push()
    {
        echo '推送阿里云通知！', PHP_EOL;
    }
}

class JiGuangService
{
    public function Send()
    {
        echo '发送极光短信！', PHP_EOL;
    }
    public function Push()
    {
        echo '推送极光通知！', PHP_EOL;
    }
}

$send = new Send();
$send->PushAndSendAliYun();
$send->PushAndSendJiGuang();