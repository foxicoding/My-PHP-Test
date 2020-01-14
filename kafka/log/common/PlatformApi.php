<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:26
 */

namespace apps\kafka\log;

class MCommon_PlatformApi {

    CONST Mobile_Platform_FIX = "蚂蜂窝自由行/7.";

    /**
     * 按host解析平台
     * @param $host
     * @return array
     */
    public static function vCreate($curl) {

        return array(
            'platform' => self::vGetPlatform($curl),
            'mfwappcode' => self::vGetMfwAppCode(),
            'ua' => $_SERVER["HTTP_USER_AGENT"]
        );
    }


    /**
     * 获取平台
     * @param $curl
     * @return string
     */
    public static function vGetPlatform($curl = '') {
        $platform = '';

        $mfwAppCode = self::vGetMfwAppCode();
        if (!empty($mfwAppCode)) {
            $platform = 'app';
        } else {
            $miniPlatform = self::sGetMiniAppPlatform();
            if (!empty($miniPlatform)) {
                $platform = $miniPlatform;
            } else {
                $purl = parse_url($curl);
                if ($purl && isset($purl['host'])) {
                    $host = $purl['host'];
                } else {
                    $host = $_SERVER['HTTP_HOST'];
                }

                //获取host
                if (!empty($host)) {
                    $aHost = explode('.', $host);
                } else {
                    $aHost = array();
                }

                if (count($aHost)) {
                    if ($aHost[0] == 'www') {
                        $platform = 'www';
                    } else if ($aHost[0] == 'm') {
                        $platform = 'm';
                    } else {
                        $platform = 'else';
                    }
                }
            }
        }

        $ua = $_SERVER["HTTP_USER_AGENT"];
        //修复ios 7.x.x.x platform 归属
        if ($_SERVER['REQUEST_URI'] == "/mobilelog/rest/EventLog/"
            && false !== strpos(urldecode($ua), self::Mobile_Platform_FIX)) {
            $platform = 'app';
        }

        return $platform;
    }

    /**
     * 获取mfwappcode
     * @return string
     */
    public static function vGetMfwAppCode() {
        return \apps\MFacade_Mobile_RequestApi::SLoggerAppCode();
    }

    public static function vGetMfwAppVer() {
        return \apps\MFacade_Mobile_RequestApi::SAppVersion();
    }

    public static function vGetMfwDevVer() {
        return \apps\MFacade_Mobile_RequestApi::SAppDevVersion();
    }

    public static function sGetMiniAppPlatform() {
        $platform = \apps\miniapp\MFacade_WebView::sGetPlatformByUA();
        if($platform === 'wx') {
            $platform = 'wxapp';
        }

        return $platform;
    }
}


