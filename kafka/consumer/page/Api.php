<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午10:26
 */
namespace apps\kafka\consumer;
class MPage_Api
{
    //kafka topic
    private  $kafkaTopic = "log.page_event";
    //消费组
    private $group;
    //订阅事件
    private $event_code;
    //消费队列
    private $queue;
    //超时设置
    private $timeout;

    /**
     * @param $group
     * @param $event_code
     * @param int $timeout
     */

    function __construct($group,array $event_code,$timeout = 120000){
        $this->group = $group;
        $this->event_code = $event_code;
        $this->timeout = $timeout;

        $this->queue = \apps\kafka\consumer\MFacade_TopicApi::oNewQueue($group,$this->kafkaTopic);
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
                $msg_decode = json_decode($message->payload);
                if(in_array($msg_decode->event_code,$this->event_code)){
                    $result = array(
                        'status' => 'SUCC',
                        'event_code' => $msg_decode->event_code,
                        'message' => $message->payload,
                        'partition' => $message->partition,
                        'offset' => $message->offset
                    );
                }else {
                    $result = array(
                        'status' => 'FAIL',
                        'event_code' => $msg_decode->event_code,
                        'message' => 'No Match Event Code',
                        'partition' => $message->partition,
                        'offset' => $message->offset,
                    );
                }
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