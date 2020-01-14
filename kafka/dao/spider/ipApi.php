<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/3/6
 * Time: 下午5:26
 */
namespace apps\kafka\dao;
class MSpider_ipApi extends \Ko_Mode_Item
{
    protected $_aConf = array(
        'item' => 'spiderIp',
    );
    /**
     * 通过ip名称获取列表
     * @param $ipVal
     * @return mixed
     */
    public function getIpByName($ipVal){
        return $this->aGet($ipVal);
    }

    /**
     * 插入ip
     * @param $aInsert
     * @return bool
     */
    public function insertIp($aInsert){
        try {
            return $this->iInsert($aInsert);

        }catch (Exception $ex) {
            return false;
        }
    }

    /**
     * 通过指定ip删除
     * @param $ipVal
     * @return mixed
     */
    public function deleteIpByName($ipVal){
        return $this->iDelete($ipVal);
    }
}