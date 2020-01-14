<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/10/28
 * Time: 11:29
 */

namespace apps\kafka\log;


class MMini_Preprocess {

    public static function process($topic, array $basic) {
        $basic['topic'] = $topic;
        $basic['mfw_env'] = MFacade_logEnvApi::sGetEnv();

        $basic['uid_admin'] = intval($_SESSION ['admin']['mfwid']);

        // IP相关字段处理
        $basic['service_ip'] = MCommon_CommonApi::getLocalIp();
        $basic['client_ip'] = \Ko_Tool_Ip::SGetClientIP();
        $ip_locator = self::parseIPLocator(\Ko_Tool_Ip::SGetClientIP());
        $basic = array_merge($basic, $ip_locator);

        //时间相关字段处理
        $time = time();
        $basic['service_time'] = $time;
        $basic['ctime'] = $time; //兼容 flink etl
        $basic['date_time'] = date('c', $time);
        $basic['dt'] = date('Ymd', $time);
        $basic['server_hour'] = date('H', $time);
        $basic['server_minute'] = date('i', $time);

        // 解析url相关
        $uri = self::convertHttp($basic['uri']);
        $query_page = self::parseUrlQuery($uri);
        $basic['page_pos_id'] = $query_page['page_pos_id'];
        $basic['page_prm_id'] = $query_page['page_prm_id'];

        // UserAgent相关
        $basic['user_agent'] = \Ko_Web_Request::SHttpUserAgent();

        if(empty($basic['event_code'])) {
            $basic['event_code'] = $basic['event_type'];
        }

        return $basic;
    }

    private static function parseIPLocator($ip) {
        $locator = array();
        if ($ip) {
            $locator = \Ko_Data_IPLocator::OInstance()->aGet($ip);
        }

        if (!empty($locator)) {
            $locator = \Ko_Tool_Array::APick(
                $locator,
                'country',
                'province',
                'city',
                array('isp', 'operator')
            );
        }

        return $locator;
    }

    private static function parseUrlQuery($uri) {
        $result = array();

        if ($uri) {

            $query_str = parse_url($uri)['query'];
            if(!empty($query_str)) {
                $query = null;
                parse_str($query_str, $query);
                if(!is_null($query)) {
                    $result['page_pos_id'] = $query['tops'];
                    $result['page_prm_id'] = $query['tprm'];
                }
            }
        }

        return $result;
    }

    private static function convertHttp($uri) {
        if(strpos($uri, 'http://') === 0 || strpos($uri , "https://") === 0) {
            return $uri;
        }

        return "http://mini.mafengwo.cn/" . $uri;
    }

}