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
					<input type="text" size="16" name="search_xiaoqu" id="search_xiaoqu" value="<?php echo @$search_xiaoqu;?>" />
				</td>
				<td>
					<label>区域：</label>
					<select class="combox" name="search_region" id="search_region">
						<option value="">-全部-</option>
						<?php          
			                if (!empty($region_list)):
			            	    foreach ($region_list as $row):
			            	    	$selected = !empty($search_region) && $row['id'] == $search_region ? "selected" : "";          
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
					<select class="combox" name="search_type" id="search_type">
						<option value="">-全部-</option>
						<option value="1" <?php if(@$search_type == 1) echo "selected"; ?>>1室</option>
						<option value="2" <?php if(@$search_type == 2) echo "selected"; ?>>2室</option>
						<option value="3" <?php if(@$search_type == 3) echo "selected"; ?>>3室</option>
						<option value="4" <?php if(@$search_type == 4) echo "selected"; ?>>4室</option>
						<option value="5" <?php if(@$search_type == 5) echo "selected"; ?>>5室</option>
						<option value="6" <?php if(@$search_type > 5) echo "selected"; ?>>5室以上</option>
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<label>特色：</label>
					<input type="text" size="16" name="search_feature" id="search_feature" value="<?php echo @$search_feature;?>" />
				</td>
				<td>
					<label>价格：</label>
					<select class="combox" name="search_price" id="search_price">
						<option value="">-全部-</option>
						<option value="1" <?php if(@$search_price == 1) echo "selected"; ?>>50万以下</option>
						<option value="2" <?php if(@$search_price == 2) echo "selected"; ?>>50-80万</option>
						<option value="3" <?php if(@$search_price == 3) echo "selected"; ?>>80-100万</option>
						<option value="4" <?php if(@$search_price == 4) echo "selected"; ?>>100-120万</option>
						<option value="5" <?php if(@$search_price == 5) echo "selected"; ?>>120-150万</option>
						<option value="6" <?php if(@$search_price == 6) echo "selected"; ?>>150-200万</option>
						<option value="7" <?php if(@$search_price == 7) echo "selected"; ?>>200-250万</option>
						<option value="8" <?php if(@$search_price == 8) echo "selected"; ?>>250-300万</option>
						<option value="9" <?php if(@$search_price == 9) echo "selected"; ?>>300-500万</option>
						<option value="10" <?php if(@$search_price == 10) echo "selected"; ?>>500万以上</option>
					</select>
				</td>
				<td>
					<label>面积：</label>
					<select class="combox" name="search_acreage" id="search_acreage">
						<option value="">-全部-</option>
						<option value="1" <?php if(@$search_acreage == 1) echo "selected"; ?>>50平以下</option>
						<option value="2" <?php if(@$search_acreage == 2) echo "selected"; ?>>50-70平</option>
						<option value="3" <?php if(@$search_acreage == 3) echo "selected"; ?>>70-90平</option>
						<option value="4" <?php if(@$search_acreage == 4) echo "selected"; ?>>90-120平</option>
						<option value="5" <?php if(@$search_acreage == 5) echo "selected"; ?>>120-150平</option>
						<option value="6" <?php if(@$search_acreage == 6) echo "selected"; ?>>150-200平</option>
						<option value="7" <?php if(@$search_acreage == 7) echo "selected"; ?>>200-300平</option>
						<option value="8" <?php if(@$search_acreage == 8) echo "selected"; ?>>300平以上</option>
					</select>
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button id="clear_dialog_search">清除查询</button></div></div>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">执行查询</button></div></div>
				</td>
			</tr>
		</table>
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
            				<td><input type="checkbox" name="select" value="{'title':'<?php echo $row->region_name;?> <?php echo $row->xq_name;?> <?php echo $row->room;?>室<?php echo $row->lounge;?>厅 <?php echo $row->acreage;?>㎡ <?php echo $row->total_price;?>万','id':'<?php echo $row->id;?>','bg_pic':'<?php echo $row->bg_pic;?>'}"></td>
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
				<option value="50"  <?php echo $this->input->post('numPerPage')==50?'selected':''?>>50</option>
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
    					<select class="combox" name="wx_user_openid" id="wx_user_openid">
							<option value="-1">所有人</option>
							<?php          
				                if (!empty($wx_users_list)):
				            	    foreach ($wx_users_list as $row):
				            	    	$selected = !empty($open_id) && $row['openid'] == $open_id ? "selected" : "";          
				            ?>
	        							<option value="<?php echo $row['openid']; ?>" <?php echo $selected; ?>><?php echo $row['nickname']; ?></option>
	        					<?php 
				            		endforeach;
				            	endif;
				            ?>
						</select>
    				</div>
    			</li>
    			<li><div class="buttonActive"><div class="buttonContent"><button class="icon-save" onclick="push_house_to_user();">推送房源</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">关闭</button></div></div></li>
    		</ul>
        </div>
</div>
<script>
function push_house_to_user(){
	data = [];
	$('[name="select"]').each(function(){
		if($(this).is(":checked")){
			str = $(this).val();
			json_obj = eval('(' + str + ')');
			data.push(json_obj);
		}
	});
	$.post('<?php echo site_url('manage/push_house_to_user')?>', {data:data, open_id:$("#wx_user_openid").val()}, function(data){
		dialogAjaxDone(JSON.parse(data));
	});
}

//清除查询
$('#clear_dialog_search').click(function(){
	$("#search_xiaoqu").val("");
	$("#search_region").val("");
	$("#search_type").val("");
	$("#search_feature").val("");
	$("#search_price").val("");
	$("#search_acreage").val("");
});
</script>