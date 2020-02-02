<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/6/27
 * Time: 上午10:33
 */
namespace apps\kafka;
class MConf {

    //graphite 配置
    const Graphite_server = "192.168.7.195";
    const Graphite_port = "2003";

    /**
     * kafkacat 收集
     * @var array
     */
    public static $CollectLogConf = array(
        'elasticsearch' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'audit_report' => array(
            'hdays' => 15,
            'is_batch' => 1
        ),
    );

    /**
     * 日志源配置
     * @var array
     */
    public static $EventTypes = array(
        'server_event' => array(
            'hdays' => 2,
            'is_batch' => 1,
        ),
        'page_event' => array(
            'hdays' => 2,
            'is_batch' => 1,
        ),
        'mobile_event' => array(
            'hdays' => 2,
            'is_batch' => 1,
        ),
        'mobile_event_debug' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'monitor_event' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'weapp_event' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'femonitor_event' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'mobile_flow_event' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'web_event' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
        'audit_report' => array(
            'hdays' => -1, //不删除
            'is_batch' => 1
        ),
        'mini_event' => array(
            'hdays' => 2,
            'is_batch' => 1
        ),
    );

    /**
     * 管道输入日志源
     * @var array
     */
    public static $pipeLineSource = array(
        'mobile_event',
        'monitor_event',
        'page_event',
        'server_event',
        'weapp_event'
    );

}