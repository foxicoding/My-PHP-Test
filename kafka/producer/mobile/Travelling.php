<?php
namespace apps\kafka\producer;
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/4/10
 * Time: 下午12:40
 */
class MMobile_Travelling
{


    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log)
    {
        $fullLog = self::aExtendTravellingStatus($log);

        return $fullLog;
    }


    /**
     * 根据open_udid 来判定用户是否在行中
     * @param $log
     * @return mixed
     */
    public static function aExtendTravellingStatus($log)
    {
        $eventCode = $log['event_code'];
        $open_udid = $log['open_udid'];
        $umddid = $log['umddid'];

        if (in_array($eventCode,MMobile_TravellingConf::$travellingCode)) {
           try{
               if(!empty($umddid)){
                   $status = \apps\uds\MFacade_onlineApi::getTravellingStatusByOpenudid($open_udid,$umddid);
                   $log['attr']['travel_status'] = json_encode($status);
                   //打平二级key,方便下游计算
                   if(count($status)){
                       foreach($status as $k => $v){
                           $log['attr']["travel_status.$k"] = $v;
                       }
                   }
               }

           }catch (\Exception $e) {

           }
        }
        return $log;
    }
}