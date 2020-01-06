<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:3:33 下午
 */

require_once __DIR__ . '/../../autoLoad.php';

use design_pattern\decorator\code\circle;
use design_pattern\decorator\code\redShapeDecorator;

$redCircle = new redShapeDecorator(new circle());
$redCircle->Draw();