<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_term');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	    <dl>
        			<dt>名称：</dt>
        			<dd>
        			<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        			<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name;?>" />
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>标题：</dt>
        			<dd>
        			<input name="title" type="text" value="<?php if(!empty($title)) echo $title;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>封面图片：</dt>
        			<dd>
        			<div class="file-box">
        			<input type="hidden" name="old_img" value="<?php if(!empty($pic)) echo $pic;?>" />
    				<input type='text' id='textfield' class='txt' value="<?php if(!empty($pic)) echo $pic;?>" />  
			 		<input type='button' class='btn' value='浏览...' />
					<input type="file" name="userfile" class="file" id="fileField"  onchange="document.getElementById('textfield').value=this.value" />
					</div>
        			</dd>
        		</dl>
				
        	    <dl class="nowrap">
        			<dt>图片预览：</dt>
        			<dd id="img"><?php if(!empty($pic)):?><img height="100px" src="<?php echo base_url().'uploadfiles/term/'.$pic;?>" /><?php endif;?></dd>
        		</dl>     	
        	</fieldset>
			
			<!-- 专题对应房源 -->
			
			<fieldset>
			<div class="button"><a href="<?php echo site_url('manage/list_sd_house_dialog');?>" target="dialog"><div class="buttonContent"><button type="button">添加房源</button></div></a></div>
				<table class="list nowrap" width="100%" >
					<thead>
						<tr>
							<th type="text" width="80" name="month[]"  fieldClass="required" size="30">月份</th>
							<th type="file_class" name="price[]" fieldClass="required" size="10" >价格</th>
							<th type="del" width="30">操作</th>
						</tr>
					</thead>
					<tbody class="tbody" id="file_list">
						<?php if(!empty($list)): 
								foreach($list as $k=>$v):
						?>
						<tr class="unitBox" id="<?php echo "olda".$v->id;?>">
							<td><input type="text" class="required" size='30' name="month[]" value="<?php echo $v->month?>"></td>
							<td><input type="text" class="required" size='10' name="price[]" value="<?php echo $v->price?>"></td>
							<td><a class="btnDel" href="javascript:$('#olda<?php echo $v->id;?>').remove();void(0);"><span>删除</span></a></td>
						</tr>
						<?php 
								endforeach;
							endif;
								
						?>
					</tbody>
				</table>
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
$("#fileField").change(function(){
	var objUrl = getObjectURL(this.files[0]);
	if (objUrl) {
		html = '<img height="100px" src="'+objUrl+'" />';
		$("#img").html(html) ;
	}
}) ;
//建立一個可存取到該file的url
function getObjectURL(file) {
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}
</script>

