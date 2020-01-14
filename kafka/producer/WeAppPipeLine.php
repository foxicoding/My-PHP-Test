<?php
/**
 * 小程序日志采集管道
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/08/08
 * Time: 下午2:48
 */
namespace apps\kafka\producer;


class MWeAppPipeLine extends MBasePipeLine {


    /**
     * 数据体处理
     * @param $log
     */
    public  function vPipeLineMain($log){
        $aLog = parent::aPipeLineInput($log);
        $bLog = $this->sPipeLineProcess($aLog['log']);
        //parent::vPipeLineOutPutFB($bLog);
    }

    /**
     * 管道处理日志
     * @param  $log
     * @return array|void
     */
    public  function sPipeLineProcess($log){
        $log = $this->sPipeLineExtend($log);

        return $log;
    }

    /**
     * 自定义字段
     * @param $log
     * @return mixed
     */
    public  function sPipeLineExtend($log){

        return $log;
    }

    /**
     * 数据管道 日志订阅
     * @param $log
     * @return mixed
     */
    public function sPipeLineSubscribe($log){
        //todo

        return $log;
    }



}