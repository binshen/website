<form id="pagerForm" method="post" action="<?php echo site_url('manage/list_house_push_dialog')?>">
	<input type="hidden" name="pageNum" value="<?php echo $pageNum;?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<input type="hidden" name="orderField" value="<?php echo $this->input->post('orderField');?>" />
	<input type="hidden" name="orderDirection" value="<?php echo $this->input->post('orderDirection');?>" />
</form>
<div class="pageHeader" id="dialog">
	<form onsubmit="return dialogSearch(this);" action="<?php echo site_url('manage/list_house_push_dialog')?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>小区：</label>
					<input type="text" size="16" name="search_xiaoqu" value="<?php echo @$search_xiaoqu;?>" />
				</td>
				<td>
					<label>区域：</label>
					<select class="combox" name="search_region">
						<option value="">-全部-</option>
						<?php          
			                if (!empty($region_list)):
			            	    foreach ($region_list as $row):
			            	    	$selected = !empty(@$search_region) && $row['id'] == @$search_region ? "selected" : "";          
			            ?>
        							<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
        				<?php 
		            			endforeach;
		            		endif;
			            ?>
					</select>
				</td>
				<td>
					<label>房型：</label>
					<select class="combox" name="search_type">
						<option value="">-全部-</option>
						<option value="1" <?php if(@$search_type == 1) echo "selected"; ?>>1室</option>
						<option value="2" <?php if(@$search_type == 2) echo "selected"; ?>>2室</option>
						<option value="3" <?php if(@$search_type == 3) echo "selected"; ?>>3室</option>
						<option value="4" <?php if(@$search_type == 4) echo "selected"; ?>>4室</option>
						<option value="5" <?php if(@$search_type == 5) echo "selected"; ?>>5室</option>
						<option value="6" <?php if(@$search_type > 5) echo "selected"; ?>>5室以上</option>
					</select>
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">执行查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">

	<div layoutH="120" id="list_warehouse_in_print">
	<table class="list" width="100%" targetType="navTab" asc="asc" desc="desc">
		<thead>
			<tr>
				<th width="30">选择</th>
				<th>楼盘</th>
				<th>类型</th>
				<th>区域</th>
				<th>面积</th>
				<th>价格</th>
				<th>房型</th>
				<th>特色</th>
				<th>朝向</th>
			</tr>
		</thead>
		<tbody>
            <?php          
                if (!empty($res_list)):
            	    foreach ($res_list as $row):		               
            ?>		            
            			<tr target="id" rel=<?php echo $row->id; ?>>
            				<td><input type="checkbox" name="select" value="{'xq_id':'<?php echo $row->id;?>', 'xq_name':'<?php echo $row->name;?>'}"></td>
            				<td><?php echo $row->xq_name; ?></td>
            				<td><?php echo $row->style_name; ?></td>
            				<td><?php echo $row->region_name; ?></td>
            				<td><?php echo $row->acreage; ?>㎡</td>
            				<td><?php echo $row->total_price; ?>万</td>
            				<td><?php echo $row->room; ?>室</td>
            				<td><?php echo $row->feature;?></td>
            				<td><?php echo $row->orientation_name;?></td>
            			</tr>
            <?php 
            		endforeach;
            	endif;
            ?>
		</tbody>
	</table>
	</div>
	<div class="panelBar" >
		<div class="pages">
			<span>显示</span>
			<select name="numPerPage" class="combox" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="50" <?php echo  $this->input->post('numPerPage')==50?'selected':''?>>50</option>
				<option value="100" <?php echo $this->input->post('numPerPage')==100?'selected':''?>>100</option>
				<option value="200" <?php echo $this->input->post('numPerPage')==200?'selected':''?>>200</option>
			</select>
			<span>条，共<?php  echo $countPage;?>条</span>
		</div>		
		<div class="pagination" targetType="dialog" totalCount="<?php echo $countPage;?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>
	</div>
	<div class="formBar">
    		<ul>
    			<li>
    				<div>
    					<select class="combox" name="open_id">
							<option value="">所有人</option>
							<?php          
				                if (!empty($wx_users_list)):
				            	    foreach ($wx_users_list as $row):
				            	    	$selected = !empty(@$open_id) && $row['openid'] == @$open_id ? "selected" : "";          
				            ?>
	        							<option value="<?php echo $row['openid']; ?>" <?php echo $selected; ?>><?php echo $row['nickname']; ?></option>
	        					<?php 
				            		endforeach;
				            	endif;
				            ?>
						</select>
    				</div>
    			</li>
    			<li><div class="buttonActive"><div class="buttonContent"><button class="icon-save" onclick="bringBack_current();">推送房源</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">关闭</button></div></div></li>
    		</ul>
        </div>
</div>
<script>
function bringBack_current(){
	data = [];
	$('[name="select"]').each(function(){
		if($(this).is(":checked")){
			str = $(this).val();
			json_obj = eval('(' + str + ')');
			data.push(json_obj);
		}
	});
	list_house(data);
	$.pdialog.closeCurrent();
}
</script>