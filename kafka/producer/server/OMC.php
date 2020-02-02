<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/2/7
 * Time: 下午3:50
 */
namespace apps\kafka\producer;
class MServer_OMC {

    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendNewDevice($log);

        return $fullLog;
    }


    /**
     * extend omc new device 字段
     * @param $log
     * @return mixed
     */
    public static function aExtendNewDevice($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('new_device_channel' == $eventCode || 'new_device_shumeng_info' == $eventCode){
            //时间
            if(!empty($attr['origin_ctime'])){
                $ctime = $attr['origin_ctime'];
                $log['ctime'] = $ctime;
                $log['datetime'] = date('c', $ctime);
                $log['dt'] = date('Ymd', $ctime);
                $log['hour'] = date('H', $ctime);
                $log['minute'] = date('i', $ctime);

            }
            //open_udid
            if(!empty($attr['origin_open_udid'])){
                $log['open_udid'] = $attr['origin_open_udid'];
            }
            //ip
            if(!empty($attr['origin_ip'])){
                $log['ip'] = $attr['origin_ip'];
            }
            //mfwappcode
            if(!empty($attr['origin_mfwappcode'])){
                $log['mfwappcode'] = $attr['origin_mfwappcode'];
            }
        }

        return $log;
    }
}