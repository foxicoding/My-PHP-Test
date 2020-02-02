<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/4/25
 * Time: 11:14
 */

namespace apps\kafka\producer;
class MTopic_KafkaApi {

    //测试机房kafka集群信息
    private static $testKafkaConf = array(
        'api.version.request' => 'false',
        'broker.version.fallback' => '2.1.1',
        'metadata.broker.list' => '172.18.12.231:9092,172.18.12.232:9092,172.18.12.233:9092',
        'batch.num.messages' => 200,
        'queue.buffering.max.ms' => 25,
        'socket.timeout.ms' => 50
    );

    // 业务机房kafka集群信息
    private static $originKafkaConf = array(
        'api.version.request' => 'false',
        'broker.version.fallback' => '0.8.2.1',
        'metadata.broker.list' => '192.168.4.75:9092,192.168.4.76:9092,192.168.4.77:9092',
        'batch.num.messages' => 200,
        'queue.buffering.max.ms' => 25,
        'socket.timeout.ms' => 50
    );

    private static $basicTopicConf = array(
        'request.required.acks' => -1
    );


    private $topic = null;

    public static function createTestProducer($topic) {
        return new MTopic_KafkaApi(self::$testKafkaConf, self::$basicTopicConf, $topic);
    }

    public static function createOriginProducer($topic) {
        return new MTopic_KafkaApi(self::$originKafkaConf, self::$basicTopicConf, $topic);
    }

    public function __construct($kafkaConf, $topicConf, $topicName) {
        // 获取kafka全局配置
        $rdKafkaConf = self::setKafkaConf($kafkaConf);
        // 获取topic的配置
        $rdTopicConf = self::setTopicConf($topicConf);

        // 初始化producer
        $rdkafka = new \RdKafka\Producer($rdKafkaConf);
        $this->topic = $rdkafka->newTopic($topicName, $rdTopicConf);
    }

    public function produce($data) {
        if($this->topic != null) {
            $this->topic->produce(RD_KAFKA_PARTITION_UA, 0, $data);
        }
    }

    private function setKafkaConf($conf) {
        $kafkaConf = new \RdKafka\Conf();
        $this->setCommonConf($kafkaConf, $conf);
        return $kafkaConf;
    }

    private function setTopicConf($conf) {
        $topicConf = new \RdKafka\TopicConf();
        $this->setCommonConf($topicConf, $conf);
        return $topicConf;
    }

    private function setCommonConf($obj, $conf) {
        foreach ($conf as $key => $value) {
            $obj->set($key, $value);
        }
    }
}