<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:2:54 下午
 */

namespace design_pattern\decorator\code;

abstract class shapeDecorator implements shape
{
    protected $decoratorShape;

    public function __construct(shape $decoratorShape)
    {
        $this->decoratorShape = $decoratorShape;
    }

    public function Draw()
    {
        $this->decoratorShape->Draw();
    }
}