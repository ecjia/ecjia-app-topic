<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题列表页
 * @author will.chen
 *
 */
class list_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	/**
    	 * topic_id  	专题id
    	 * topic_title	专题标题
    	 * topic_description 专题描述
    	 * topic_image	专题图片
    	 */
    	$this->authSession();
    	$page_size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);
    	
    	$result = RC_Api::api('topic', 'topic_list', array('page_size' => $page_size, 'current_page' => $page, 'is_page' => 1));
    	$list = array();
    	if (!empty($result['arr'])) {
    		foreach ($result['arr'] as $val) {
    			if (substr($val['topic_img'], 0, 4) != 'http') {
    				$val['topic_img'] = RC_Upload::upload_url().'/'.$val['topic_img'];
    			}
    			$list[] = array(
    					'topic_id'		=> $val['topic_id'],
    					'topic_title'	=> $val['title'],
    					'topic_description' => strip_tags($val['description']),
    					'topic_image'	=> empty($val['topic_img']) ? '' : $val['topic_img']
    			);
    		}
    	}
    	$paginated = array(
    			'total' => $result['page']->total_records,
    			'count' => $result['page']->total_records,
    			'more'  => $result['page']->total_pages <= $page ? 0 : 1,
    	);
    	return array('data' => $list, 'pager' => $paginated);
    }
}


// end