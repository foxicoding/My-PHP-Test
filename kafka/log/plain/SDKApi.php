<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */
namespace apps\kafka\log;

class MPlain_SDKApi
{

    /**
     * sche phperror 等数据采集
     * @param $type
     * @param $content
     */
    public static function vCollect($type,$content){
        $type = str_replace(array("\t", "\r", "\n", '$'), ' ', $type);
        $content = str_replace(array("\r", "\n"), ' ', $content);

        $time = time();
        $log = date('Y-m-d H:i:s', $time)."\t".MCommon_CommonApi::getLocalIp()
            ."\t".$type.'$$'.$content;

        //目录检查及创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'plain/';
        MCommon_CommonApi::checkLogDir($log_dir);

        $filename = $log_dir. 'plain.' . date('YmdHi', $time);
        file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);
        if ('cli' === PHP_SAPI)
        {
            chmod($filename, 0666);
        }
    }

}