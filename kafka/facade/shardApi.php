<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/6/27
 * Time: 下午3:33
 */
namespace apps\kafka;
class MFacade_shardApi {
    /**
     * 事件拆分
     * @param $time
     */
    public static function logShard($time){
        return \apps\kafka\shard\MFacade_shardApi::vShard($time);
    }
}