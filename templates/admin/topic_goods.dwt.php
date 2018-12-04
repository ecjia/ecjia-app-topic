<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li><a class="data-pjax" href='{url path="topic/admin/edit" args="id={$smarty.get.id}"}'>{lang key='topic::topic.tab_general'}</a></li>
				<li><a class="data-pjax" href='{url path="topic/admin/topic_cat" args="id={$smarty.get.id}"}'>{lang key='topic::topic.topic_class'}</a></li>
				<li class="active"><a href="javascript:;">{lang key='topic::topic.tab_goods'}</a></li>
			</ul>
			
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" data-action="{$select_action}">
				<div class="tab-content">
					<fieldset>
						<div class="control-group">
						<label><span>{lang key='topic::topic.please_select_topic_category'}</span></label>
							<div>
								<select id="topic_cat_select">
								<!-- {foreach from=$topic_cat  item=value  key=key} -->
								<!-- {if $key neq 'default' } -->
								<option value="{$key}" {if $key eq $smarty.get.key}selected="true"{/if}>{$key}</option>
								<!-- {else} -->
								<option value="{$key}">{lang key='topic::topic.no_category'}</option>
								<!-- {/if} -->
								<!-- {/foreach} -->			
								</select>
							</div>
						</div>
						
						<div class="control-group" data-url="{url path='topic/admin/get_goods_list'}">
							<div class="f_l"> 
								<select name="cat_id">
								<option value="0">{lang key='system::system.all_category'}{$cat_list}</option>
								</select>
								<select name="brand_id">
								<option value="0">{lang key='system::system.all_brand'}{html_options options=$brand_list}</option>
								</select>
							</div> 
								<input type="text" name="keyword" />
								<a class="btn" data-toggle="searchGoods">{lang key='system::system.button_search'}</a>
						</div>
						<div class="control-group draggable">
							<div class="ms-container " id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder="{lang key='topic::topic.filter_information'}" autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready">
										<li class="ms-elem-selectable disabled"><span>{lang key='topic::topic.no_content'}</span></li>
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">{lang key='topic::topic.selected_goods'}</div>
									<ul class="ms-list nav-list-content" id="target_select">
										<!-- {foreach from=$topic_cats  item=value  key=k} -->
											<!-- {foreach from=$value item=v key=kk} -->
											<li class="ms-elem-selection {if $k neq $keys}hide{else}isShow{/if}" data-key="{$k}">
												<input type="hidden" value="{$v}|{$kk}" name="goods_id[{$k}_{$kk}]" data-value="{$kk}" />
												<span>{$v}</span>
												<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
											</li>
											<!-- {/foreach} -->
										<!-- {/foreach} -->
									</ul>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="ecjiaf-tac">
	        		{if $topic_id}
		        		<input type="hidden"  value="{$topic_id}" id="topic_id" />
				        <input type="hidden"  name="selectkey" value="{$key}" />
				        <input type="submit"  value="{lang key='topic::topic.button_update'}" class="btn btn-gebo" />
					{else}
			       		<input type="submit"  value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
					{/if}
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->