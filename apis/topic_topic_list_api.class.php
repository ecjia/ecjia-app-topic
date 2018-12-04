<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题列表
 * @author will.chen
 *
 */
class topic_topic_list_api extends Component_Event_Api
{
    /**
     * @param  array $options    条件参数
     * @return array
     */
    public function call(&$options)
    {
        return $this->topic_list($options);
    }

    /**
     * 取得专题列表
     * @param   array $options    条件参数
     * @return  array   专题列表
     */

    private function topic_list($options)
    {
        $db_topic = RC_DB::table('topic');

        $filter                 = array();
        $filter['keywords']     = empty($options['keywords']) ? '' : trim($options['keywords']);
        $filter['is_admin']     = empty($options['is_admin']) ? 0 : 1; //判断是否是后台管理员
        $filter['page_size']    = empty($options['page_size']) ? 15 : intval($options['page_size']);
        $filter['current_page'] = empty($options['current_page']) ? 1 : intval($options['current_page']);

        if (!empty($filter['keywords'])) {
            $db_topic->where('title', 'like', '%' . $filter['keywords'] . '%');
        }
        /* 判断是否是前后台，若前台只显示在活动范围内的*/
        if ($filter['is_admin'] == 0) {
            $db_topic->where('start_time', '<=', RC_Time::gmtime())->where('end_time', '>=', RC_Time::gmtime());
        }

        $count = $db_topic->count();

        $page                   = new ecjia_page($count, $filter['page_size'], 5, '', $filter['current_page']);
        $filter['record_count'] = $count;

        /* 判断是否需要分页 will.chen*/
        if ($options == 1) {
            $db_topic->take($filter['page_size'])->skip($page->start_id - 1);
        }
        $result = $db_topic->get();

        return array('arr' => $result, 'page' => $page);
    }
}
// end
