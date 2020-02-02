<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/10/13
 * Time: 下午2:09
 */
namespace apps\kafka\consumer;

class MTopic_Api
{
    //业务机房kafka集群信息
    protected static $baseKafkaConf = array(
        'api.version.request' => 'false',
        'broker.version.fallback' => '0.8.2.1',
        'metadata.broker.list' => '192.168.4.75:9092,192.168.4.76:9092,192.168.4.77:9092'
    );

    //业务机房 BinLog kafka集群信息
    protected static $baseBinLogKafkaConf = array(
        'api.version.request' => 'true',
        'broker.version.fallback' => '2.1.1',
        'metadata.broker.list' => '192.168.2.95:9092,192.168.2.96:9092,192.168.2.97:9092'
    );

    //数据机房kafka集群信息
    protected static $baseDCKafkaConf = array(
        'api.version.request' => 'false',
        'broker.version.fallback' => '0.8.2.1',
        'metadata.broker.list' => '192.168.9.112:9092,192.168.9.113:9092,192.168.9.114:9092'
    );

    protected static $baseTopicConf = array(
        'auto.commit.interval.ms' => 100,
        'offset.store.method' => 'file',
        'auto.offset.reset' => 'largest'
    );

    //业务机房 BinLog消费的topic配置
    protected static $binLogKafkaTopics = array(
        'binlog.sales_ugc',
        'binlog.sales_zyx',
        'binlog.sales',
        'binlog.wenda',
        'binlog.travelarticle',
        'binlog.travelnotes',
        'binlog.community_group',
        'binlog.wireless_platform',
        'binlog.mdd',
        'binlog.user',
        'binlog.guide',
        'binlog.weng',
        'binlog.daren',
        'binlog.g_3',
        'binlog.g_4',
        'binlog.g_5',
        'binlog.g_6',
    );

    //数据机房消费的topic配置
    protected static $dcKafkaTopics = array(
        'log.mobile_event',
        'log.page_event',
        'log.server_event',
        'log.user_mdd_locus',
        'log.user_current_location'
    );

    protected static $consumer;
    /**
     * 业务机房kafka配置
     */
    public static function oSetKakfaConf(){

        $kConf = new \RdKafka\Conf();

        foreach (self::$baseKafkaConf as $key => $value) {
            $kConf->set($key,$value);
        }
        return $kConf;
    }

    /**
     * 业务机房 BinLog kafka配置
     */
    public static function oSetBinLogKakfaConf(){

        $kConf = new \RdKafka\Conf();

        foreach (self::$baseBinLogKafkaConf as $key => $value) {
            $kConf->set($key,$value);
        }
        return $kConf;
    }

    /**
     * 数据机房kafka配置
     */
    public static function oSetDCKakfaConf(){

        $kConf = new \RdKafka\Conf();

        foreach (self::$baseDCKafkaConf as $key => $value) {
            $kConf->set($key,$value);
        }
        return $kConf;
    }

    /**
     * topic配置
     */
    public static function oSetTopicConf(){
        $tConf = new \RdKafka\TopicConf();

        foreach(self::$baseTopicConf as $key => $value){
            $tConf->set($key,$value);
        }

        return $tConf;
    }


    /**
     * 获取集群topics
     * @param $oConsumer
     * @return mixed
     */
    public static function aCheckTopics($oConsumer){

        $meta = $oConsumer->getMetadata(true,null,60*1000);
        $kcTopics = $meta->getTopics();
        foreach($kcTopics as $oTopic){
            $partitions = $oTopic->getPartitions();
            $topic = $oTopic->getTopic();
            foreach($partitions as $partition) {
                $topics[$topic][$partition->getId()] = $partition->getId();
            }
        }
        return $topics;
    }

    /**
     * 获取订阅的topic的最新消费offset
     * @param $group
     * @param $topic
     * @return array
     */
    public static function aGetOffset($group,$topic){
        if(in_array($topic,self::$dcKafkaTopics)){
            $topics = self::aGetDCTopics();
        }else if(in_array($topic,self::$binLogKafkaTopics)){
            $topics = self::aGetBinLogTopics();
        }else {
            $topics = self::aGetTopics();
        }

        $storePath = "/mfw_rundata/kafka.consumer/$group/";
        $aOffsetResult = array();
        for($p = 0; $p < count($topics[$topic]);$p++){
            $offSetFile = $storePath."$topic-$p-$group.offset";
            $aOffsetResult[$p] = file_get_contents($offSetFile);
        }
        return $aOffsetResult;
    }

