<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午10:53
 */
namespace apps\kafka;

class MFacade_ServerConsumerApi extends \apps\kafka\consumer\MFacade_ServerApi
{
    /**
     * 订阅 server_event 相关事件
     * @return array
     */
    public  function aConsume(){

        return parent::aConsume();
    }
}