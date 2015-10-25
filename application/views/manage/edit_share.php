<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_share');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	    <dl>
        			<dt>标题：</dt>
        			<dd>
        			<input name="name" type="text" class="required" value="<?php echo $name?>" />
        			<input type="hidden" name="id" value="<?php echo $id?>">
        			</dd>
        		</dl>
        	</fieldset>
        	
        	
      <fieldset>
			<div class="button"><a href="<?php echo site_url('manage/list_subsidiary').'/'.$id;?>" target="dialog" width="800" height="480"><div class="buttonContent"><button type="button">添加分公司</button></div></a></div>
				<table class="list nowrap" width="100%" >
					<thead>
						<tr>
							<th type="text">共享公司列表</th>
							<th type="del" width="30">操作</th>
						</tr>
					</thead>
					<tbody class="tbody" id="file_list">
						<?php if(!empty($list)): 
								foreach($list as $k=>$v):
						?>
						<tr class="unitBox" id="<?php echo "old_".$v->cid;?>">
							<td><?php echo $v->cname;?></td>
							<td><a class="btnDel" href="javascript:remove_company('<?php echo $v->cid?>','<?php echo $v->company_id?>');"><span>删除</span></a></td>
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

function list_company(data){
	data.forEach(function(item){
		$.get('<?php echo site_url('manage/add_share_company').'/'.$id?>/'+item.cid+'/'+item.pid,function(data){
			if(data == '1'){
				html = '<tr class="unitBox" id="old_'+item.cid+'">'
				html += '<td>'+item.cname+'</td>'
				html += '<td><a class="btnDel" href="javascript:remove_company('+ item.cid +','+ item.pid +');"><span>删除</span></a></td>'
				html += '</tr>'
				$("#file_list").append(html);
			}
		});
	});
}

function remove_company(cid,pid){
	$.get('<?php echo site_url('manage/del_share_company').'/'.$id?>/'+cid+'/'+pid,function(data){
		if(data == '1'){
			$('#old_'+cid).remove();
		}
	});
}
</script>

