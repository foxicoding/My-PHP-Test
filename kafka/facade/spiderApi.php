<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/3/6
 * Time: 下午6:05
 */
namespace apps\kafka;


class MFacade_spiderApi
{

    /**
     * 按ip名获取ip
     * @param $ipVal
     * @return mixed
     */
    public static function getSpiderIpByName($ipVal){
        return \apps\kafka\dao\MFacade_spiderApi::getSpiderIpByName($ipVal);
    }

    /**
     * 插入ip
     * @param $aInsert
     * @return bool
     */
    public static function setSpiderIp($aInsert){
        return \apps\kafka\dao\MFacade_spiderApi::setSpiderIp($aInsert);
    }



    /**
     * 按ip名删除ip
     * @param $ipVal
     * @return mixed
     */
    public static function deleteSpiderIpByName($ipVal){
        return \apps\kafka\dao\MFacade_spiderApi::deleteSpiderIpByName($ipVal);
    }

    /**
     * 是否标准爬虫判断
     * @param $ua
     * @return bool
     */
    public static function isSpider($ua){
        return \apps\kafka\log\MCommon_SpiderApi::vIsSpider($ua);
    }
}