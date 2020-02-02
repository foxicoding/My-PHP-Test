<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */
namespace apps\kafka\log;


class MPost_SDKApi
{

    /**
     * sche phperror 等数据采集
     * @param $log
     * @return bool
     */
    public static function vCollect($log){
        if (strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES ) {
            return;
        }
        $fid = mt_rand(1, 10);

        //目录检查及创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'post/';
        MCommon_CommonApi::checkLogDir($log_dir);

        $filename = $log_dir . 'post.' . date('YmdHi') . ".$fid";
        return file_put_contents($filename, $log , FILE_APPEND | LOCK_EX);
    }

}