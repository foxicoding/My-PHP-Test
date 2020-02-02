<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午7:20
 */

namespace apps\kafka\log;

class MServer_CustomApi
{
    /**
     * 字段特殊处理
     * @param $log
     */
    public static function vCreate(&$basic){
        switch ($basic['event_code']) {
            case 'order_create':
            case 'go_to_pay':
            case 'order_pay':
                if(!empty($basic['attr']['uuid'])){
                    $basic['attr']['uuid_origin'] = $basic['uuid'];
                    $basic['uuid'] = $basic['attr']['uuid'];
                }
                break;
            default:
                break;
        }
    }
}