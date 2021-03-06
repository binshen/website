<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_subsidiary');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	<legend>分店信息</legend>
        	    <dl>
        			<dt>分店名称：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        				<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>所属公司：</dt>
        			<dd>
        				<select name="company_id" class="combox">
        					<?php          
				                if (!empty($company_list)):
				            	    foreach ($company_list as $row):
				            	    	$selected = $row->id == $company_id ? "selected" : "";          
				            ?>
        								<option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
        					<?php 
				            		endforeach;
				            	endif;
				            ?>
        				</select>
        		</dl>
        		<dl>
        			<dt>可开业务员数：</dt>
        			<dd>
        				<?php if($is_admin) { ?>
        					<input name="broker_count" type="text" class="required" value="<?php if(!empty($broker_count)) echo $broker_count;?>" />
        				<?php } else { ?>
        					<?php if(!empty($broker_count)) echo $broker_count;?>
        					<input name="broker_count" type="hidden" value="<?php if(!empty($broker_count)) echo $broker_count;?>" />
        				<?php } ?>
        			</dd>
        		</dl>
        		<dl>
        			<dt>可添加二手房数：</dt>
        			<dd>
        				<?php if($is_admin) { ?>
        					<input name="house_count" type="text" class="required" value="<?php if(!empty($house_count)) echo $house_count;?>" />
        				<?php } else { ?>
        					<?php if(!empty($house_count)) echo $house_count;?>
        					<input name="house_count" type="hidden" value="<?php if(!empty($house_count)) echo $house_count;?>" />
        				<?php } ?>
        			</dd>
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
<script>

</script>
