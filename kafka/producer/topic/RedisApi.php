<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/4/26
 * Time: 15:07
 */

namespace apps\kafka\producer;

/**
 * Class MTopic_RedisApi
 * @package apps\kafka\producer
 *
 * @deprecated
 */
class MTopic_RedisApi {

    private static $DATA_CENTER_COLLECT_REDIS_ORIGIN_EVENT = "dc_collect_redis_origin_event";

    public static function lpush($value) {
        $time_start = (int)(microtime(true) * 1000);

        $json = json_decode($value, true);
        $json['attr']['_redis_start_time'] = $time_start;
        $value = json_encode($json);

        $oRedis = \apps\cluster\MFacade_RedisApi::OInstance('Collect');
        $result = $oRedis->lpush(self::$DATA_CENTER_COLLECT_REDIS_ORIGIN_EVENT, $value);

        $time_end = (int)(microtime(true) * 1000);
        $data = json_encode(array(
            'result' => $result,
            'time_start' => $time_start,
            'time_end' => $time_end,
            'gap' => $time_end - $time_start,
            'data' => $value
        ));
        \apps\MFacade_Log_Api::dlog("dc_low_redis_test", $data);
    }

}