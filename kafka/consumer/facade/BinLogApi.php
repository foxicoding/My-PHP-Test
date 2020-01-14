<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午10:35
 */
namespace apps\kafka\consumer;
class MFacade_BinLogApi extends MBinLog_Api
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