<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午7:17
 */
namespace apps\kafka\log;

class MCommon_SpiderApi
{
    protected static $spiderUA = array(
        'Baiduspider','BingPreview','Googlebot',
        'Ucmobile','YodaoBot','Yahoo! Slurp',
        'Sogou web spider','Sogou Push Spider',
        'msnbot','360Spider','zpSpider', 'Bytespider', 'googleweblight'
    );

    protected static $pageEventCode = array(
        'logdata','click_area','page_behaviors'
    );

    /**
     * 过滤爬虫数据
     * @param $log
     */
    public static function vCreate(&$log) {
        if($log['uid'] > 0){
            return;
        }
        $app_code = $log['app_code'];
        $event_code = $log['event_code'];
        //标准爬虫 遵循 robots规则
        $spider = self::vIsSpider($log['ua']);
        if($spider){
            $log['app_code'] = "spider";
            $log['event_code'] = $spider;
        }

        if($log['app_code'] == 'spider'){
            $log['attr']['origin_app_code'] = $app_code;
            $log['attr']['origin_event_code'] = $event_code;
        }
    }

    /**
     * 标准爬虫 遵循 robots规则
     * @param $ua
     * @return bool
     */
    public static function vIsSpider($ua){
        foreach(self::$spiderUA as $spider){
            if(strpos($ua,$spider)!== false) {
                return $spider;
            }
        }

        return;
    }

    /**
     * 针对流量过滤
     * @param $log
     */
    public static function vPageCreate(&$log){
        if(in_array($log['event_code'],self::$pageEventCode)){
            self::vCreate($log);
        }
    }

    public static function vWebEventSpider(&$log) {
        /**
         * 1. 如果包含uid，则不过滤
         * 2. 标准robots过滤，判断
         * 3. 如果为spider，则将app_code 改为 spider，属于何种spider进行保存，并将原始的app_code进行保存
        */

        if($log['uid'] > 0) {
            return;
        }

        $app_code = $log['app_code'];
        $spider = self::vIsSpider($log['user_agent']);
        if($spider) {
            $log['app_code'] = 'spider';
            $log['item_info']['origin_app_code'] = $app_code;
            $log['item_info']['spider_type'] = $spider;
        }
    }
}