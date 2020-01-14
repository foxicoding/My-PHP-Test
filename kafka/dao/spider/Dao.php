<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/3/6
 * Time: 下午4:51
 */
namespace apps\kafka\dao;
class MSpider_Dao extends  \Ko_Dao_Factory{
    protected $_aDaoConf = array(
        'spiderIp'  => array(
            'type' => 'db_single',
            'kind' => 'web_spider_ips',
            'key'  => 'ip'
        )
    );
}

/**
 *
 爬虫ip
 CREATE TABLE `web_spider_ips` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(15) NOT NULL DEFAULT '',
PRIMARY KEY (`id`),
UNIQUE `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8
 *
 *
 */