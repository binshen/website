<form id="pagerForm" method="post" action="<?php echo site_url('manage/list_house_push')?>">
	<input type="hidden" name="pageNum" value="<?php echo $pageNum;?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<input type="hidden" name="open_id" value="<?php echo @$open_id;?>" />
	<input type="hidden" name="date" value="<?php echo @$date;?>" />
	<input type="hidden" name="orderField" value="<?php echo $this->input->post('orderField');?>" />
	<input type="hidden" name="orderDirection" value="<?php echo $this->input->post('orderDirection');?>" />
</form>
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php site_url('manage/list_house_push')?>" method="post">
	<div class="searchBar">
		<table class="searchContent" id="search_purchase_order">
			<tr>
				<td>
					<label>客户：</label>
					<select class="combox" name="open_id">
						<option value="">-全部-</option>
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
				</td>
				<td><label>推送时间：</label><input type="text" class="date" size="16" name="date" value="<?php echo @$date; ?>" /></td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
			    <li><div class="button"><div class="buttonContent"><button id="clear_search">清除查询</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">执行查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="<?php echo site_url('manage/list_house_push_dialog')?>" target="dialog" width="960" height="480" rel="add_news" title="推送"><span>推送</span></a></li>
		</ul>
	</div>

	<div layoutH="116" id="list_warehouse_in_print">
	<table class="list" width="100%" targetType="navTab" asc="asc" desc="desc">
		<thead>
			<tr>
				<th orderField="open_id" <?php echo $this->input->post('orderField')=='open_id'?'class="'.$this->input->post('orderDirection').'"':'';?>>客户</th>
				<th orderField="house_id" <?php echo $this->input->post('orderField')=='house_id'?'class="'.$this->input->post('orderDirection').'"':'';?>>楼盘</th>
				<th width="150" orderField="date" <?php echo $this->input->post('orderField')=='date'?'class="'.$this->input->post('orderDirection').'"':'';?>>推送时间</th>
			</tr>
		</thead>
		<tbody>
            <?php          
                if (!empty($res_list)):
            	    foreach ($res_list as $row):		               
            ?>		            
            			<tr target="id" rel=<?php echo $row->id; ?>>
            				<td><?php echo $row->nickname;?> (<?php echo $row->open_id;?>)</td>
            				<td><?php echo $row->name;?> (<?php echo $row->house_id;?>)</td>
            				<td><?php echo $row->date;?></td>
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
				<option value="20" <?php echo $this->input->post('numPerPage')==20?'selected':''?>>20</option>
				<option value="50" <?php echo  $this->input->post('numPerPage')==50?'selected':''?>>50</option>
				<option value="100" <?php echo $this->input->post('numPerPage')==100?'selected':''?>>100</option>
				<option value="200" <?php echo $this->input->post('numPerPage')==200?'selected':''?>>200</option>
			</select>
			<span>条，共<?php  echo $countPage;?>条</span>
		</div>		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $countPage;?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>
	</div>
</div>
<script>
//清除查询
$('#clear_search',navTab.getCurrentPanel()).click(function(){
	$(".searchBar",navTab.getCurrentPanel()).find("input").each(function(){
		$(this).val("");
	});
	$(".searchBar",navTab.getCurrentPanel()).find("select option").each(function(index){
		if($(this).val() == "")
		{
			$(this).attr("selected","selected");
		}
	});
});
</script>