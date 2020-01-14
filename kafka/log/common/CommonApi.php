<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午6:46
 */

namespace apps\kafka\log;

class MCommon_CommonApi
{
    const MAX_MESSAGE_BYTES=900000;
    const KAFKA_KEY_DELI = '^';

    /**
     * 服务器host
     * @return string
     */
    public static function getLocalIp(){
        return gethostname();
    }

    /**
     * 客户端访客设备标识
     * @return string
     */
    public static function getOpenUdid(){
        $open_udid = \Ko_Web_Request::SInput('open_udid');
        if(empty($open_udid)) {
            $open_udid = isset($_COOKIE['__openudid'])?$_COOKIE['__openudid']:'-1';
        }
        return $open_udid;
    }

    /**
     * 获取ios idfa
     * @return mixed|string
     */
    public static function getIDFA(){
        $idfa = \Ko_Web_Request::SInput('idfa');
        if(empty($idfa)) {
            $idfa = isset($_COOKIE['__idfa'])?$_COOKIE['__idfa']:'';
        }
        return $idfa;
    }

    /**
     * 获取ios idfv
     * @return mixed|string
     */
    public static function getIDFV(){
        $idfv = \Ko_Web_Request::SInput('idfv');
        if(empty($idfv)) {
            $idfv = isset($_COOKIE['__idfv'])?$_COOKIE['__idfv']:'';
        }
        return $idfv;
    }

    /**
     * 空文件创建及权限更改
     * @param $filename
     */
    public static function checkFileMod($filename){
        if(!is_file($filename)){
            touch($filename);
            chmod($filename,0777);
        }
    }

    /**
     * 目录检查及创建
     * @param $log_dir
     */
    public static function checkLogDir($log_dir){
        if (!is_dir($log_dir)) {
            @mkdir($log_dir);
            @chmod($log_dir, 0777);
        }
    }

    /**
     * 校验 key
     * @param $key
     * @return bool
     */
    public static function checkValidKey($key)
    {
        $key = strval($key);
        return 1 === preg_match("/^[0-9a-zA-Z\_]*$/", $key);
    }

    /**
     * 获取basic.abtest
     * @param $curl
     * @return string
     */
    public static function getABTest($curl)
    {
        $appSysConfig = 'mapi.mafengwo.cn/system/config/get_global_config';
        return (!empty($_SERVER['HTTP_ABTEST']) && false === strpos($curl, $appSysConfig))
            ? $_SERVER['HTTP_ABTEST'] : '';
    }
}