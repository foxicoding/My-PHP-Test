<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/2/23
 * Time: 下午5:25
 */
namespace apps\kafka\producer;
class MMobile_HotelConf {
    /**
     * 衍生check_inout字段
     * @var array
     */
    public static $checkInOutCode = array(
        'check_inout' => array(
            'check_in-check_out' => array(
                'hotel_detail_price_refresh',
                'page'
            ),
            'f_dt_start-f_dt_end' => array(
                'hotel_detail_price_refresh',
                'hotel_detail_module_show',
                'hotel_detail_room_show',
                'hotel_detail_room_policy_show',
                'hotel_detail_module_click',
                'hotel_detail_room_click',
                'hotel_detail_room_num_click',
                'hotel_detail_room_go2booking',
                'hotel_home_module_show',
                'hotel_home_theme_show',
                'hotel_home_guide_show',
                'hotel_home_module_click',
                'hotel_home_theme_click',
                'hotel_home_guide_click',
                'hotel_list_module_click',
                'hotel_list_map_refresh',
                'hotel_list_item_show',
                'hotel_list_item_click',
            )
        )
    );

    /**
     * 衍生 tag_name 和 tag_id
     * @var array
     */
    public static $tagNameCode = array(
        'hotel_detail_price_refresh',
        'hotel_detail_room_policy_show'
    );
}