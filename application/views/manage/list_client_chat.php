<link href="/chat/css/dialogue-backer.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/chat/css/jquery.mCustomScrollbar.css">
<body>
  <div class="dialogue-main">
       <div class="dialogue-left">
          <div class="dialogue-left-body">
            <ul class="dialogue-cus-list" id="cus-list">
            	<?php 
            		if (!empty($wx_users_list)):
            			$sex = array('1' => '男', '2' => '女');
            			foreach ($wx_users_list as $i => $row):
            	?>
			                <li>
			                  <span class="dialogue-cus-head dialogue-cus-head-female">
			                    <img src="<?php echo $row['headimgurl']; ?>" alt="" id="<?php echo $row['open_id']; ?>" style="height: 36px;width:36px;"/>
			                  	<i class="dialogue-message-number-i" id="number_<?php echo $row['open_id']; ?>"></i>
			                  </span>
			                  <span class="dialogue-cus-txt">
			                  	<i class="dialogue-cus-name"> 姓名：<?php echo $row['nickname']; ?></i>
			                  	<br /> 性别：<?php echo @$sex[$row['sex']]; ?>
			                  	<input type="hidden" class="cus-open-id" value="<?php echo $row['open_id']; ?>" />
			                  	<span style="padding-left:15px; color:green" id="status_<?php echo $row['open_id']; ?>">OFF</span>
			                  </span>
			                </li>
				<?php 
	            		endforeach;
	            	endif;
	            ?>
            </ul>
            <div id="tool">
                 <span id="tool-bar"></span>
            </div>
          </div>
       </div>
       <div class="dialogue-center">
          <div class="dialogue-center-name" id="dialogue-center-name">请选择想要聊天的客户</div>
          <div class="dialogue-center-chat" id="dialogue-center-chat">
          	<div class="dialogue-center-chat-inner" id="dialogue-center-chat-inner">
          	</div>
          </div>
          <div class="dialogue-center-input">
              <div class="dialogue-chat-txt-input">
                  <input type="text" id="msg_box" value="" class="dialogue-input-txt" />
                  <a href="javascript:void(0)" class="dialogue-set-btn" id="btnSendMsg">发送</a>
              </div>
              <div class="dialogue-chat-input-head">
              </div>
          </div>
       </div>
       <div class="dialogue-right">
          	<div class="dialogue-right-tit">浏览记录</div>
          	<div class="dialogue-right-body" id="dialogue-right-body">
          	</div>
       </div>
  </div>
<script src="/chat/js/jquery.mCustomScrollbar.min.js"></script>
<!-- <script type="text/javascript" src="http://121.40.97.183:4000/socket.io/socket.io.js"></script> -->
<script type="text/javascript" src="/chat/socket.io.js"></script>
<script>
var broker_id = '<?php echo $this->session->userdata('user_id'); ?>';
var socket = io.connect('http://121.40.97.183:4000');

socket.on('disconnect',function(){
	console.log('disconnected')
});

socket.on('reconnect',function(){
	console.log('reconnected')
});

socket.on('receive-message', function (data) {
	var data = JSON.parse(data);
	
	var open_id = $("#selectedUser").val();
	var user_id = data.user_id;
	var target_id = data.target_id;
	var user_type = data.user_type;
	if((user_type == 1 && open_id == user_id) || (user_type == 2 && open_id == target_id)) {
		var html = getMessageText(data);
		$("#dialogue-center-chat-inner").append(html);
		$("#dialogue-center-chat").mCustomScrollbar('update');
	    $("#dialogue-center-chat").mCustomScrollbar("scrollTo","bottom");
	}
	if(user_type == 1) {
		play_ring("/chat/ring/msg.wav");
	}

	if(user_type == 1) {
		var count = data.count
		if(count > 0) {
			$("#number_" + user_id).text('<em class="dialogue-message-number">' + count + '</em>');
		}
	}
});

socket.on('receive-history', function (data) {
	var data = JSON.parse(data);
	var messages = data.reverse();
	var html = "";
	for(var i in messages) {
    	var message = JSON.parse(messages[i])
		html += getMessageText(JSON.parse(messages[i]))
	}
	$("#dialogue-center-chat-inner").html(html);
	$("#dialogue-center-chat").mCustomScrollbar('update');
    $("#dialogue-center-chat").mCustomScrollbar("scrollTo","bottom");
});

socket.on('show-status',function(data){
	var data = JSON.parse(data);
	var user_id = data.user_id;
	var status = data.status;
	if(status) {
		$("#status_" + user_id).text("ON");
		$("#status_" + user_id).css('color', 'red');
	} else {
		$("#status_" + user_id).text("OFF");
		$("#status_" + user_id).css('color', 'green');
	}
});

