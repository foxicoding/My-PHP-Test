<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/6/27
 * Time: 下午5:11
 */
namespace apps\kafka;
include_once("/mfw_www/htdocs/global.php");

$topic = $argv[1];
$appCode = $argv[2];
$eventCode = $argv[3];

$filePos = 1;
while (!feof(STDIN)) {
    $line = trim(fgets(STDIN));
    if (!empty($line)) {
        list($key,$msg) = explode("^",$line,2);
        $decodeLine = json_decode($msg);
        if($appCode == 'default' && $eventCode == 'page'){
            if($decodeLine->event_code == $eventCode){
                \apps\kafka\producer\MPipeLineOutPut::sPipeLineOutPut($topic,$line,$filePos);
            }
        }else {
            if($decodeLine->app_code == $appCode && $decodeLine->event_code == $eventCode){
                \apps\kafka\producer\MPipeLineOutPut::sPipeLineOutPut($topic,$line,$filePos);
            }
        }
        $filePos++;

    }
}