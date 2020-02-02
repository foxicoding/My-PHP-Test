<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/2/7
 * Time: 下午3:50
 */
namespace apps\kafka\producer;
class MPage_Brand {

    //推广品牌关键词
    protected static $brandKeyword = array(
        '黄轩','蚂蜂','马蜂','蜂窝','唐僧'
    );
    //keyword 匹配
    protected static $keyPattern = "/(?:\\?|&)(?:query|word|keyword|w|q|wd|kw|key|k)=([^&]*)/i";
    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendIsBrandKeyword($log);

        return $fullLog;
    }


    /**
     * extend is_brand_keyword 字段
     * @param $log
     * @return mixed
     */
    public static function aExtendIsBrandKeyword($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];

        if('logdata' == $eventCode){
            $log['attr']['is_brand_keyword'] = 0;
            $refer = urldecode($attr['refer']);
            preg_match(self::$keyPattern,$refer,$keywords);
            if(count($keywords) > 1){
                //品牌词日志标识
                foreach(self::$brandKeyword as $keyword){
                    if(strpos($keywords[1],$keyword)!== false) {
                        $log['attr']['is_brand_keyword'] = 1;
                        break;
                    }
                }
            }
        }
        return $log;
    }
}