<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/2/23
 * Time: 下午5:05
 */
namespace apps\kafka\producer;
class MMobile_PageConf {
    /**
     * PAGE事件酒店详情页日志附加 tp_fix，tp_category字段 @liming
     * mobile_event事件 对于酒店详情页（目前上报了hotel_id，且 attr_root='hotel' and attr_leaf1='detail' 的事件）
     * @var array
     */
    public static $tpExtendMap = array(
        '大搜索'        => array(
            'fix' => '大搜索','category' => 'out'
        ),
        '攻略详情'      => array(
            'fix' => '攻略详情','category' => 'out'
        ),
        'POI详情'       => array(
            'fix' => 'POI详情','category' => 'out'
        ),
        'POI周边的POI列表'      => array(
            'fix' => 'POI详情','category' => 'out'
        ),
        'POI详情地图'   => array(
            'fix' => 'POI详情','category' => 'out'
        ),
        '文章攻略:旅游攻略'     => array(
            'fix' => '文章攻略:旅游攻略','category' => 'out'
        ),
        '订酒店－目的地搜索页'  => array(
            'fix' => '酒店首页','category' => 'in'
        ),
        '订酒店-目的地搜索页'  => array(
            'fix' => '酒店首页','category' => 'in'
        ),
        '城市选择'      => array(
            'fix' => '酒店首页','category' => 'in'
        ),
        '酒店列表地图页'        => array(
            'fix' => '酒店列表页','category' => 'in'
        ),
        '酒店列表页'    => array(
            'fix' => '酒店列表页','category' => 'in'
        ),
        '酒店搜索'      => array(
            'fix' => '酒店搜索','category' => 'in'
        ),
        '酒店详情地图'  => array(
            'fix' => '酒店详情页','category' => 'in'
        ),
        '酒店详情页'    => array(
            'fix' => '酒店详情页','category' => 'in'
        ),
        '点评详情页'    => array(
            'fix' => '酒店详情页','category' => 'in'
        ),
        '我的收藏'      => array(
            'fix' => '我的收藏','category' => 'in'
        ),
        '用户目的地的POI收藏列表'       => array(
            'fix' => '我的收藏','category' => 'in'
        ),
        '收藏夹详情页面'        => array(
            'fix' => '我的收藏','category' => 'in'
        ),
        '通用浏览器'    => array(
            'fix' => '其他','category' => 'out'
        ),
        '我的订单'      => array(
            'fix' => '我的订单','category' => 'in'
        ),
        '文章攻略:酒店攻略'     => array(
            'fix' => '文章攻略:酒店攻略','category' => 'in'
        ),
        '酒店攻略特色列表页'    => array(
            'fix' => '酒店攻略特色列表页','category' => 'in'
        ),
        '游记详情'      => array(
            'fix' => '游记详情','category' => 'out'
        ),
        '回答详情页'    => array(
            'fix' => '回答详情页','category' => 'out'
        ),
        '嗡嗡详情'      => array(
            'fix' => '嗡嗡详情','category' => 'out'
        ),
        '坐标附近嗡嗡列表'      => array(
            'fix' => '嗡嗡详情','category' => 'out'
        ),
        '特价详情' => array(
            'fix' => '商城','category' => 'out'
        ),
        '商城聚合首页'  => array(
            'fix' => '商城','category' => 'out'
        ),
        '玩法路线详情页'        => array(
            'fix' => '玩法路线详情页','category' => 'out'
        ),
        '目的地详情页'  => array(
            'fix' => '目的地','category' => 'out'
        ),
        '自由行攻略'    => array(
            'fix' => '自由行攻略','category' => 'out'
        ),
        '攻略雷达页'    => array(
            'fix' => '目的地','category' => 'out'
        ),
        '酒店目的地特色列表页'  => array(
            'fix' => '酒店目的地特色列表页','category' => 'in'
        ),
        '当地主页'      => array(
            'fix' => '目的地','category' => 'out'
        ),
        '酒店预订首页'  => array(
            'fix' => '酒店首页','category' => 'in'
        ),
        '酒店订单详情页'        => array(
            'fix' => '酒店订单详情页','category' => 'in'
        ),
        '酒店活动页-20180318'   => array(
            'fix' => '营销活动180318','category' => 'out'
        ),
        '酒店专题页-海岛'   => array(
            'fix' => '酒店专题页','category' => 'out'
        ),
        '暑期大促主会场'   => array(
            'fix' => '酒店专题页','category' => 'out'
        ),
        '马蜂窝世界杯大促'   => array(
            'fix' => '酒店专题页','category' => 'out'
        ),

    );
}