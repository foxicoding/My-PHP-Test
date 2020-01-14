<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/05/07
 * Time: 下午16:18
 */
namespace apps\kafka;

class MFacade_ConsumerApi extends \apps\kafka\consumer\MFacade_ConsumerApi
{
    /**
     * 订阅 kafka topic 数据
     * @return array
     */
    public  function aConsume(){

        return parent::aConsume();
    }
}