<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/3/6
 * Time: 下午5:46
 */
namespace apps\kafka\dao;

class MFacade_spiderApi {

    /**
     * 按ip名获取ip
     * @param $ipVal
     * @return mixed
     */
    public static function getSpiderIpByName($ipVal){
        $m_ip = new MSpider_ipApi();
        return $m_ip->getIpByName($ipVal);
    }

    /**
     * 插入ip
     * @param $aInsert
     * @return bool
     */
    public static function setSpiderIp($aInsert){
        $m_ip = new MSpider_ipApi();
        return $m_ip->insertIp($aInsert);
    }


    /**
     * 按ip名删除ip
     * @param $ipVal
     * @return mixed
     */
    public static function deleteSpiderIpByName($ipVal){
        $m_ip = new MSpider_ipApi();
        return $m_ip->deleteIpByName($ipVal);
    }
}