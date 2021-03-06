<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */

function theme_widget_integration_coupon(&$setting,&$render){
    if(!$setting['limit']) $setting['limit'] = 5;
    $coupon_exchange_info = app::get('b2c')->model('coupons')->getList('*',array('cpns_status'=>1,'cpns_point|than'=>0,'cpns_type'=>1),0,$setting['limit'],'cpns_id DESC');
    $mSRO = app::get('b2c')->model('sales_rule_order');
    foreach($coupon_exchange_info as $key=>$val){
        $aRule = $mSRO->getList('description,to_time', array('rule_id'=>$val['rule_id']));
        $coupon_exchange_info[$key]['description'] = $aRule['0']['description'];
        if( $aRule[0]['to_time']<time() ) unset($coupon_exchange_info[$key] );
    }
    return $coupon_exchange_info;
}

