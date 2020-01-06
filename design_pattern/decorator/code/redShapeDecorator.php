<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:2:56 下午
 */

namespace design_pattern\decorator\code;

class redShapeDecorator extends shapeDecorator
{
    public function __construct(shape $decoratorShape)
    {
        parent::__construct($decoratorShape);
    }

    public function Draw()
    {
        $this->decoratorShape->Draw();
        $this->setRedColor($this->decoratorShape);
    }

    private function setRedColor(shape $shape)
    {
        echo 'red';
    }
}