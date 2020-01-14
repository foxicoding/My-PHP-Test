<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/11/23
 * Time: 下午2:34
 */
namespace apps\kafka\producer;
abstract class  MBasePipeLine {

    /**
     * 数据管道 输入
     * @param $log
     * @return array
     */
    public  function aPipeLineInput($log){
        if(stripos($log,'^{"') !== false){
            list($key,$log) = explode('^',$log,2);
            return array(
                'key' => $key,
                'log' => json_decode($log,true)
            );
        }else {
            return array(
                'log' => json_decode($log,true)
            );
        }
    }

    /**
     * @param $key
     * @param array $log
     * @return mixed
     */
    public  function sPipeLineOutPut($key,$log){
        if($this->bPipeLineCheck($log)){
            $sLog = json_encode($log);
            echo $key.'^'.$sLog."\n";
        }
    }

    /**
     * @param array $log
     * @return mixed
     */
    public  function sPipeLineOutPutNoKey($log){
        if($this->bPipeLineCheck($log)){
            $sLog = json_encode($log);
            echo $sLog."\n";
        }
    }

    /**
     * 日志写入filebeat目录,供filebeat采集
     * @param $log
     */
    public function vPipeLineOutPutFB($log){
        if ($this->bPipeLineCheck($log)) {
            $topic = $log['topic'];
            $dir = COMMON_RUNDATA_PATH."filebeat.$topic/";
            if (!is_dir($dir)) {
                @mkdir($dir);
                @chmod($dir, 0777);
            }
            $filename = $dir.date('Ymd').'.'.posix_getuid().'.'.rand(0, 9);
            $logContent = json_encode($log);
            @file_put_contents($filename, $logContent."\n", FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * 数据管道 日志校验
     * @param $log
     * @return bool
     */
    public function bPipeLineCheck($log){
        if(!isset($log['app_code']) || !isset($log['event_code'])){
            return false;
        }
        return true;
    }

    /**
     * 数据管道 日志字段补充
     * @param $log
     * @return mixed
     */
    abstract function sPipeLineExtend($log);

    /**
     * 数据管道 日志处理
     * @param array $log
     * @return mixed
     */
    abstract   function sPipeLineProcess($log);

    /**
     * 数据管道 日志订阅
     * @param $log
     * @return mixed
     */
    abstract   function sPipeLineSubscribe($log);

}