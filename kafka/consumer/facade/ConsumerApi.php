<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/16
 * Time: 下午7:19
 */
namespace apps\kafka\consumer;
class MFacade_ConsumerApi extends MConsumer_Api
{

    /**
     * 消费数据
     * @return array
     * @throws \Exception
     */
    public  function aConsume(){
        return parent::aConsume();
    }

}