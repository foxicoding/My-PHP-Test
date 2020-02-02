<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/11/23
 * Time: 下午2:48
 */
namespace apps\kafka\producer;


use apps\mobile\device\MFacade_Ext_Shumei;

class MMobilePipeLine extends MBasePipeLine {


    /**
     * 数据体处理
     * @param $log
     */
    public  function vPipeLineMain($log){
//        $aLog = parent::aPipeLineInput($log);
//        $bLog = $this->sPipeLineProcess($aLog['log']);
//        //切换新的日志清洗管道
//        $c_minute = date('YmdHi',$bLog['ctime']);
////        if($c_minute >= 201811220000 && $c_minute <= 201811222124 ){
////            parent::sPipeLineOutPutNoKey($bLog);
////        }else {
////            parent::vPipeLineOutPutFB($bLog);
////        }
    }



    /**
     * 管道处理日志
     * @param  $log
     * @return array|void
     */
    public  function sPipeLineProcess($log){

        //管道修复open_udid
        $log = $this->aPipeLineFixOpenUdid($log);

        //日志字段补充
        $log = $this->sPipeLineExtend($log);

        //切换新的日志清洗管道
        $c_minute = date('YmdHi',$log['ctime']);
        if($c_minute >= 201811220000 && $c_minute <= 201811222124 ){

        }else {
            //日志订阅
            $this->sPipeLineSubscribe($log);
        }

        return $log;
    }

    /**
     * 管道修复open_udid
     * @param $log
     */
    public function aPipeLineFixOpenUdid($log){
        $appCode = $log['app_code'];
        $idfa = $log['idfa'];
        $open_udid = $log['open_udid'];
        if(!empty($appCode) && 'cn.mafengwo.www' == $appCode){
            if(!empty($idfa)){
                $sFixOpenUdid = \apps\coop\MFacade_deviceApi::sGetOpenUdidByIDFA($idfa);
                $log['attr']['_m_open_udid_fix'] = $open_udid;
                $log['open_udid'] = empty($sFixOpenUdid) ? $open_udid : $sFixOpenUdid;
            }
        }
        return $log;
    }


    /**
     * 自定义字段
     * @param $log
     * @return mixed
     */
    public  function sPipeLineExtend($log){
        $fullLog  = MMobile_Page::aExtendFieldsMain($log);
        $fullLog  = MMobile_Hotel::aExtendFieldsMain($fullLog);
        $fullLog  = MMobile_Article::aExtendFieldsMain($fullLog);
        $fullLog  = MMobile_Travelling::aExtendFieldsMain($fullLog);
        $fullLog  = MMobile_Device::aExtendFieldsMain($fullLog);
        return $fullLog;
    }

    /**
     * 数据管道 日志订阅
     * @param $log
     * @return mixed
     */
    public function sPipeLineSubscribe($log){
        $event_code = $log['event_code'];
        switch($event_code){
            case 'mall_list_item_display':
                \apps\sales\ad\MFacade_Api::vOnMesExposure($log);
                break;
            case 'mall_list_item_click':
            case 'mall_list_product_click':
                //mall_list_item_click是8.1.2（大概2018年1月17号）及之后版本的事件名称
                //mall_list_product_click是8.1.1（大概2018年1月17号）及之前版本的事件名称
                \apps\sales\ad\MFacade_Api::vOnMesClick($log);
                break;
            case 'device':
            case 'shumeng_did':
                \apps\coop\MFacade_deviceApi::vDealLog($log);
                break;
            case 'shumei_did':
                if(!$log['attr']['shumei_did'])
                {
                    \apps\MFacade_Log_Api::dlog('pipeline_shumei_id', $log);
                }
                \apps\mobile\device\MFacade_Ext_Shumei::BBind($log['open_udid'], $log['attr']['shumei_did']);
                \apps\coop\MFacade_deviceApi::vShumeiDealLog($log);
                break;
            case 'page':
                \apps\coop\MFacade_deviceApi::vOnPageEvent($log);
                break;
        }
    }


}