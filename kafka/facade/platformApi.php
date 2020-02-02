<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/8/30
 * Time: 上午11:45
 */
namespace apps\kafka;


class MFacade_platformApi {

    /**
     * @param string $host
     * @return string
     */
    public static function getPlatform($host = ''){

        return \apps\kafka\log\MFacade_platformApi::getPlatform($host);
    }

    /**
     * @return string
     */
    public static function getMfwAppCode() {
        return \apps\kafka\log\MFacade_platformApi::getMfwAppCode();
    }
}