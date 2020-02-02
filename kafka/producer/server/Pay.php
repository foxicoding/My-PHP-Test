<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/3/16
 * Time: 下午3:50
 */
namespace apps\kafka\producer;
class MServer_Pay {

    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendPayCashierSuccessFields($log);

        return $fullLog;
    }


    /**
     * 支付中心 新增字段
     * @param $log
     * @return mixed
     */
    public static function aExtendPayCashierSuccessFields($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('cashier:pay:success' == $eventCode){
            $busi_type = $attr['busi_type'];
            $busi_sorder_id = $attr['busi_sorder_id'];
            if('sales' == $busi_type || 'localdeals' == $busi_type){
                $sorderIds = explode(',',$busi_sorder_id);
                foreach($sorderIds as $sorderId){
                    $orderInfo =  \apps\sales\order\v2\open\MFacade_CommonApi::aOrderInfoForMES($sorderId);
                    if(count($orderInfo)){
                        $new_attr = array_merge($attr,$orderInfo);
                        $log['attr'] = $new_attr;
                        if(!empty($log['attr']['sales_id'])){
                            $bizInfo = \apps\sales\product\MFacade_Info_Getter::aGetBizInfo($log['attr']['sales_id']);
                            $log['attr']['ota_id'] = $bizInfo['ota_id'];
                            $log['attr']['bd_uid'] = $bizInfo['bd_uid'];
                            $log['attr']['biz_line'] = $bizInfo['biz_line'];
                        }
                        break;
                    }
                }
            }
        }

        return $log;
    }
}