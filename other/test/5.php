<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/14
 * Time:12:17 下午
 */



/**
 * get_class (): 获取当前调用方法的类名；
 * get_called_class():获取静态绑定后的类名(谁调用返回谁)；
 */
class Foo{
    public function test(){
        var_dump(get_class());
    }

    public function test2(){
        var_dump(get_called_class());
    }

    public static function test3(){
        var_dump(get_class());
    }

    public static function test4(){
        var_dump(get_called_class());
    }
}

class B extends Foo{

}

$B = new B();
$B->test();
$B->test2();
Foo::test3();
Foo::test4();
B::test3();
B::test4();

/**
 * 输出结果：
string 'Foo' (length=3)
string 'B' (length=1)
string 'Foo' (length=3)
string 'Foo' (length=3)
string 'Foo' (length=3)
string 'B' (length=1)
 */