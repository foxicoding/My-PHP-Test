<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/8/30
 * Time: 上午11:24
 */

namespace apps\kafka\log;
class MFacade_platformApi {

    /**
     * 平台获取
     * @param string $host
     * @return string
     */
    public static function getPlatform($host = ''){
        return MCommon_PlatformApi::vGetPlatform($host);
    }

    /**
     * mfwappcode 获取
     * @return string
     */
    public static function getMfwAppCode(){
        return MCommon_PlatformApi::vGetMfwAppCode();
    }
}