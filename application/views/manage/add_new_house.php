<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_project');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        
        
        <fieldset>
    	    <legend>图片预览</legend>
    	    <dl class="nowrap">
    	    	<dt>
    	    		<input type="hidden" name="folder" value="<?php if(!empty($folder)) echo $folder;?>" id="folder">
    	    		<a id="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis'))?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    	</dt>
    		</dl>
    		<dl class="nowrap" id="append">
    		
    		</dl>
    	</fieldset>
        
        
        	<fieldset>
        	<legend>注：图片建议上传尺寸为608px*430px,最大不超过1M</legend>
        	    <dl>
        			<dt>项目名称：</dt>
        			<dd><input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>"><input name="project" type="text" class="required" value="<?php if(!empty($project)) echo $project;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>照片：</dt>
        			<dd>
        			<div class="file-box">
        			<input type="hidden" name="old_img" value="<?php if(!empty($pic)) echo $pic;?>" />
    				<input type='text' id='textfield' class='txt' value="<?php if(!empty($pic)) echo $pic;?>" />  
			 		<input type='button' class='btn' value='浏览...' />
					<input type='file' name='imgfile' class='file' id='fileField'  onchange="document.getElementById('textfield').value=this.value" />
					</div>
        			</dd>
        		</dl>
				<?php if(!empty($pic)):?>
        	    <dl class="nowrap">
        			<dt>图片预览：</dt>
        			<dd><img height="100px" src="<?php echo base_url().'uploadfiles/huxing/'.$pic;?>" /></dd>
        		</dl>
        	    <?php endif;?>
        		<dl>
        			<dt>报备有效期：</dt>
        			<dd><input type="text" name="bb_valid" class="required number" value="<?php if(!empty($bb_valid)) echo $bb_valid;?>" />天</dd>
        		</dl>
        		<dl>
        			<dt>签约有效期：</dt>
        			<dd><input type="text" name="qy_valid" class="required number" value="<?php if(!empty($qy_valid)) echo $qy_valid;?>" />天</dd>
        		</dl>
        		
        		<dl>
        			<dt>均价：</dt>
        			<dd><input type="text" name="price" class="required" value="<?php if(!empty($price)) echo $price;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>开盘时间：</dt>
        			<dd><input type="text" name="kaipan" class="date required" value="<?php if(!empty($kaipan)) echo $kaipan;?>" readonly/><a class="inputDateButton" href="javascript:;">选择</a>
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>开发商：</dt>
        			<dd><input type="text" name="kaifa" class="required" value="<?php if(!empty($kaifa)) echo $kaifa;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>物业公司：</dt>
        			<dd><input type="text" name="wuye_gongsi" class="required" value="<?php if(!empty($wuye_gongsi)) echo $wuye_gongsi;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>物业类型：</dt>
        			<dd><input type="text" name="wuye_leixing" class="required" value="<?php if(!empty($wuye_leixing)) echo $wuye_leixing;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>建筑类型：</dt>
        			<dd><input type="text" name="jianzhu_leixing" class="required" value="<?php if(!empty($jianzhu_leixing)) echo $jianzhu_leixing;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>建筑面积：</dt>
        			<dd><input type="text" name="jianzhu_mianji" class="required" value="<?php if(!empty($jianzhu_mianji)) echo $jianzhu_mianji;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>装修情况：</dt>
        			<dd><input type="text" name="zhuangxiu" class="required" value="<?php if(!empty($zhuangxiu)) echo $zhuangxiu;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>总户数：</dt>
        			<dd><input type="text" name="hushu" class="required" value="<?php if(!empty($hushu)) echo $hushu;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>车位数：</dt>
        			<dd><input type="text" name="chewei" class="required" value="<?php if(!empty($chewei)) echo $chewei;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>容积率：</dt>
        			<dd><input type="text" name="rongji" class="required" value="<?php if(!empty($rongji)) echo $rongji;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>绿化率：</dt>
        			<dd><input type="text" name="ludi" class="required" value="<?php if(!empty($ludi)) echo $ludi;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>物业费：</dt>
        			<dd><input type="text" name="wuyefei" class="required" value="<?php if(!empty($wuyefei)) echo $wuyefei;?>" /></dd>
        		</dl>
        		
        		
        		
        	</fieldset>
			<fieldset>
	    	    <legend>楼盘详情</legend>
	    	    <dl class="nowrap">
	    			<dd><textarea class="editor" name="remark" rows="22" cols="100" upImgExt="jpg,jpeg,gif,png"  tools="simple"><?php if(!empty($remark)) echo $remark;?></textarea></dd>
	    		</dl>
    		</fieldset>
    		<fieldset>
				<table class="list nowrap itemDetail" addButton="添加户型" width="100%" >
					<thead>
						<tr>
							<th type="text" width="80"name="huxing[]"  fieldClass="required" size="30">户型</th>
							<th type="file_class" name="userfile#index#" size="10" >图片</th>
							<th type="del" width="30">操作</th>
						</tr>
					</thead>
					<tbody class="tbody" id="file_list">
						<?php if(!empty($list)): 
								foreach($list as $k=>$v):
						?>
						<tr class="unitBox" id="<?php echo "olda".$v->id;?>">
							<td><input type="text" class="required" size='30' name="huxing[]" value="<?php echo $v->huxing?>"></td>
							<td>
								<input type="hidden" name="old_img_a[]" value="<?php echo $v->pic;?>" />
			    				<input type='text' class='txt' name="view_pic" path="<?php echo base_url().'uploadfiles/huxing/'.$v->pic;?>" value="<?php echo $v->pic;?>" readonly/>  
						 		<input type='button' class='btn' value='浏览...' onclick="fileBtnClick(this);" />
								<input type='file' name='<?php echo 'userfile'.$k;?>' class='file' id='fileField'  onchange="change_pic(this);" />
							</td>
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
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save" onclick="change_file_name();">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>
<script>
$(function(){
	var x = 0;
	var y = 0;
	$('[name="view_pic"]').mouseover(function(e){
		var path = $(this).attr('path');
		var tooltip = "<div id='tooltip' style='position:absolute'><img src='"+path+"'/><\/div>"; //创建 div 元素
		$("body").append(tooltip);	//把它追加到文档中						 
		$("#tooltip")
			.css({
				"top": (e.pageY+y+10) + "px",
				"left":  (e.pageX+x+10)  + "px"
			}).show("fast");	  //设置x坐标和y坐标，并且显示
    }).mouseout(function(){
		$("#tooltip").remove();	 //移除 
    }).mousemove(function(e){
		$("#tooltip")
		.css({
			"top": (e.pageY+y) + "px",
			"left":  (e.pageX+x)  + "px"
		});
});;
});
function fileBtnClick(obj){
	$(obj).next().click();
}
function change_pic(obj){
	var val = $(obj).val();
	$(obj).prev().prev().val(val);
}
function change_file_name(){
	$("#file_list").find('[type="file"]').each(function(index){
		$(this).attr("name","userfile"+index);
	});
}
</script>

