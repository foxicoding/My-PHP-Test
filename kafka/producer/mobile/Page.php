<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/11/23
 * Time: 下午3:13
 */
namespace apps\kafka\producer;
class MMobile_Page {


    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendPageFromMddid($log);
        $fullLog = self::aExtendPageTpFixAndCategory($fullLog);
        $fullLog = self::aExtendPageSalesBizInfo($fullLog);
        $fullLog = self::aExtendPageIsMainLand($fullLog);
        $fullLog = self::aExtendPageFartherUmddid($fullLog);
        $fullLog = self::aExtendPagePoiId($fullLog);
        $fullLog = self::aExtendPagePoiTypeId($fullLog);
        $fullLog = self::aExtendPageMddInfo($fullLog);

        return $fullLog;
    }

    /**
     * 用来解析tpre 获取 _turi
     * @param $uri
     * @param $tpre
     */
    public static function vGetTpreUri(&$uri,$tpre){
        $aChildTpre = $tpre['_tpre'];
        if(!empty($tpre['_turi'])){
            array_push($uri,$tpre['_turi']);
            self::vGetTpreUri($uri,$aChildTpre);
        }
    }

    /**
     * 根据一系列uri 解析mddid
     * @param array $uris
     */
    public static function vMatchMddidByUri(array $uris){
        $ignoreUrl = array(
            '/search/classify',
            '/search/general',
            '/search/main'
        );
        if(is_array($uris)){
            foreach($uris as $uri){
                $urlParse = parse_url($uri);
                $path = $urlParse['path'];
                $query = $urlParse['query'];
                if(in_array($path,$ignoreUrl)){
                    return;
                }
                if($path == '/local/index' || $path == '/mdd/detail'){
                    preg_match('/(?:mdd_id|mddid)=(\d+)/i',$query,$mddid);
                    if(count($mddid) > 1){
                        return $mddid[1];
                    }
                }
            }

        }
        return;
    }

    /**
     *  page事件解析 来源 mddid
     * @param $log
     */
    public static function aExtendPageFromMddid($log){
        if($log['event_code'] == 'page' && isset($log['attr']['_tpre'])){
            $oTpre = $log['attr']['_tpre'];
            if(is_string($oTpre)){
                $oTpre = json_decode($oTpre,true);
            }
            $uris = array(
                $log['puri'],
                $log['uri'],
            );
            self::vGetTpreUri($uris,$oTpre);
            $fromMddid = self::vMatchMddidByUri($uris);
            if(!empty($fromMddid)){
                $log['attr']['from_mddid'] = $fromMddid;
            }
        }
        return $log;
    }


    /**
     * 衍生 PAGE事件酒店详情页日志附加 tp_fix，tp_category字段
     * @param $log
     * @return mixed
     */
    public static function aExtendPageTpFixAndCategory($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        $hotel_id = $attr['hotel_id'];
        if('page' == $eventCode && !empty($hotel_id)){
            if('hotel' == $attr['root'] && 'detail' == $attr['leaf1']){
                $tp = trim($attr['_tp']);
                $tpMap = MMobile_PageConf::$tpExtendMap[$tp];
                if(is_array($tpMap)){
                    $log['attr']['_tp_fix'] = $tpMap['fix'];
                    $log['attr']['_tp_category'] = $tpMap['category'];
                }
                $tagData = \apps\hotel\hotel\MFacade_MdtApi::aGetHotelAdjustByHotelId($hotel_id);
                $log['attr']['tag_id'] = $tagData['tag_id'];
                $log['attr']['tag_name'] = $tagData['tag_name'];

            }

        }
        return $log;
    }

    /**
     * 衍生 PAGE事件sales详情页日志附加ota_id bd_uid biz_line等字段
     * @param $log
     * @return mixed
     */
    public static function aExtendPageSalesBizInfo($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('page' == $eventCode && !empty($attr['sales_id'])){
            if('sales' == $attr['root'] && 'detail' == $attr['leaf1']){
                $bizInfo = \apps\sales\product\MFacade_Info_Getter::aGetBizInfo($attr['sales_id']);
                $log['attr']['ota_id'] = $bizInfo['ota_id'];
                $log['attr']['bd_uid'] = $bizInfo['bd_uid'];
                $log['attr']['biz_line'] = $bizInfo['biz_line'];
            }

        }
        return $log;
    }

    /**
     * 根据目的地id 衍生是否大陆
     * @param $log
     * @return mixed
     */
    public static function aExtendPageIsMainLand($log){
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if('page' == $eventCode && !empty($attr['mddid'])){
            if('hotel' == $attr['root'] && 'detail' == $attr['leaf1']){
                $isMainLand = \apps\mdd\MFacade_mddApi::iRange($attr['mddid']);
                $log['attr']['is_mainland'] = $isMainLand;
            }

        }
        return $log;
    }

    /**
     * 根据用户所在地 衍生是其归属地 如:深圳->广州;东京->日本
     * @param $log
     * @return mixed
     */
    public static function aExtendPageFartherUmddid($log){
        $eventCode = $log['event_code'];
        if('page' == $eventCode && isset($log['umddid'])){
            $log['attr']['father_umddid'] = \apps\mdd\MFacade_mddApi::iGetFirstClassMddid($log['umddid']);
        }
        return $log;
    }

    private static function aExtendPagePoiId($log) {
        $eventCode = $log['event_code'];
        $attr = $log['attr'];

        if('page' === $eventCode && !isset($attr['poi_id'])) {
            $uri = $log['uri'];

            $mix = parse_url($uri);
            if($mix) {
                $host = $mix['host'];
                $path = $mix['path'];
                $query = $mix['query'];

                if('app.mafengwo.cn' === $host && $query != null) {
                    parse_str($query, $output);

                    switch ($path) {
                        case '/poi/detail':
                        case '/poi/photo_list':
                        case '/poi/comment_list':
                        case '/poi/comment_detail':
                        case '/poi/create_comment':
                            $poi_id = $output['poi_id'];
                            break;
                    }

                    if(!empty($poi_id)) {
                        $log['attr']['poi_id'] = $poi_id;
                    }

                }
            }

        }

        return $log;
    }

    private static function aExtendPagePoiTypeId($log) {
        $eventCode = $log['event_code'];
        $attr = $log['attr'];

        if('page' === $eventCode && !isset($attr['poi_type_id'])) {
            $uri = $log['uri'];

            $mix = parse_url($uri);
            if($mix) {
                $host = $mix['host'];
                $path = $mix['path'];
                $query = $mix['query'];

                if('app.mafengwo.cn' === $host && $query != null) {
                    parse_str($query, $output);

                    switch ($path) {
                        case '/poi/detail':
                            $poi_type_id = $output['poi_type_id'];
                            break;
                    }

                    if(!empty($poi_type_id)) {
                        $log['attr']['poi_type_id'] = $poi_type_id;
                    }
                }
            }

        }

        return $log;
    }

    /**
     *  page/hotel_detail_price_refresh事件 通过mddid 添加 country_id_sd、mdd_group_sd、mdd_area_sd 到 attr
     * @param $log
     */
    public static function aExtendPageMddInfo($log)
    {
        $eventCode = $log['event_code'];
        $attr = $log['attr'];
        if ('page' == $eventCode || 'hotel_detail_price_refresh' == $eventCode) {
            if (!empty($attr['mddid'])) {
                $mddid = $attr['mddid'];
                $mddInfo = \apps\hotel\mdd\MFacade_MddGroupOperationApi::aGetGroupByMddId(
                    $mddid, ['country_id', 'mdd_group', 'mdd_area_name']);
                if (!empty($mddInfo[$mddid])) {
                    if (!empty($mddInfo[$mddid]['country_id'])) {
                        $log['attr']['country_id_sd'] = $mddInfo[$mddid]['country_id'];
                    }
                    if (!empty($mddInfo[$mddid]['mdd_group'])) {
                        $log['attr']['mdd_group_sd'] = $mddInfo[$mddid]['mdd_group'];
                    }
                    if (!empty($mddInfo[$mddid]['mdd_area_name'])) {
                        $log['attr']['mdd_area_sd'] = $mddInfo[$mddid]['mdd_area_name'];
                    }
                }
            }

        }
        return $log;
    }
}