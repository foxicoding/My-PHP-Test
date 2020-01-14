<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/16
 * Time: 下午7:19
 */
namespace apps\kafka\consumer;
class MFacade_TopicApi
{
    /**
     * 获取集群topics
     * @return mixed
     */
    public static function aGetTopics(){
        return \apps\kafka\consumer\MTopic_Api::aGetTopics();
    }

    /**
     * 重新设置offset
     * @param $group
     * @param $topic
     * @param $offsets
     */
    public static function vSetOffset($group,$topic,$offsets){
        return \apps\kafka\consumer\MTopic_Api::vSetOffset($group,$topic,$offsets);
    }
    /**
     * 获取订阅的topic的最新消费offset
     * @param $group
     * @param $topic
     * @return array
     */
    public static function aGetOffset($group,$topic){
        return \apps\kafka\consumer\MTopic_Api::aGetOffset($group,$topic);
    }

    /**
     * 清空offset
     * @param $group
     */
    public static function vCleanOffset($group){
        return \apps\kafka\consumer\MTopic_Api::vCleanOffset($group);
    }
    /**
     * 订阅kafka topic
     * @param $group
     * @param $topic
     * @return array
     * @throws \Exception
     */
    public static function oNewQueue($group,$topic){
        return \apps\kafka\consumer\MTopic_Api::oNewQueue($group,$topic);
    }
}