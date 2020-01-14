<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/5/30
 * Time: 14:58
 */

namespace apps\kafka\log;


class MMobile_KafkaBeat {

    private static $FLOW_EVENT = array(
        'home_article_list_click',
        'click_index',
        'click_common_detail',
        'home_article_list_show',
        'show_index',
        'show_common_detail',
        'page',
        'click_mdd_index',
        'show_mdd_index',
        'show_weng_detail',
        'show_video_detail',
        'click_video_detail',
        'click_weng_detail'
    );

    public static function collects($logs) {
        foreach ($logs as $log) {
            self::collect($log);
        }
    }

    public static function collect($log) {
        $event_code = $log['event_code'];
        if (self::validate($event_code)) {
            self::writeFile(json_encode($log));
        }
    }

    private static function writeFile($log) {
        $log_dir = MFacade_logEnvApi::sGetLogPath().'/mobile_flow_event/';
        MCommon_CommonApi::checkLogDir($log_dir);
        $filename = $log_dir.'mobile_flow_event.' . date('YmdH');
        MCommon_CommonApi::checkFileMod($filename);

        @file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);
    }

    private static function validate($event_code) {
        return (!empty($event_code) && in_array($event_code, self::$FLOW_EVENT));
    }

    private static function sendKafka($logs) {
        try {
            $producer = null;
            foreach ($logs as $log) {
                $event_code = $log['event_code'];
                if (self::validate($event_code)) {
                    if ($producer == null) {
                        $producer = self::createProducer();
                    }

                    $producer->produce(json_encode($log));
                }
            }
        } catch (\Exception $e) {
            \apps\MFacade_Log_Api::dlog('_dc_collect_low_latency_error', json_encode(array(
                        'data' => $logs,
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString())
                )
            );
        }
    }

    private static function createProducer() {
//        $producer = \apps\kafka\producer\MFacade_TopicApi::createTestProducer('origin.mobile_eve');
        $producer = \apps\kafka\producer\MFacade_TopicApi::createOriginProducer('origin.mobile_flow_event');

        return $producer;
    }

}