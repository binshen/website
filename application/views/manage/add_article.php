<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_article');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	    <dl>
        			<dt>标题：</dt>
        			<dd>
        			<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        			<input name="title" type="text" class="required" value="<?php if(!empty($title)) echo $title;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>是否强推：</dt>
        			<dd><select class="combox" name='force_show'>
        			<option value="-1" <?php if(!empty($force_show) && $force_show == '-1') echo 'selected="selected";'?>>否</option>
        			<option value="1" <?php if(!empty($force_show) && $force_show == '1') echo 'selected="selected";'?>>是</option>
        			</select></dd>
        		</dl>
        	</fieldset>
    	<fieldset>
    	    <legend>新闻详情</legend>
    	    <dl class="nowrap">
    			<dd><textarea class="editor" name="content" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  ><?php if(!empty($content)) echo $content;?></textarea></dd>
    		</dl>
    	</fieldset>
        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>

