<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题详情内容
 * @author will.chen
 *
 */
class info_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	

    	$this->authSession();
    	$topic_id = $this->requestData('topic_id', 0);

    	if ($topic_id == 0) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	$type = $this->requestData('type');
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);
    	$sort_type = _POST('sort_by', '');
    	switch ($sort_type) {
    		case 'hot' :
    			$order_by = array('is_hot' => 'DESC', 'sort_order' => 'asc', 'goods_id' => 'desc');
    			break;
    		case 'price_desc' :
    			$order_by = array('shop_price' => 'desc', 'sort_order' => 'asc', 'goods_id' => 'desc');
    			break;
    		case 'price_asc' :
    			$order_by = array('shop_price' => 'asc', 'sort_order' => 'asc', 'goods_id' => 'desc');
    			break;
    		case 'new' :
    			$order_by = array('is_new' => 'DESC', 'sort_order' => 'asc', 'goods_id' => 'desc');
    			break;
    		default :
    			$order_by = array('sort_order' => 'asc', 'goods_id' => 'desc');
    			break;
    	}
    	
    	$topic = RC_Api::api('topic', 'topic_info', array('topic_id' => $topic_id));
    	$topic_info = array(
    			'topic_id'			=> $topic['topic_id'],
    			'topic_title'		=> $topic['title'],
    			'topic_description' => strip_tags($topic['description']),
    			'topic_image'		=> $topic['topic_img']
    	);
		$topic_cats = $goods_group = array();
		$topic_info['topic_type'] = $topic_info['sub_goods'] = array();
		foreach ( $topic['topic_cat_name'] as $k=>$v) {
			foreach ($v as $vv) {
				$tmp = explode('|', $vv);
				$topic_cats[$k][$tmp[1]] = $tmp[0];
				if (!in_array($k, $topic_info['topic_type']) && $k != 'default') {
					$topic_info['topic_type'][] = $k;
				}
				if ($k == $type && !empty($type)) {
					$goods_group[] = $tmp[1];
				} elseif (empty($type)) {
					$goods_group[] = $tmp[1];
				}
			}
		}
		
    	if (!empty($goods_group)) {
    		$goods_list = get_goods_list($goods_group, $order_by, $page, $size);
    		$topic_info['sub_goods'] = $goods_list['data'];
    	} else {
    		$topic_info['sub_goods'] = array();
    		$goods_list['page'] = array(
    			"total" => 0,
    			"count" => 0,
    			"more" => 0,
    		);
    	}
    	return array('data' => $topic_info, 'pager' => $goods_list['page']);
    }
}

