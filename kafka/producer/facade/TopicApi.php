<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/4/26
 * Time: 11:15
 */

namespace apps\kafka\producer;

class MFacade_TopicApi {

    public static function createTestProducer($topic) {
        return MTopic_KafkaApi::createTestProducer($topic);
    }

    public static function createOriginProducer($topic) {
        return MTopic_KafkaApi::createOriginProducer($topic);
    }

    public static function produce2Redis($value) {
        MTopic_RedisApi::lpush($value);
    }
}