<script>
$(function() {
	folder = $("#folder",navTab.getCurrentPanel()).val();
	if(folder != ''){
		callbacktime(folder,-1);
	}
    $("#tpsc",navTab.getCurrentPanel())
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
    $('[name="desc[]"]').each(function(){
        if($(this).val() != '请输入图片描述'){
        	$(this).css('color','black');
        }
    });
});

function change_val_f(obj){
	  $(obj).css('color','black');
  	  if($(obj).val() =='请输入图片描述'){
          $(obj).val("");           
  	  } 
}

function change_val_b(obj){
 	 if ($(obj).val() == '') {
         $(obj).val('请输入图片描述');
         $(obj).css('color','#999');
      }
}

function callbacktime(time,is_back){
	id = $("[name='id']",navTab.getCurrentPanel()).val();
	if (id == ''){
		$("#folder",navTab.getCurrentPanel()).val(time);		
	}
	$.getJSON("<?php echo site_url('manage/get_pics')?>"+"/"+time + "?_=" +Math.random(),function(data){
		html = '';
		now_pic = [];
		$("input[name='pic_short[]']").each(function(index){
			now_pic[index] = $(this).val();
		});
		console.log(now_pic);
		$.each(data.img,function(index,item){
			path = "<?php echo base_url().'uploadfiles/pics/';?>"+data.time+"/"+item;
			if($.inArray(item, now_pic) < 0){
				html+='<dt style="width: 250px; position:relative; margin-top:20px">';
				html+='<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; ">';
				html+='<a href="javascript:void(0);" onclick="del_pic(this);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this);" style="text-decoration:none; color:#fff">设为封面</a></div>';
				html+='<div class="fengmian"></div>';
				html+='<img height="118" width="200" src="'+path +'" style="border:1px solid #666;"><input type="text" alt="text" size="31" class="textInput" name="desc[]" style="width:195px;height:20px;border:1px solid #999;font-size:12px;font-weight:lighter;outline:none;margin-top:5px;color:#999;" onfocus="change_val_f(this);" onblur="change_val_b(this);" value="请输入图片描述">';
				html+='<input type="hidden" size="22" name="is_bg[]" value="0"><input type="hidden" size="22" name="pic_short[]" value="'+item+'"></dt>';
			}
		});
		$("#append",navTab.getCurrentPanel()).append(html); 
	});

	//兼容chrome
	var isChrome = navigator.userAgent.toLowerCase().match(/chrome/) != null;
	if (isChrome)
		event.returnValue=false;
	
}
function set_bg(obj){
	//将所有是否为封面都变成0，将封面图片删除
	$(obj).parent().parent().parent().find('input:[name="is_bg[]"]').each(function(){
		$(this).val('0');
	});
	$(".fengmian",navTab.getCurrentPanel()).html('');
	
	current_bg = $(obj).parent().parent().find('input:[name="is_bg[]"]');
	current_bg.val('1');
	html_img = '<img src="<?php echo base_url().'images/fengmian.png';?>" style=" position:absolute; top:0px;">';
	$(obj).parent().parent().find('.fengmian').html(html_img);
}
function del_pic(obj){
	id = $("[name='id']",navTab.getCurrentPanel()).val();
	folder = $("[name='folder']",navTab.getCurrentPanel()).val();
		current_pic = $(obj).parent().parent().find('input:[name="pic_short[]"]').val();
		$.getJSON("<?php echo site_url('manage/del_pic')?>"+"/"+ folder + "/" + current_pic + "/" + id,function(data){
			if(data.flag == 1){
				$("#append",navTab.getCurrentPanel()).find('input[name="pic_short[]"]').each(function(){
					if($(this).val() == data.pic){
						$(this).parent().remove();
					}
				});
			}else{
				alertMsg.warn("删除图片失败，请清理图片缓存并刷新标签页");
			}
		});
}
</script>
