<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/3/15
 * Time: 下午3:50
 */
namespace apps\kafka\producer;
class MPage_Logdata {


    //活动Id 匹配
    protected static $keyActivityPattern = "/activity\\/promotion\\/(\\d+)/i";
    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendActivityId($log);
        $fullLog = self::aExtendSalesBizInfo($fullLog);
        $fullLog = self::aExtendIsMainLand($fullLog);

        return $fullLog;
    }


    /**
     * extend Activity Id 字段
     * @param $log
     * @return mixed
     */
    public static function aExtendActivityId($log){
        $eventCode = $log['event_code'];
        $curl = $log['curl'];

        if('logdata' == $eventCode){
            $curl = urldecode($curl);
            preg_match(self::$keyActivityPattern,$curl,$activityIds);
            if(count($activityIds) > 1){
                if(!empty($activityIds[1])){
                    $log['attr']['activity_id'] = $activityIds[1];
                }
            }
        }
        return $log;
    }

    /**
     * 衍生 网页流量 附加ota_id bd_uid biz_line等字段
     * @param $log
     * @return mixed
     */
    public static function aExtendSalesBizInfo($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('logdata' == $eventCode && !empty($attr['sales_id'])){
            if('sales' == $attr['root'] && 'detail' == $attr['leaf1']){
                $bizInfo = \apps\sales\product\MFacade_Info_Getter::aGetBizInfo($attr['sales_id']);
                $log['attr']['ota_id'] = $bizInfo['ota_id'];
                $log['attr']['bd_uid'] = $bizInfo['bd_uid'];
                $log['attr']['biz_line'] = $bizInfo['biz_line'];
            }

        }
        return $log;
    }

    /**
     * 根据目的地id 衍生是否大陆
     * @param $log
     * @return mixed
     */
    public static function aExtendIsMainLand($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('logdata' == $eventCode && !empty($attr['mddid'])){
            if('hotel' == $attr['root'] && 'detail' == $attr['leaf1']){
                $isMainLand = \apps\mdd\MFacade_mddApi::iRange($attr['mddid']);
                $log['attr']['is_mainland'] = $isMainLand;
            }

        }
        return $log;
    }
}