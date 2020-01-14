<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/5/27
 * Time: 10:16
 */

namespace apps\kafka\log;

class MWeb_WebPreprocess {

    /**
     *
     * 预处理日志
     *
     * @param $topic
     * @param array $basic
     * @param array $attr
     * @return array
     */
    public static function process($topic, array $basic, array $attr = array()) {
        $basic['topic'] = $topic;
        $basic['mfw_env'] = MFacade_logEnvApi::sGetEnv();

        // 处理User-Agent相关
        $basic['user_agent'] = \Ko_Web_Request::SHttpUserAgent();
        $user_agent = self::parseUserAgent(\Ko_Web_Request::SHttpUserAgent());
        $basic['sys_type'] = $user_agent['sys'];
        $basic['sys_ver'] = $user_agent['sys_ver'];
        $basic['browser_type'] = $user_agent['browser'];
//        $basic['browser_major'] = $user_agent['browser_major'];
        $basic['browser_ver'] = $user_agent['browser_ver'];
        $basic['device_brand'] = $user_agent['brand'];
        $basic['device_model'] = $user_agent['hardware_model'];
        $basic['browser_kernel'] = $user_agent['kernel'];
        $basic['browser_kernel_ver'] = $user_agent['kernel_ver'];
        $basic['device_type'] = $user_agent['device_type'];
        $basic['app_ver'] = \apps\MFacade_Mobile_RequestApi::SAppVersion();
        $basic['dev_ver'] = \apps\MFacade_Mobile_RequestApi::SAppDevVersion();

        // 处理IP相关
        $basic['client_ip'] = \Ko_Tool_Ip::SGetClientIP();
        $basic['service_ip'] = MCommon_CommonApi::getLocalIp();
        $ip_locator = self::parseIPLocator(\Ko_Tool_Ip::SGetClientIP());
        $basic = array_merge($basic, $ip_locator);


        // 获取服务器事件相关
        $time = time();
        $basic['service_time'] = $time;
        $basic['date_time'] = date('c', $time);
        $basic['dt'] = date('Ymd', $time);
        $basic['server_hour'] = date('H', $time);
        $basic['server_minute'] = date('i', $time);


        // 用户id相关
        $basic['uid'] = \apps\user\MFacade_Api::iLoginUid();
        $basic['uuid'] = \apps\MFacade_Tongji_UuidApi::vGet();
        $basic['uid_admin'] = intval($_SESSION ['admin']['mfwid']);


        // Cookie相关
        $basic['device_id'] = self::parseDeviceId();
        $basic['mfwa'] = self::parseCookie('__mfwa');
        $basic['eid'] = self::parseCookie('gateway:eid');

        $mfwb = self::parseCookieMfwb();
        $basic['session_id'] = $mfwb['session_id'];
        $basic['index_in_launch'] = $mfwb['index_in_launch'];
        $basic['chanel_ref'] = $mfwb['chanel_ref'];

        $basic['ifu_chid_ifu'] = self::parseCookie('ifu_chid_ifu');


        // 解析url相关
        $uri = $basic['uri'];
        $query_page = self::parseUrlQuery($uri);
        $basic['page_pos_id'] = $query_page['page_pos_id'];
        $basic['page_prm_id'] = $query_page['page_prm_id'];

        $basic['app_code'] = self::parseAppcode($uri);
        $basic['data_source'] = self::parseDataSource($uri);


        $basic['u_loc_mdd_id'] = '';
        $basic['intent_mddid'] = '';
        $basic['lat'] = '';
        $basic['lng'] = '';

        if(empty($basic['event_code'])) {
            $basic['event_code'] = $basic['event_type']; //为了部落，为了鹏鹏
        }

        MCommon_SpiderApi::vWebEventSpider($basic); // 爬虫标记
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

    private static function parseUserAgent($ua) {
        $agent = array();
        if($ua) {
            $parser = new MCommon_UserAgentParser();
            $agent = $parser->mfwUAParser($ua);
        }

        if(!empty($agent)) {
            $agent = \Ko_Tool_Array::APick(
                $agent,
                'sys',
                'sys_ver',
                'browser',
                'browser_major',
                'browser_ver',
                'brand',
                'hardware_model',
                'kernel',
                'kernel_ver',
                'device_type'
            );
        }

        return $agent;
    }

    private static function parseDeviceId() {
        $device_id = MCommon_CommonApi::getOpenUdid();
        if(empty($device_id) || $device_id == -1) {
            $device_id = \apps\MFacade_Tongji_UuidApi::vGet();
        }

        return $device_id;
    }

    private static function parseCookieMfwb() {
        $result = array();
        $mfwb = self::parseCookie('__mfwb');
        if(!empty($mfwb)) {
            $disrupt = explode('.', $mfwb);

            if(count($disrupt) > 2) {
                $result['session_id'] = $disrupt[0];
                $result['index_in_launch'] = $disrupt[1];
                $result['chanel_ref'] = $disrupt[2];
            }
        }

        return $result;
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

    private static $DATA_SOURCE_MAP = array(
        'www.mafengwo.cn' => 'www',
        'z.mafengwo.cn' => 'www',
        '360.mafengwo.cn' => 'www',
        'www.mafengwo.sg' => 'www',
        'qq.mafengwo.cn' => 'www',
        '3rd.mafengwo.cn' => 'www',
        'huoche.mafengwo.cn' => 'www',
        'zx.mafengwo.cn' => 'www',
        'm.mafengwo.cn' => 'm',
        'w.mafengwo.cn' => 'm',
        'm.mafengwo.sg' => 'm',
        'passport.mafengwo.cn' => 'm',
        'payitf.mafengwo.cn' => 'm',
        'topic.mafengwo.cn' => 'm',
        'ulink.mafengwo.cn' => 'm',
        'market.mafengwo.cn' => 'm',
        'b.mafengwo.cn' => 'business',
        'seller.mafengwo.cn' => 'business',
        'sales-admin.mafengwo.cn' => 'business',
        'pagelet.mafengwo.sg' => 'business'
    );

    private static function parseAppcode($uri) {
        $result = MCommon_PlatformApi::vGetMfwAppCode();

        if(empty($result)) {
            $result = self::dataSourceUrlMap($uri);
        }
        return $result;
    }

    private static function parseDataSource($uri) {
        $result = MCommon_PlatformApi::vGetMfwAppCode();

        if(empty($result)) {
            $result = MCommon_PlatformApi::sGetMiniAppPlatform();
            if(empty($result)) {
                $result = self::dataSourceUrlMap($uri);
            }
        } else {
            $result = self::formatAppCode($result);
        }

        return $result;
    }

    private static function dataSourceUrlMap($uri) {
        $result = 'other';

        if($uri) {
            $info = parse_url($uri);
            if($info && isset($info['host'])) {
                $dl = self::$DATA_SOURCE_MAP[$info['host']];
                if(!is_null($dl)) {
                    $result = $dl;
                }
            }
        }

        return $result;
    }

    private static function formatAppCode($appCode) {
        $result = 'other';
        if(in_array($appCode, array('cn.mafengwo.www', 'com.mfw.roadbook', 'cn.mafengwo.www.ipad'))) {
            $result = 'app';
        }

        return $result;
    }

    private static function parseCookie($key) {
        return urldecode(\Ko_Tool_Input::VClean('c', $key, \Ko_Tool_Input::T_STR));
    }

}