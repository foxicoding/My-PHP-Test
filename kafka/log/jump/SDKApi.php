<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */
namespace apps\kafka\log;


class MJump_SDKApi
{

    /**
     * 短链跳转日志采集
     * @param $log
     * @return bool
     */
    public static function vCollect($log){
        //目录检查及创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'jump/';
        MCommon_CommonApi::checkLogDir($log_dir);

        $filename = $log_dir.'jump.' . date('YmdHi');
        if (strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES )
            return;
        return file_put_contents($filename, $log , FILE_APPEND | LOCK_EX);
    }

}