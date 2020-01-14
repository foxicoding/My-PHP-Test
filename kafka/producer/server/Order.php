<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/3/16
 * Time: 下午3:50
 */
namespace apps\kafka\producer;
class MServer_Order {

    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendHotelTag($log);

        return $fullLog;
    }


    /**
     * 酒店订单 增加 tag 分类
     * @param $log
     * @return mixed
     */
    public static function aExtendHotelTag($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('order_info_succ' == $eventCode || 'order_info_cancel' == $eventCode){
            if(!empty($attr['poi_id'])){
                $tagData = \apps\hotel\hotel\MFacade_MdtApi::aGetHotelAdjustByHotelId($attr['poi_id']);
                $log['attr']['tag_id'] = $tagData['tag_id'];
                $log['attr']['tag_name'] = $tagData['tag_name'];
            }
        }

        return $log;
    }
}