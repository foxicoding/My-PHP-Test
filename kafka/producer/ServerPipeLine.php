<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/11/23
 * Time: 下午2:48
 */
namespace apps\kafka\producer;


class MServerPipeLine extends MBasePipeLine {


    /**
     * 数据体处理
     * @param $log
     */
    public  function vPipeLineMain($log){
        $aLog = parent::aPipeLineInput($log);
        $bLog = $this->sPipeLineProcess($aLog['log']);
        //切换新的日志清洗管道
        $c_minute = date('YmdHi',$bLog['ctime']);
        if($c_minute < 201810181500){
            parent::vPipeLineOutPutFB($bLog);
        }else if($c_minute >= 201811301137 && $c_minute <= 201811301200 ){
            parent::sPipeLineOutPutNoKey($bLog);
        }
    }

    /**
     * 管道处理日志
     * @param  $log
     * @return array|void
     */
    public  function sPipeLineProcess($log){
        //日志字段补充
        $log = $this->sPipeLineExtend($log);

        //切换新的日志清洗管道
        $c_minute = date('YmdHi',$log['ctime']);
        if($c_minute < 201810181500){
            //日志订阅
            $this->sPipeLineSubscribe($log);

        }

        return $log;
    }

    /**
     * 自定义字段
     * @param $log
     * @return mixed
     */
    public  function sPipeLineExtend($log){
        $fullLog  = MServer_OMC::aExtendFieldsMain($log);
        $fullLog  = MServer_Pay::aExtendFieldsMain($fullLog);
        $fullLog  = MServer_Order::aExtendFieldsMain($fullLog);
        return $fullLog;
    }

    /**
     * 数据管道 日志订阅
     * @param $log
     * @return mixed
     */
    public function sPipeLineSubscribe($log){
        $app_code = $log['app_code'];
        $event_code = $log['event_code'];
        $subScribeCode = $app_code.'#'.$event_code;
        switch($subScribeCode){
            case 'default#h5ToApp':
                \apps\coop\MFacade_deviceApi::getServerEvent($log);
                break;
        }
    }

}