$(function(){
	var windowHei = $(window).height();
	var leftPx = parseInt(windowHei-120)+'px';
	var centerPx = parseInt(windowHei-155-120)+'px';
	var rightPx = parseInt(windowHei-180)+'px';
	$('#dialogue-center-chat').height(centerPx);
	$('#tool1').height(centerPx);
	$('#cus-list').height(leftPx);
	$("#cus-list").mCustomScrollbar();
	$('#tool').height(leftPx);
	$('#dialogue-right-body').height(rightPx);
	$("#dialogue-center-chat").mCustomScrollbar();

	for(var i=0; i<$('.imgToGray').length;i++){
		$('.imgToGray')[i].src = gray($('.imgToGray')[i]);
	}

	socket.emit('online', JSON.stringify({ "user_id": broker_id, "user_type": 2 }));
	
/////////////////////////////////////////////////////////////////////////
	$("#cus-list li").click(function(){
	    $("#cus-list li").removeClass('current');
	    $(this).addClass('current');
	    $("#dialogue-center-name").html($(this).children().find(".dialogue-cus-name").html());

	    var open_id = $(this).children().find(".cus-open-id").val();
	    list_house_tracks(open_id);
	    
		$("#selectedUser").val(open_id);

		socket.emit('show-history', JSON.stringify({ "user_id": broker_id, "target_id": open_id, "user_type": 2 }));
		
	    $("#btnSendMsg").click(function() {
	    	sendMessage();
		});

	    $('#msg_box').keypress(function(event){  
	        var keycode = (event.keyCode ? event.keyCode : event.which);  
	        if(keycode == '13'){  
	        	sendMessage();    
	        }  
	    });
	});
})

function sendMessage() {
	socket.emit('send-message', JSON.stringify({ 
    	"user_id": broker_id, 
    	"target_id": $("#selectedUser").val(), 
    	"user_type": 2, 
    	"message": $("#msg_box").val() 
    }));
	$("#msg_box").val("");
}

function getMessageText(data) {
	var html = "";
	if(data.user_type == 1) {
		html += '<div class="dialogue-chat-div dialogue-chat-div-female dialogue-chat-div-customer">';
	} else {
		html += '<div class="dialogue-chat-div dialogue-chat-div-male dialogue-chat-div-manage">';
	}
	html += '<div class="dialogue-chat-head"></div>';
	html += '<div class="dialogue-chat-pop"><p>' + data.message + '</p></div>';
	html += '</div>';
	return html
}

function play_ring(url){
	var embed = '<embed id="ring" src="'+url+'" loop="0" autostart="true" hidden="true" style="height:0px; width:0px;0px;"></embed>';
	$("#ring").html(embed);
}

function list_house_tracks(open_id) {
	$.get('/manage/list_house_tracks/'+open_id, function(data) {
		var data = JSON.parse(data);
		var html = "";
		for(var i in data) {
			var h = data[i];
			var f_text = "";
			if(null != h.feature) {
				var features = h.feature.split(',');
				for(var i in features) {
					f_text += "<i>";
					f_text += features[i];
					f_text += "</i>";
				}
			}
			html += '<a href="../house/second_hand_detail/' + h.id + '" target="_blank">'
			html += ' <div class="dialogue-history-list">';
			html += '  <div class="clearfix">';
			html += '   <span class="dialogue-s-img"><img src="/uploadfiles/pics/' + h.bg_pic + '" alt="" width="70" height="50" /></span>';
			html += '   <p><span class="s01">' + h.xq_name + '</span>';
			html += '   <span class="s02">' + h.acreage + '㎡ | ' + h.room + '房 | ' + h.acreage + '万</span>';
			html += '   <span class="s03">' + h.region_name + '</span></p>';
			html += '  </div>';
			html += '  <span class="dialogue-s-label">' + f_text + '</span>';
			html += ' </div>';
			html += '</a>';
		}
    	$("#dialogue-right-body").html(html);
    });
}

function gray(imgObj) {
	var canvas = document.createElement('canvas');
	var canvasContext = canvas.getContext('2d');

	var imgW = imgObj.width;
	var imgH = imgObj.height;
	canvas.width = imgW;
	canvas.height = imgH;

	canvasContext.drawImage(imgObj, 0, 0);
	var imgPixels = canvasContext.getImageData(0, 0, imgW, imgH);

	for (var y = 0; y < imgPixels.height; y++) {
		for (var x = 0; x < imgPixels.width; x++) {
			var i = (y * 4) * imgPixels.width + x * 4;
          	var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
          	imgPixels.data[i] = avg;
          	imgPixels.data[i + 1] = avg;
          	imgPixels.data[i + 2] = avg;
		}
	}
    canvasContext.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
    return canvas.toDataURL();
}
</script>
<div id="ring" style="width:0px; height:0px;"></div>
<input type="hidden" id="selectedUser" value="" />
</body>

