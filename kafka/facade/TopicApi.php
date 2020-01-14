<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午11:54
 */
namespace apps\kafka;
class MFacade_TopicApi
{
    /**
     * 获取集群topics
     * @return mixed
     */
    public static function aGetTopics(){
        return \apps\kafka\consumer\MFacade_TopicApi::aGetTopics();
    }
    /**
     * 重新设置offset
     * @param $group
     * @param $topic
     * @param $offsets
     */
    public static function vSetOffset($group,$topic,$offsets){
        return \apps\kafka\consumer\MFacade_TopicApi::vSetOffset($group,$topic,$offsets);
    }
    /**
     * 获取订阅的topic的最新消费offset
     * @param $group
     * @param $topic
     * @return array
     */
    public static function aGetOffset($group,$topic){
        return \apps\kafka\consumer\MFacade_TopicApi::aGetOffset($group,$topic);
    }

    /**
     * 清空offset
     * @param $group
     */
    public static function vCleanOffset($group){
        return \apps\kafka\consumer\MFacade_TopicApi::vCleanOffset($group);
    }

    /**
     * 消费队列
     * @param $group
     * @param $topic
     * @return array
     */
    public static function oNewQueue($group,$topic){
        return \apps\kafka\consumer\MFacade_TopicApi::oNewQueue($group,$topic);
    }
}