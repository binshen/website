<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
        <div class="pageFormContent" layoutH="55">

      		<fieldset>
			<div class="button"><a href="<?php echo site_url('manage/list_sd_house_cloud');?>" target="dialog" width="800" height="480"><div class="buttonContent"><button type="button">添加云房源</button></div></a></div>
				<table class="list nowrap" width="100%" >
					<thead>
						<tr>
							<th type="text">云房源列表</th>
							<th type="del" width="30">操作</th>
						</tr>
					</thead>
					<tbody class="tbody" id="file_list">
						<?php if(!empty($list)): 
								foreach($list as $k=>$v):
						?>
						<tr class="unitBox" id="<?php echo "old_".$v->id;?>">
							<td><?php echo $v->name;?></td>
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
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">关闭</button></div></div></li>
    		</ul>
        </div>
</div>
<script>
	function list_house(data){
		data.forEach(function(item){
			$.get('<?php echo site_url('manage/add_cloud_house')?>/'+item.xq_id,function(data){
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

