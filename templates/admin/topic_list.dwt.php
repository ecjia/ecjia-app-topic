<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.topic_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
	<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='topic::topic.bulk_operations'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='topic/admin/batch'}" data-msg="{lang key='topic::topic.do_confirm'}" data-noSelectMsg="{lang key='topic::topic.please_select_delete_topic'}" data-name="topic_id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='topic::topic.delete_topic'}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$topic_list.filter.keywords}" placeholder="{lang key='topic::topic.js_languages.topic_name_empty'}"/>
			<button class="btn search_topic" type="button">{lang key='topic::topic.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
                	<th>{lang key='topic::topic.list_topic_name'}</th>
			    	<th class="w150">{lang key='topic::topic.list_start_time'}</th>
			    	<th class="w150">{lang key='topic::topic.list_end_time'}</th>
                </tr>
		  	</thead>
			<tbody>
            	<!-- {foreach from=$topic_list.topic item=topic} -->
			    <tr>
				    <td>
				        <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$topic.topic_id}"/></span>
				    </td>
				    <td class="hide-edit-area">
				    	 <span class="cursor_pointer" data-text="text" data-trigger="editable" 
				    	 data-url="{RC_Uri::url('topic/admin/edit_title')}" data-name="title" data-pk="{$topic.topic_id}" data-title="{lang key='topic::topic.edit_topic_name'}" >{$topic.title}</span>
				    	 <div class="edit-list">
					      	<a href='{RC_Uri::url("topic/admin/preview", "id={$topic.topic_id}")}' title="{lang key='topic::topic.preview'}"  target="_blank" >{lang key='topic::topic.preview'}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{RC_Uri::url("topic/admin/edit","id={$topic.topic_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{url path="topic/admin/topic_cat" args="id={$topic.topic_id}"}' title="{lang key='topic::topic.topic_class'}">{lang key='topic::topic.topic_class'}</a>&nbsp;|&nbsp; 
					      	<a class="data-pjax" href='{url path="topic/admin/topic_goods" args="id={$topic.topic_id}"}' title="{lang key='topic::topic.tab_goods'}">{lang key='topic::topic.tab_goods'}</a>&nbsp;|&nbsp; 
						    <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='topic::topic.delete_topic_confirm'}" href='{RC_Uri::url("topic/admin/remove", "id={$topic.topic_id}")}' title="{lang key='topic::topic.delete'}">{lang key='topic::topic.delete'}</a> 
					     </div>
					</td>
				    <td>{$topic.start_time}</td>
				    <td>{$topic.end_time}</td>
			    </tr>
		   	 	<!-- {foreachelse} -->
                <tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
                <!-- {/foreach} -->
            </tbody>
		</table>
		<!-- {$topic_list.page} -->
	</div>
</div>
<!-- {/block} -->