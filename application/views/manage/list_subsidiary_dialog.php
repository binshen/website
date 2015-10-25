<form id="pagerForm" method="post" action="<?php echo site_url('manage/list_subsidiary').'/'.$tid?>">
	<input type="hidden" name="pageNum" value="<?php echo $pageNum;?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<input type="hidden" name="orderField" value="<?php echo $this->input->post('orderField');?>" />
	<input type="hidden" name="orderDirection" value="<?php echo $this->input->post('orderDirection');?>" />
</form>

<div class="pageHeader" id="dialog">
	<form onsubmit="return dialogSearch(this);" action="<?php echo site_url('manage/list_subsidiary').'/'.$tid?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
				<select class="combox" name="company_id">
				<option value="">-请选择总公司-</option>
				<?php foreach ($select as $v):?>
				<option value="<?php echo $v['id']?>" <?php if($v['id'] == $company_id) echo "selected='selected'";?>><?php echo $v['name']?></option>
				<?php endforeach;?>
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
				<th>分店名称</th>
				<th>所属公司</th>
			</tr>
		</thead>
		<tbody>
            <?php          
                if (!empty($res_list)):
            	    foreach ($res_list as $row):		               
            ?>		            
            			<tr target="id" rel=<?php echo $row->id; ?>>
            				<td><input type="checkbox" name="select" value="{'cid':'<?php echo $row->id;?>', 'cname':'<?php echo $row->name;?>','pid':'<?php echo $row->company_id?>'}"></td>
            				<td><?php echo $row->name;?></td>
            				<td><?php echo $row->company_name;?></td>
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
		<div class="pagination" targetType="dialog" totalCount="<?php echo $countPage;?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>
	</div>
		<div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button class="icon-save" onclick="bringBack_current();">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
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
	list_company(data);
	$.pdialog.closeCurrent();
}
</script>