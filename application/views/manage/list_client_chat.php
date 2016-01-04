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
			                <li id="<?php echo $row['open_id']; ?>">
			                  <span class="dialogue-cus-head dialogue-cus-head-female">
			                    <img src="<?php echo $row['headimgurl']; ?>" alt="" id="<?php echo $row['open_id']; ?>" style="height: 36px;width:36px;"/>
			                  	<i class="dialogue-message-number-i" id="number_<?php echo $row['open_id']; ?>"></i>
			                  </span>
			                  <span class="online-state leave-state" id="status_<?php echo $row['open_id']; ?>">离线</span>
			                  <span class="dialogue-cus-txt">
			                  	<i class="dialogue-cus-name"> 昵称：<?php echo $row['nickname']; ?></i>
			                  	<br /> 性别：<?php echo @$sex[$row['sex']]; ?>
			                  	<input type="hidden" id="status_flag_<?php echo $row['open_id']; ?>" value="0" />
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
              		<img src="/chat/images/touxiang2.jpg" alt="" width="36" height="36" />
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
		$('#audio_tag').trigger('play');

		if(open_id == "" || open_id != user_id) {
			var count = data.count
			if(count > 0) {
				var html = '<em class="dialogue-message-number">' + count + '</em>';
				$("#number_" + user_id).html(html);
			}
		}
	} else {
		var status = $("#status_flag_" + target_id).val();
		if(status < 1) {
			$.get('/b_house/send_notification/' + target_id + '/' + broker_id, function() { /*  */ });
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
		$("#status_" + user_id).text("在线");
		$("#status_" + user_id).removeClass('leave-state');
		$("#status_flag_" + user_id).val(1);
	} else {
		$("#status_" + user_id).text("离线");
		$("#status_" + user_id).addClass('leave-state');
		$("#status_flag_" + user_id).val(0);
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
	socket.emit('online', JSON.stringify({ "user_id": broker_id, "user_type": 2 }));
	
/////////////////////////////////////////////////////////////////////////
	$("#cus-list li").click(function(){
		var open_id = $("#selectedUser").val();
		if(open_id != "") {
			socket.emit('zero-out', JSON.stringify({ "user_id": open_id, "target_id": broker_id }));
		}
		
	    $("#cus-list li").removeClass('current');
	    $(this).addClass('current');
	    $("#dialogue-center-name").html($(this).children().find(".dialogue-cus-name").html());

	    var open_id = $(this).attr('id');
	    $("#number_" + open_id).html("");
	    list_house_tracks(open_id);
	    
		$("#selectedUser").val(open_id);

		socket.emit('online', JSON.stringify({ "user_id": broker_id, "target_id": open_id, "user_type": 2, "reset_flag": 1 }));
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
	html += '<div class="dialogue-chat-head"><img src="/chat/images/touxiang2.jpg" alt="" width="36" height="36" /></div>';
	html += '<div class="dialogue-chat-pop"><p>' + data.message + '</p></div>';
	html += '</div>';
	return html
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
</script>
<input type="hidden" id="selectedUser" value="" />
<audio id="audio_tag"><source src="/chat/ring/msg.wav" type="audio/x-wav" /></audio>
</body>

