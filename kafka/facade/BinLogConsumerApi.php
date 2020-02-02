<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午10:53
 */
namespace apps\kafka;

class MFacade_BinLogConsumerApi extends \apps\kafka\consumer\MFacade_BinLogApi
{
    /**
     * 订阅 mysql binlog 相关表
     * @return array
     */
    public  function aConsume(){

        return parent::aConsume();
    }
}