function get_goods_list($goods_group_id, $order_by, $page, $size) {
	
		$where = array_merge($where, array('is_delete' => 0, 'is_on_sale' => 1, 'is_alone_sale' => 1));
    	if(ecjia::config('review_goods') == 1){
    		$where['review_status'] = array('gt' => 2);
    	}
    	$where['g.goods_id'] = $goods_group_id;
    	/* 查询商品 */
    	$dbveiw = RC_Loader::load_app_model('goods_member_viewmodel', 'goods');
    	$dbview->view = array(
    		'member_price' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'mp',
    			'field' => $field,
    			'on'   	=> "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
    		)
    	);
    	
    	
    	
    	/* 获得符合条件的商品总数 */
    	$count = $dbveiw->join(null)->where($where)->count();
    	
    	//实例化分页
    	$page_row = new ecjia_page($count, $size, 6, '', $page);
    	
    	
    	
    	$field = "g.goods_id, g.goods_name, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price,".
    			"IFNULL(mp.user_price, g.shop_price * '".$_SESSION['discount']."') AS shop_price, ".
    			"g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type ";
    	
    	
    	$data = $dbveiw->join(array('member_price'))->field($field)->where($where)->order($order_by)->limit($page_row->limit())->select();
    	
    	if (!empty($data) && is_array($data)) {
    		$list = array();
    		RC_Loader::load_sys_func('global');
    		RC_Loader::load_app_func('goods', 'goods');
    		RC_Loader::load_app_func('common', 'goods');
    		$mobilebuy_db = RC_Loader::load_app_model('goods_activity_model', 'goods');
    		foreach ($data as $key => $val) {
    			if ($val['promote_price'] > 0) {
    				$promote_price = bargain_price($val['promote_price'], $val['promote_start_date'], $val['promote_end_date']);
    			} else {
    				$promote_price = '0';
    			}
    			
    			$groupbuy = $mobilebuy_db->find(array(
    					'goods_id'	 => $val['goods_id'],
    					'start_time' => array('elt' => RC_Time::gmtime()),
    					'end_time'	 => array('egt' => RC_Time::gmtime()),
    					'act_type'	 => GAT_GROUP_BUY,
    			));
    			$mobilebuy = $mobilebuy_db->find(array(
    					'goods_id'	 => $val['goods_id'],
    					'start_time' => array('elt' => RC_Time::gmtime()),
    					'end_time'	 => array('egt' => RC_Time::gmtime()),
    					'act_type'	 => GAT_MOBILE_BUY,
    			));
    			/* 判断是否有促销价格*/
    			$price = ($val['shop_price'] > $promote_price && $promote_price > 0) ? $promote_price : $val['shop_price'];
    			$activity_type = ($val['shop_price'] > $promote_price && $promote_price > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
    			
    			
    			$mobilebuy_price = $groupbuy_price = $object_id = 0;
    			if (!empty($mobilebuy)) {
    				$ext_info = unserialize($mobilebuy['ext_info']);
    				$mobilebuy_price = $ext_info['price'];
    				if ($mobilebuy_price < $price) {
    					$val['promote_start_date'] = $mobilebuy['start_time'];
    					$val['promote_end_date'] = $mobilebuy['end_time'];
    				}
   					$price = $mobilebuy_price > $price ? $price : $mobilebuy_price;
   					$activity_type = $mobilebuy_price > $price ? $activity_type : 'MOBILEBUY_GOODS';
   				}
//     				if (!empty($groupbuy)) {
//     					$ext_info = unserialize($groupbuy['ext_info']);
//     					$price_ladder = $ext_info['price_ladder'];
//     					$groupbuy_price  = $price_ladder[0]['price'];
//     					$price = $groupbuy_price > $price ? $price : $groupbuy_price;
//     					$activity_type = $groupbuy_price > $price ? $activity_type : 'GROUPBUY_GOODS';
//     				}
    			
				/* 计算节约价格*/
    			$saving_price = ($val['shop_price'] - $price) > 0 ? $val['shop_price'] - $price : 0;
    			$list[] = array(
    				'id'					=> $val['goods_id'],
    				'name'					=> $val['goods_name'],
    				'market_price'			=> price_format($val['market_price']),
    				'shop_price'			=> price_format($val['shop_price']),
    				'promote_price'			=> ($price < $val['shop_price'] && $price > 0) ? price_format($price) : '',
    				'promote_start_date'	=> ($price < $val['shop_price'] && $price > 0) ? RC_Time::local_date('Y/m/d H:i:s', $val['promote_start_date']) : '',
    				'promote_end_date'		=> ($price < $val['shop_price'] && $price > 0) ? RC_Time::local_date('Y/m/d H:i:s', $val['promote_end_date']) : '',
    				'brief'					=> $val['goods_brief'],
    				'img'					=> array(
    					'small' => get_image_path($val['goods_id'], $val['goods_thumb'], true),
    					'url'	=> get_image_path($val['goods_id'], $val['original_img'], true),
    					'thumb' => get_image_path($val['goods_id'], $val['goods_img'], true),
    				),
					'activity_type' 			=> $activity_type,
    				'object_id'					=> $object_id,
					'saving_price'				=> $saving_price,
					'formatted_saving_price' 	=> '已省'.$saving_price.'元'
    			);
    		}
    	} 
    	$pager = array(
    		"total" => $page_row->total_records,
    		"count" => $page_row->total_records,
    		"more" 	=> $page_row->total_pages <= $page ? 0 : 1,
    	);
    	
		return array('data' => $list, 'page' => $pager);
}

// end