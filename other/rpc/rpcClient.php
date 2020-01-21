<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/19
 * Time:3:05 下午
 */

class rpcClient
{
    /**
     * 调用的接口地址
     * @var array|false|int|string|null
     */
    private $urlInfo = [];

    public function __construct($url)
    {
        $this->urlInfo = parse_url($url);
    }

    public function __call($name, $arguments)
    {
        //创建一个客户端
        $client = stream_socket_client(
            "tcp://{$this->urlInfo['host']}:{$this->urlInfo['port']}",
            $errno,
            $errstr
        );
        if (!$client){
            exit("{$errno} : {$errstr} \n");
        }
        $data = [
            'class'  => basename($this->urlInfo['path']),
            'method' => $name,
            'params' => $arguments
        ];
        //像服务端发送我们自定义的协议数据
        fwrite($client,json_encode($data));
        //读取服务端传来的数据
        $data = fread($client, 2048);
        //关闭客户端
        fclose($client);
        return $data;
    }
}

$cli = new RpcClient('http://127.0.0.1:8888/test');
echo $cli->tuzisir1()."\n";
echo $cli->tuzisir2(array('name' => 'tuzisir', 'age' => 23));