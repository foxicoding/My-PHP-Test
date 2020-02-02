<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/05/07
 * Time: 下午15:58
 */
namespace apps\kafka\consumer;
class MConsumer_Api
{
    //消费组
    private $group;
    //消费队列
    private $queue;
    //超时设置
    private $timeout;

    /**
     * @param $kafkaTopic  订阅的kafka topic
     * @param $group 消费组

     * @param int $timeout
     */

    function __construct($kafkaTopic,$group,$timeout = 120000){
        $this->group = $group;
        $this->timeout = $timeout;

        $this->queue = \apps\kafka\consumer\MFacade_TopicApi::oNewQueue($group,$kafkaTopic);
    }

    /**
     * 消费数据
     * @return array
     * @throws \Exception
     */
    public  function aConsume(){

        $message = $this->queue->consume($this->timeout);
        switch($message->err){
            case RD_KAFKA_RESP_ERR_NO_ERROR:

                $result = array(
                    'status' => 'SUCC',
                    'message' => $message->payload,
                    'partition' => $message->partition,
                    'offset' => $message->offset
                );
                break;
            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                $result = array(
                    'status' => 'FAIL',
                    'message' => 'No more messages; will wait for more'
                );
                break;
            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                $result = array(
                    'status' => 'FAIL',
                    'message' => 'Timed Out'
                );
                break;
            default:
                $result = array(
                    'status' => 'FAIL',
                    'message' => $message->errstr()
                );
                break;
        }
        return $result;
    }
}