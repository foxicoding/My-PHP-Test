<?php
/**
 * Created by PhpStorm.
 * User: liujinbao
 * Date: 2019/7/16
 * Time: 3:51 PM
 */

interface a{
    public function getInfo();
}
class b implements a{
    public function getInfo()
    {
        echo 111;
    }
    public function getImg()
    {
        echo 456;
    }
}

$b = new b();
$b->getInfo();
$b->getImg();