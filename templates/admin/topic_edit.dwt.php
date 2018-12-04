<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.topic_edit.topic_info_init();
</script>
<!-- {/block} -->
    
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} 
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<div class="tabbable">
		{if $action neq 'insert'}
			<ul class="nav nav-tabs">
				<li class="active"><a class="data-pjax" href='{url path="topic/admin/edit" args="id={$smarty.get.id}"}'>{lang key='topic::topic.tab_general'}</a></li>
				<li><a class="data-pjax" href='{url path="topic/admin/topic_cat" args="id={$smarty.get.id}"}'>{lang key='topic::topic.topic_class'}</a></li>
				<li><a class="data-pjax" href='{url path="topic/admin/topic_goods" args="id={$smarty.get.id}"}'>{lang key='topic::topic.tab_goods'}</a></li>
			</ul>
		{/if}
			<form class="form-horizontal" action="{$form_action}" method="post" enctype="multipart/form-data" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="row-fluid edit-page editpage-rightbar">
							<div class="left-bar move-mod">
								<!--左边-->					
								<div class="control-group formSep">
									<label class="control-label">{lang key='topic::topic.topic_title'}</label>
									<div class="controls">
										<input type="text" name="topic_name" value="{$topic.title}" size="35" />
										<span class="input-must">{lang key='system::system.require_field'}</span>
									</div>
								</div>
							
								<div class="control-group formSep">
									<label class="control-label">{lang key='topic::topic.topic_category'}</label>
									<div class="controls">
										 <select name="topic_type" id="topic_type">
									       <option value='0' {if $topic.topic_type eq '0' } selected="true" {/if}>{lang key='topic::topic.top_img'}</option>
									       <option value='1' {if $topic.topic_type eq '1' } selected="true" {/if}>{lang key='topic::topic.select_flash'}</option>
									       <option value='2' {if $topic.topic_type eq '2' } selected="true" {/if}>{lang key='topic::topic.select_html'}</option>
							      		 </select>
									</div>
								</div>
							
								<!-- 图片 0-->
								<div class="control-group">
									<div id="topic_type_0" style="{if $topic.topic_type eq 0 OR $action eq 'insert'}{else}display:none{/if}">
										<div class="control-group formSep">
											<label class="control-label">{lang key='topic::topic.lable_upload'}</label>
											<div class="controls chk_radio">
												<input type="radio" name="topic_img_type" value='0'{if !$topic.type} checked="checked"{/if} autocomplete="off" /><span>{lang key='topic::topic.remote_connections'}</span>
												<input type="radio" name="topic_img_type" value='1'{if $topic.type} checked="checked"{/if} autocomplete="off" /><span>{lang key='topic::topic.local_upload'}</span>
											</div>
											<div class="controls cl_both topic_img_type" id="show_src">
												<input class="span6" type='text' name='url_logo' size="42" value="{if !$topic.type}{$topic.topic_img}{/if}"/>
												<span class="help-block">{lang key='topic::topic.upload_remark'}</span>
											</div>
											<div class="controls cl_both topic_img_type" id="show_local" style="display:none;">
												<div class="fileupload {if $topic.url && $topic.type && $topic.topic_type eq 0}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
													<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
														{if $topic.url && $topic.type}
														<img src="{$topic.url}" alt="{lang key='topic::topic.picture_preview'}" />
														{/if}
													</div>
													<span class="btn btn-file">
														<span  class="fileupload-new">{lang key='topic::topic.browse'}</span>
														<span  class="fileupload-exists">{lang key='topic::topic.modify'}</span>
														<input type='file' name='topic_img' size="35"/>
													</span>
													<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='topic::topic.delete_file_confirm'}" data-href='{RC_Uri::url("topic/admin/delfile","id={$topic.topic_id}")}' {if $topic.topic_img}data-removefile="true"{/if}>{lang key='topic::topic.delete'}</a>
													<span class="help-block">{lang key='topic::topic.pic_remark'}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							
								<!-- flash 1 -->
								<div id="topic_type_1" style="{if $action eq 'insert' or $topic.topic_type neq 1}display:none{elseif  $topic.topic_type eq 1 }display:block{/if}">
									<div class="control-group formSep">
										<label class="control-label">{lang key='topic::topic.top_flash'}</label>
										{if $topic.topic_img neq '' && $topic.topic_type eq 1}
								      		<div class="t_c">
												<img class="w100 f_l" src="{RC_Uri::admin_url('statics/images/flashimg.png')}" />
											</div>
									    	<div class="ecjiaf-wwb">{lang key='topic::topic.file_address'}{$topic.topic_img}</div>
											<a class="ajaxremove ecjiafc-red ecjiaf-db" data-toggle="ajaxremove" data-msg="{lang key='topic::topic.delete_file_confirm'}" href='{RC_Uri::url("topic/admin/delflash","id={$topic.topic_id}")}' title="{lang key='topic::topic.delete'}">
									        {lang key='topic::topic.delete_file'}
									        </a>
									        <input name="file_name" value="{$article.file_url}" class="hide">
										{else}
										<div class="controls">
											<div data-provides="fileupload" class="fileupload fileupload-new"><input type="hidden" value="" name="">
												<span class="btn btn-file"><span class="fileupload-new">{lang key='topic::topic.select_flash'}</span><span class="fileupload-exists">{lang key='topic::topic.edit_top_flash'}</span><input type="file" name="upfile_flash"></span>
												<span class="fileupload-preview"></span>
												<a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="index.php-uid=1&page=form_extended.html#">&times;</a>
											</div>
										</div>
										{/if}
									</div>
								</div>
							
								<!-- 代码2 -->
								<div id="topic_type_2" style="{if $action eq 'insert' or $topic.topic_type neq 2}display:none{elseif  $topic.topic_type eq 2 }display:block{/if}">
									<div class="control-group formSep">
										<label class="control-label">{lang key='topic::topic.top_html'}</label>
										<div class="controls">
											<textarea name="htmls" cols="50" rows="6" class="span6">{if $topic.topic_type eq 2}{$topic.htmls}{/if}</textarea>
											<span class="input-must">{lang key='system::system.require_field'}</span>
										</div>
									</div>	
								</div>
							
								<div class="control-group">
									<div class="control-group formSep">
										<label class="control-label">{lang key='topic::topic.lable_title_upload'}</label>
										<div class="controls chk_radio">
											<input type="radio" name="title_pic_type" value='0'{if !$topic.type2} checked="checked"{/if} autocomplete="off" /><span>{lang key='topic::topic.remote_connections'}</span>
											<input type="radio" name="title_pic_type" value='1'{if $topic.type2} checked="checked"{/if} autocomplete="off" /><span>{lang key='topic::topic.local_upload'}</span>
										</div>
										<div class="controls cl_both title_pic_type" id="show_src2">
											<input class="span6" type='text' name='url_logo2' size="42" value="{if !$topic.type2}{$topic.title_pic}{/if}"/>
											<span class="help-block">{lang key='topic::topic.upload_remark'}</span>
										</div>
										<div class="controls cl_both title_pic_type" id="show_local2" style="display:none;">
											<div class="fileupload {if $topic.url2 && $topic.type2}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
												<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
													{if $topic.url2 && $topic.type2}
													<img src="{$topic.url2}" alt="{lang key='topic::topic.picture_preview'}" />
													{/if}
												</div>
												<span class="btn btn-file">
													<span  class="fileupload-new">{lang key='topic::topic.browse'}</span>
													<span  class="fileupload-exists">{lang key='topic::topic.modify'}</span>
													<input type='file' name='title_pic' size="35"/>
												</span>
												<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='topic::topic.start_time'}{t}您确定要删除此文件吗？{/t}" data-href='{RC_Uri::url("topic/admin/title_picdel","id={$topic.topic_id}")}' {if $topic.title_pic}data-removefile="true"{/if}>{lang key='topic::topic.delete'}</a>
												<span class="help-block">{lang key='topic::topic.pic_remark_two'}</span>
											</div>
										</div>
									</div>
								</div>
							
								<div class="control-group formSep">
									<label class="control-label">{lang key='topic::topic.lable_base_style'}</label>
									<div class="controls">
										<input type="text" name="base_style" class="" id="cp1" value="{$topic.base_style}" />
									</div>
								</div>
							
								<div class="control-group formSep">
									<label class="control-label">{lang key='topic::topic.start_time'}</label>
									<div class="controls promote_date">
										<input class="date" name="start_time" type="text" class="date" id="start_time" size="22" value='{$topic.start_time}'/>
										<span class="input-must">*</span>
									</div>  
								</div>  
					
								<div class="control-group formSep">
									<label class="control-label">{lang key='topic::topic.end_time'}</label>
									<div class="controls promote_date">
										<input class="date" name="end_time" type="text" class="date" id="end_time" size="22" value='{$topic.end_time}'/>
										<span class="input-must">*</span>
									</div>  
								</div>  
							
								<div class="foldable-list move-mod-group">
									<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#collapse001">
												<strong>{lang key='topic::topic.seo_optimization'}</strong>
											</a>
										</div>
										<div class="accordion-body collapse" id="collapse001">
											<div class="accordion-inner">
												<div class="control-group control-group-small" >
													<label class="control-label">{lang key='topic::topic.keywords'}</label>
													<div class="controls">
														<input class="span12" type="text" name="keywords" value="{$topic.keywords}" size="40" />
														<br />
														<p class="help-block w280 m_t5">{lang key='topic::topic.separated_commas'}</p>
													</div>
												</div>
												<div class="control-group control-group-small" >
													<label class="control-label">{lang key='topic::topic.description'}</label>
													<div class="controls">
														<textarea class="span12 h100" name="description"  cols="40" rows="3">{$topic.description}</textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- 右边 -->
							<div class="right-bar move-mod">
								<div class="foldable-list move-mod-group">
									<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#telescopic1"><strong>{lang key='topic::topic.topic_template_style'}</strong></a>
										</div>
										<div class="accordion-body in collapse" id="telescopic1">
											<div class="accordion-inner">
												<div class="control-group control-group-small">
													<label class="control-label">{lang key='topic::topic.template_file'}</label>
													<div class="span8">
														<input type="text" name="template" value="{$topic.template}"  />
														<span class="help-block">{lang key='topic::topic.notice_template_file'}</span>
													</div>
												</div>
												<div class="control-group control-group-small">
													<label class="control-label">{lang key='topic::topic.style_sheet'}</label>
													<div class="span8">
														<textarea name="topic_css" >{$topic.css}</textarea> 
														<span class="help-block">{lang key='topic::topic.notice_css'}</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<h3 class="heading">
					{lang key='topic::topic.tab_desc'}
				</h3>
				<div class="row-fluid control-group">
					<div class="span12">
						{ecjia:editor content=$topic.intro textarea_name='intro'}
					</div>
				</div>
				
				<div class="control-group">
		        	<div class="controls">
			        	{if $topic.topic_id}
			        		<input  name="topic_data" type="hidden" id="topic_data" value='' />
					        <input name="topic_id" type="hidden" id="topic_id" value='{$topic.topic_id}' />
					        <input type="hidden" id="topic_cat" name="topic_cat" value='{$topic_cat}'>
					        <input type="submit"  value="{lang key='topic::topic.button_update'}" class="btn btn-gebo" />
				        {else}
				       		<input type="submit"  value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				        {/if}
				    </div>
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->