    /**
     * 设置offsets
     * @param $group
     * @param $topic
     * @param $offsets
     */
    public static function vSetOffset($group,$topic,$offsets){
        if(in_array($topic,self::$dcKafkaTopics)){
            $topics = self::aGetDCTopics();
        }else {
            $topics = self::aGetTopics();
        }
        $storePath = "/mfw_rundata/kafka.consumer/$group/";
        for($p = 0; $p < count($topics[$topic]);$p++){
            $offSetFile = $storePath."$topic-$p-$group.offset";
            $offset = $offsets[$p];
            $aOffsetResult[$p] = file_put_contents($offSetFile,$offset);
        }
    }
    /**
     * 清空offset
     * @param $group
     */
    public static function vCleanOffset($group){
        $storePath = "/mfw_rundata/kafka.consumer/$group/";
        self::vCleanDir($storePath);
    }

    /**
     * 目录清空
     * @param $directory
     */
    public  static function vCleanDir($directory){
        if(file_exists($directory)){
            if($dir_handle=@opendir($directory)){
                while($filename=readdir($dir_handle)){
                    if($filename!='.' && $filename!='..'){
                        $subFile=$directory."/".$filename;
                        if(is_dir($subFile)){
                            self::vCleanDir($subFile);
                        }
                        if(is_file($subFile)){
                            unlink($subFile);
                        }
                    }
                }
                closedir($dir_handle);
                rmdir($directory);
            }
        }
    }

    /**
     * 获取业务集群所有Topic
     * @return mixed
     */
    public static function aGetTopics(){
        $oKafkaConf = self::oSetKakfaConf();
        $oConsumer =  new \RdKafka\Consumer($oKafkaConf);
        return self::aCheckTopics($oConsumer);
    }


    /**
     * 获取业务集群BinLog所有Topic
     * @return mixed
     */
    public static function aGetBinLogTopics(){
        $oKafkaConf = self::oSetBinLogKakfaConf();
        $oConsumer =  new \RdKafka\Consumer($oKafkaConf);
        return self::aCheckTopics($oConsumer);
    }

    /**
     * 获取数据集群所有Topic
     * @return mixed
     */
    public static function aGetDCTopics(){
        $oKafkaConf = self::oSetDCKakfaConf();
        $oConsumer =  new \RdKafka\Consumer($oKafkaConf);
        return self::aCheckTopics($oConsumer);
    }

    /**
     * 订阅topic数据
     * @param $group
     * @param $topic
     * @return array
     * @throws \Exception
     */
    public static function oNewQueue($group,$topic){

        if(in_array($topic,self::$dcKafkaTopics)){
            $oKafkaConf = self::oSetDCKakfaConf();
        }else if(in_array($topic,self::$binLogKafkaTopics)){
            $oKafkaConf = self::oSetBinLogKakfaConf();
        } else {
            $oKafkaConf = self::oSetKakfaConf();
        }

        //consumer group
        $oKafkaConf->set('group.id',$group);

        $oTopicConf = self::oSetTopicConf();
        //offset stored path
        $storePath = "/mfw_rundata/kafka.consumer/$group/";
        if(!is_dir($storePath)){
            @mkdir($storePath,0777,true);
            @chmod($storePath, 0777);
        }
        $oTopicConf->set('offset.store.path',$storePath);

        $oConsumer =  new \RdKafka\Consumer($oKafkaConf);
        $oQueue = $oConsumer->newQueue();
        $oTopic = $oConsumer->newTopic($topic,$oTopicConf);

        if(in_array($topic,self::$dcKafkaTopics)){
            $topics = self::aGetDCTopics();
        }else if(in_array($topic,self::$binLogKafkaTopics)){
            $topics = self::aGetBinLogTopics();
        } else {
            $topics = self::aGetTopics();
        }

        for($p=0;$p < count($topics[$topic]); $p++){
            $oTopic->consumeQueueStart($p,RD_KAFKA_OFFSET_STORED,$oQueue);
        }
        return $oQueue;
    }
}