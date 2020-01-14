<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/5/24
 * Time: 15:11
 */

namespace apps\kafka\log;

class MWeb_FileSDK {

    /**
     *
     * 终端监控日志采集
     *
     * @param $topic
     * @param array $basic
     * @param array $attr
     *
     */
    public static function collect($topic, array $basic, array $attr = array()) {
        $log = MWeb_WebPreprocess::process($topic, $basic, $attr);
        self::write($topic, $log);
    }


    /**
     * @param $topic
     * @param $log
     */
    private static function write($topic, $log) {
        $data = json_encode($log);
        if (empty($data) || strlen($data) > MCommon_CommonApi::MAX_MESSAGE_BYTES) {
            return;
        }

        if(empty($topic) || is_null($topic)) {
            return;
        }

        $path = MFacade_logEnvApi::sGetLogPath() . $topic . '/';
        MCommon_CommonApi::checkLogDir($path);

        $filename = $path . $topic . '.' . date('YmdHi');
        MCommon_CommonApi::checkFileMod($filename);

        @file_put_contents($filename, $data . "\n", FILE_APPEND | LOCK_EX);
    }

}