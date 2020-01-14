<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午10:53
 */
namespace apps\kafka;

class MFacade_PageConsumerApi extends \apps\kafka\consumer\MFacade_PageApi
{
    /**
     * 订阅 page_event 相关事件
     * @return array
     */
    public  function aConsume(){

        return parent::aConsume();
    }
}