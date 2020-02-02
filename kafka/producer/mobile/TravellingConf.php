<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/4/10
 * Time: 下午5:05
 */
namespace apps\kafka\producer;
class MMobile_TravellingConf {
    /**
     * 以下为需要判定用户是否行中的事件列表
     * @var array
     */
    public static $travellingCode = array(
        'page',
        'hotel_list_item_show',
        'hotel_detail_module_show',
        'hotel_detail_module_click',
        'hotel_detail_room_show',
        'hotel_list_item_click',
        'hotel_home_module_show',
        'hotel_detail_room_policy_show',
        'hotel_list_module_click',
        'hotel_detail_room_click',
        'hotel_home_module_click',
        'hotel_home_guide_show',
        'hotel_detail_room_num_click',
        'hotel_detail_room_go2booking',
        'home_article_list_show',
        'home_article_group_show',
        'home_module_click',
        'home_article_list_click',
        'home_article_group_click',
    );
}