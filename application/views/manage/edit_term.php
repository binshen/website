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
        		
        		<dl class="nowrap">
        			<dt>是否推荐：</dt>
        			<dd><select class="combox" name='is_top'>
        			<option value="-1" <?php if(!empty($is_top) && $is_top == '-1') echo 'selected="selected";'?>>否</option>
        			<option value="1" <?php if(!empty($is_top) && $is_top == '1') echo 'selected="selected";'?>>是</option>
        			</select></dd>
        		</dl> 	
        	</fieldset>
			
			<!-- 专题对应房源 -->
			
			<fieldset>
			<div class="button"><a href="<?php echo site_url('manage/list_sd_house_dialog').'/'.$id;?>" target="dialog" width="800" height="480"><div class="buttonContent"><button type="button">添加房源</button></div></a></div>
				<table class="list nowrap" width="100%" >
					<thead>
						<tr>
							<th type="text">二手房标题</th>
							<th type="del" width="30">操作</th>
						</tr>
					</thead>
					<tbody class="tbody" id="file_list">
						<?php if(!empty($list)): 
								foreach($list as $k=>$v):
						?>
						<tr class="unitBox" id="<?php echo "old_".$v->house_id;?>">
							<td><?php echo $v->house_name;?></td>
							<td><a class="btnDel" href="javascript:remove_house('<?php echo $v->house_id?>');"><span>删除</span></a></td>
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

function list_house(data){
	data.forEach(function(item){
		$.get('<?php echo site_url('manage/add_cloud_house').'/'.$id?>/'+item.xq_id,function(data){
			if(data == '1'){
				html = '<tr class="unitBox" id="old_'+item.xq_id+'">'
				html += '<td>'+item.xq_name+'</td>'
				html += '<td><a class="btnDel" href="javascript:remove_house('+item.xq_id+');"><span>删除</span></a></td>'
				html += '</tr>'
				$("#file_list").append(html);
			}
		});
	});
}

function remove_house(house_id){
	$.get('<?php echo site_url('manage/del_cloud_house')?>/'+house_id,function(data){
		if(data == '1'){
			$('#old_'+house_id).remove();
		}
	});
}
</script>

