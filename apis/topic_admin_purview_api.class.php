<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台权限API
 * @author songqian
 *
 */
class topic_admin_purview_api extends Component_Event_Api
{

    public function call(&$options)
    {
        $purviews = array(
            array('action_name' => RC_Lang::get('topic::topic.topic_manage'), 'action_code' => 'topic_manage', 'relevance' => ''),
            array('action_name' => RC_Lang::get('topic::topic.topic_update'), 'action_code' => 'topic_update', 'relevance' => ''),
            array('action_name' => RC_Lang::get('topic::topic.delete_topic'), 'action_code' => 'topic_delete', 'relevance' => ''),
        );

        return $purviews;
    }
}

// end
