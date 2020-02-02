<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/17
 * Time: 上午10:26
 */
namespace apps\kafka\consumer;
class MBinLog_Api
{
    //kafka topic
    private  $kafkaTopic = "log.mysql_binlog";
    //消费组
    private $group;
    //订阅表
    private $table;
    //消费队列
    private $queue;
    //超时设置
    private $timeout;

    /**
     * @param $group
     * @param $table
     * @param int $timeout
     */

    function __construct($group,array $table,$timeout = 120000){
        $this->group = $group;
        $this->table = $table;
        $this->timeout = $timeout;

        $this->queue = \apps\kafka\consumer\MFacade_TopicApi::oNewQueue($group,$this->kafkaTopic);
    }

    /**
     * binlog offset 设置
     * @param $group
     * @param $offsets
     */
    public function vSetOffset($group,$offsets) {
        return \apps\kafka\consumer\MFacade_TopicApi::vSetOffset($group,$this->kafkaTopic,$offsets);
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
                if(in_array($msg_decode->table,$this->table)){
                    $result = array(
                        'status' => 'SUCC',
                        'table' => $msg_decode->table,
                        'message' => $message->payload,
                        'partition' => $message->partition,
                        'offset' => $message->offset
                    );
                }else {
                    $result = array(
                        'status' => 'FAIL',
                        'table' => $msg_decode->table,
                        'message' => 'No Match Table',
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