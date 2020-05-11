<?php
/**
 * Created by PhpStorm.
 * User: liujinbao
 * Date: 2019/7/12
 * Time: 11:45 AM
 */

//
//class App
//{
//    protected $routes = [];
//    protected $responseStatus = '200 OK';
//    protected $responseContentType = 'text/html';
//    protected $responseBody = 'Hello World';
//
//    public function __construct()
//    {
//
//    }
//
//    public function addRoute($path,$callback)
//    {
//        $this->routes[$path] = $callback->bindTo($this,__CLASS__);
//    }
//
//    public function disPath($path)
//    {
//        foreach ($this->routes as $routePath => $callback) {
//            if( $routePath === $path) {
//                $callback();
//            }
//        }
//        header('HTTP/2 ' . $this->responseStatus);
//        header('Content-Type: ' . $this->responseContentType);
//        header('Content-Length: ' . mb_strlen($this->responseBody));
//        echo $this->responseBody;
//    }
//}
//
///**
// * PHP 7+ code
// * @return mixed
// */
////$a = function (){
////    return $this->responseBody;
////};
////var_dump($a->call(new App));exit;
//
//
//
//$app = new App();
//$app->addRoute('/user', function(){
//    $this->responseContentType = 'application/json;charset=utf8';
//    $this->responseBody = 'hello world';
//});
//$app->disPath('/user');


function getMoney()
{
    $rmb = 1;
    return function () use ($rmb){
        echo ++$rmb;
    };
}

//$money = getMoney();
//$money();
//$money();
$a = [1,2,3,&$a,&$a];
unset($a);
xdebug_debug_zval('a');