<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:3:33 下午
 */

require_once __DIR__ . '/config.php';

spl_autoload_register(function ($className) {
    $className = str_replace('\\','/',$className);
    require_once WEB_ROOT_DIR . '/' . $className . '.php';
});