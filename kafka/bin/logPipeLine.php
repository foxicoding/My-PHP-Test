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
while (!feof(STDIN)) {
    $log = trim(fgets(STDIN));
    if (!empty($log)) {
        \apps\kafka\producer\MPipeLineOutPut::sPipeLineOutPut($topic,$log);
    }
}