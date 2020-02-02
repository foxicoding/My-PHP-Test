<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/11/23
 * Time: 下午3:13
 */
namespace apps\kafka\producer;
class MMobile_Hotel {

    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendAdminId($log);
        $fullLog = self::aExtendHotelMddid($fullLog);
        $fullLog = self::aExtendCheckInOut($fullLog);
        $fullLog = self::aExtendIndexGuide($fullLog);
        $fullLog = self::aExtendExtra($fullLog);
        $fullLog = self::aExtendHotelTag($fullLog);
        $fullLog = self::aExtendOpenUdid($fullLog);

        return $fullLog;
    }

    /**
     * 获取酒店房型 维护员工 & 运营组 & 是否有房型
     * @param $log
     * @return mixed
     */
    public static function aExtendAdminId($log){
        $attr = $log['attr'];
        if(!empty($attr['hotel_id'])){
            $hotel_admin_id = \apps\hotel\room\MFacade_RoomTaskApi::getActUserByHotelId($attr['hotel_id']);
            if(!empty($hotel_admin_id)){
                $log['attr']['hotel_admin_id'] = $hotel_admin_id;
                $hotel_admin_group = \apps\hotel\room\MFacade_RoomUserApi::iGetGroupByUid($hotel_admin_id);
                if(!empty($hotel_admin_group)){
                    $log['attr']['hotel_admin_group'] = $hotel_admin_group;
                }
                $log['attr']['is_room'] = 1;
            } else {
                $log['attr']['is_room'] = 0;
            }
        }
        return $log;
    }

    /**
     * 获取酒店所在目的地 id
     * @param $log
     * @return mixed
     */
    public static function aExtendHotelMddid($log){
        $attr = $log['attr'];
        if(!empty($attr['hotel_id'])){
            $mddid = \apps\hotel\hotel\MFacade_BaseApi::iGetPriorityMddidByHotelId($attr['hotel_id']);
            if(!empty($mddid)){
                $log['attr']['mddid'] = $mddid;
            }
        }
        return $log;
    }

    /**
     * 按酒店Id获取其tag_id和tag_name
     * @param $log
     * @return mixed
     */
    public static function aExtendHotelTag($log){
        $attr = $log['attr'];
        $event_code = $log['event_code'];
        if(in_array($event_code,MMobile_HotelConf::$tagNameCode) && !empty($attr['hotel_id'])){
            $tagData = \apps\hotel\hotel\MFacade_MdtApi::aGetHotelAdjustByHotelId($attr['hotel_id']);
            $log['attr']['tag_id'] = $tagData['tag_id'];
            $log['attr']['tag_name'] = $tagData['tag_name'];
        }
        return $log;
    }

    /**
     * 衍生check_inout字段
     * @param $log
     * @return mixed
     */
    public static function aExtendCheckInOut($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        $checkInOutCode = MMobile_HotelConf::$checkInOutCode;
        foreach($checkInOutCode as $fd => $mergeSource){
            foreach($mergeSource as $s_fd => $source){
                list($fd1,$fd2) = explode('-',$s_fd);
                if(isset($attr[$fd1]) && isset($attr[$fd2]) && in_array($eventCode,$source)){
                    $f_fd1 = str_replace('-','',$attr[$fd1]);
                    $f_fd2 = str_replace('-','',$attr[$fd2]);
                    if(!empty($f_fd1) && !empty($f_fd2)){
                        $log['attr'][$fd] = "${f_fd1}-${f_fd2}";
                    }
                }
            }
        }

        return $log;
    }

    /**
     * 衍生 item_type_fix字段
     * @param $log
     * @return mixed
     */
    public static function aExtendIndexGuide($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        $itemTypeConf = array(
            'index_sales',
            'index_article',
            'index_article_hotel',
            'index_article_mdd'
        );
        if('home_article_list_show' == $eventCode || 'home_article_list_click' == $eventCode){
            if(isset($attr['item_type'])){
                if(in_array($attr['item_type'],$itemTypeConf)){
                    $log['attr']['item_type_fix'] = 'index_guide';
                }else {
                    $log['attr']['item_type_fix'] = $attr['item_type'];
                }
            }
        }
        return $log;
    }

    /**
     * 根据attr.extra 衍生 attr.extra.xxx
     * @param $log
     * @return mixed
     */
    public static function aExtendExtra($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];

        if('hotel_detail_room_policy_show' == $eventCode){
          if(isset($attr['extra'])){
              $extra = json_decode($attr['extra']);
              if(count($extra)){
                  foreach($extra as $k => $v){
                      if('rate_plan_first_ota' == $k){
                          $log['attr']["extra.$k"] = $v;
                          break;
                      }
                  }
              }
          }
        }
        return $log;
    }

    /**
     * 把 basic.open_udid 放到 attr
     * @param $log
     * @return mixed
     */
    public static function aExtendOpenUdid($log){
        $eventCodeList=array('hotel_detail_module_click', 'hotel_detail_module_show');

        $eventCode = $log['event_code'];
        if(!empty($eventCode) && in_array($eventCode, $eventCodeList)){
            $openUdid = $log['open_udid'];
            if(!empty($openUdid)){
                $log['attr']["open_udid"] = $openUdid;
            }
        }
        return $log;
    }

}