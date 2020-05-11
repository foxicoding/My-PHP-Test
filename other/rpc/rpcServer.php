<?php

class rpcServer {

    /**
     * User: yuzhao
     * CreateTime: 2018/11/15 下午11:51
     * @var array
     * Description: 此类的基本配置
     */
    private $params = [
        'host'  => '',  // ip地址，列出来的目的是为了友好看出来此变量中存储的信息
        'port'  => '', // 端口
        'path'  => '' // 服务目录
    ];

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:14
     * @var array
     * Description: 本类常用配置
     */
    private $config = [
        'real_path' => '',
        'max_size'  => 2048 // 最大接收数据大小
    ];

    /**
     * User: yuzhao
     * CreateTime: 2018/11/15 下午11:50
     * @var null
     * Description:
     */
    private $server = null;

    /**
     * Rpc constructor.
     */
    public function __construct($params)
    {
        $this->check();
        $this->init($params);
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:0
     * Description: 必要验证
     */
    private function check() {
        $this->serverPath();
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/15 下午11:48
     * Description: 初始化必要参数
     */
    private function init($params) {
        // 将传递过来的参数初始化
        $this->params = $params;
        // 创建tcpsocket服务
        $this->createServer();
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:0
     * Description: 创建tcpsocket服务

     */
    private function createServer() {
        $this->server = stream_socket_server("tcp://{$this->params['host']}:{$this->params['port']}", $errno,$errstr);
        if (!$this->server) exit([
            $errno,$errstr
        ]);
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/15 下午11:57
     * Description: rpc服务目录
     */
    public function serverPath() {
        $path = $this->params['path'];
        $realPath = realpath(__DIR__ . $path);
        if ($realPath === false ||!file_exists($realPath)) {
            exit("{$path} error!");
        }
        $this->config['real_path'] = $realPath;
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/15 下午11:51
     * Description: 返回当前对象
     */
    public static function instance($params) {
        return new RpcServer($params);
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:06
     * Description: 运行
     */
    public function run() {
        while (true) {
            $client = stream_socket_accept($this->server);
            if ($client) {
                echo "有新连接\n";
                $buf = fread($client, $this->config['max_size']);
                print_r('接收到的原始数据:'.$buf."\n");
                // 自定义协议目的是拿到类方法和参数(可改成自己定义的)
                $this->parseProtocol($buf,$class, $method,$params);
                // 执行方法
                $this->execMethod($client, $class, $method, $params);
                //关闭客户端
                fclose($client);
                echo "关闭了连接\n";
            }
        }
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:19
     * @param $class
     * @param $method
     * @param $params
     * Description: 执行方法
     */
    private function execMethod($client, $class, $method, $params) {
        if($class && $method) {
            // 首字母转为大写
            $class = ucfirst($class);
            $file = $this->params['path'] . '/' . $class . '.php';
            //判断文件是否存在，如果有，则引入文件
            if(file_exists($file)) {
                require_once $file;
                //实例化类，并调用客户端指定的方法
                $obj = new $class();
                //如果有参数，则传入指定参数
                if(!$params) {
                    $data = $obj->$method();
                } else {
                    $data = $obj->$method($params);
                }
                // 打包数据
                $this->packProtocol($data);
                //把运行后的结果返回给客户端
                fwrite($client, $data);
            }
        } else {
            fwrite($client, 'class or method error');
        }
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:10
     * Description: 解析协议
     */
    private function parseProtocol($buf, &$class, &$method, &$params) {
        $buf = json_decode($buf, true);
        $class = $buf['class'];
        $method = $buf['method'];
        $params = $buf['params'];
    }

    /**
     * User: yuzhao
     * CreateTime: 2018/11/16 上午12:30
     * @param $data
     * Description: 打包协议
     */
    private function packProtocol(&$data) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}

rpcServer::instance([
    'host'  => '127.0.0.1',
    'port'  => 8888,
    'path'  => './api'
])->run();