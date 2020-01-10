<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/9
 * Time:6:54 下午
 */

/**
 * PHP 5 新增了一个 final 关键字。
 * 如果父类中的方法被声明为 final，则子类无法覆盖该方法。
 * 如果一个类被声明为 final，则不能被继承。
 * https://www.php.net/manual/zh/language.oop5.final.php
 */

class BaseClass1 {
    public function test() {
        echo "BaseClass::test() called\n";
    }

    final public function moreTesting() {
        echo "BaseClass::moreTesting() called\n";
    }
}

class ChildClass extends BaseClass1 {
//    public function moreTesting() {
//        echo "ChildClass::moreTesting() called\n";
//    }
}

(new ChildClass())->moreTesting();
// Results in Fatal error: Cannot override final method BaseClass::moreTesting()


final class BaseClass2 {
    public function test() {
        echo "BaseClass::test() called\n";
    }

    // 这里无论你是否将方法声明为final，都没有关系
    final public function moreTesting() {
        echo "BaseClass::moreTesting() called\n";
    }
}

//class ChildClass extends BaseClass2 {
//}

// 产生 Fatal error: Class ChildClass may not inherit from final class (BaseClass)