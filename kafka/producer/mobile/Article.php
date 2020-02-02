<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/01/31
 * Time: 上午09:55
 */
namespace apps\kafka\producer;
class MMobile_Article {

    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendItemGroup($log);

        return $fullLog;
    }


    /**
     * extend item_group 字段
     * @param $log
     * @return mixed
     */
    public static function aExtendItemGroup($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('home_article_list_show' == $eventCode || 'home_article_list_click' == $eventCode){
            if(isset($attr['item_type'])){
                if(false !== strpos($attr['item_type'],'group')){
                    $log['attr']['item_group'] = 'group';
                }else {
                    $log['attr']['item_group'] = 'item';
                }
            }
        }

        return $log;
    }
}