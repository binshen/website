<link rel="stylesheet" href="/chat/css/dialogue-backer.css">
<body>
  <div class="main">
       <div class="dialogue-left">
          <div class="dialogue-left-body">
            <ul class="cus-list" id="cus-list">
            	<?php 
            		if (!empty($wx_users_list)):
            			$sex = array('1' => '男', '2' => '女');
            			foreach ($wx_users_list as $i => $row):
            	?>
			                <li>
			                  <span class="cus-head cus-head-female">
			                    <img src="<?php echo $row['headimgurl']; ?>" alt="" <?php if($i=0) {?>class="imgToGray"<?php } ?> style="height: 36px;width:36px;"/>
			                  </span>
			                  <span class="cus-txt"><i class="cus-name"> 姓名：<?php echo $row['nickname']; ?></i><br /> 性别：<?php echo @$sex[$row['sex']]; ?><input type="hidden" class="cus-open-id" value="<?php echo $row['open_id']; ?>" /></span>
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
          <div class="dialogue-center-name" id="dialogue-center-name">周小惠</div>
          <div class="dialogue-center-chat" id="dialogue-center-chat">
          	<!--
          	<div class="chat-div chat-div-female chat-div-customer">
               <div class="chat-head"></div>
               <div class="chat-pop"><p>你好，请问有什么问题</p></div>
            </div>
            <div class="chat-div chat-div-male chat-div-manage">
               <div class="chat-head"></div>
               <div class="chat-pop"><p>你好，请问有什么问题</p></div>
            </div>
            -->
          </div>
          <div class="dialogue-center-input">
              <div class="chat-txt-input">
                  <input type="text" id="msg_box" value="" class="input-txt" />
                  <a href="javascript:void(0)" class="set-btn" id="btnSendMsg">发送</a>
              </div>
              <div class="chat-input-head">
              </div>
          </div>
       </div>
       <div class="dialogue-right">
          	<div class="dialogue-right-tit">浏览记录</div>
          	<div class="dialogue-right-body" id="dialogue-right-body">
          	</div>
       </div>
  </div>
<script src="/chat/js/single-iScroll.js" charset="gbk"></script>
<script src="/chat/js/jquery-ui.min.js" charset="gbk"></script>
<script type="text/javascript" src="http://121.40.97.183:4000/socket.io/socket.io.js"></script>
<script>
$(function(){
    var windowHei = $(window).height();
    var leftPx = parseInt(windowHei-120)+'px';
    var centerPx = parseInt(windowHei-155-120)+'px';
    var rightPx = parseInt(windowHei-180)+'px';
    $('#dialogue-center-chat').height(centerPx);
    $('#cus-list').height(leftPx);
    $('#tool').height(leftPx);
    $('#dialogue-right-body').height(rightPx);
   	iScroll.init({
   		el: document.getElementById('cus-list'),
   		scrollBar: document.getElementById('tool-bar')
    })
})

//gray
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
for(var i; i<$('.imgToGray').length;i++){
	$('.imgToGray')[i].src = gray($('.imgToGray')[i]);
}
//

$("#cus-list li").click(function(){
    $("#cus-list li").removeClass('current');
    $(this).addClass('current');
    $("#dialogue-center-name").html($(this).children().find(".cus-name").html());

    var open_id = $(this).children().find(".cus-open-id").val();
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
			html += ' <div class="history-list">';
			html += '  <div class="clearfix">';
			html += '   <span class="s-img"><img src="/uploadfiles/pics/' + h.bg_pic + '" alt="" width="70" height="50" /></span>';
			html += '   <p><span class="s01">' + h.xq_name + '</span>';
			html += '   <span class="s02">' + h.acreage + '㎡ | ' + h.room + '房 | ' + h.acreage + '万</span>';
			html += '   <span class="s03">' + h.region_name + '</span></p>';
			html += '  </div>';
			html += '  <span class="s-label">' + f_text + '</span>';
			html += ' </div>';
			html += '</a>';
		}
    	$("#dialogue-right-body").html(html);
    });

    var broker_id = '<?php echo $this->session->userdata('user_id'); ?>';
    var socket = io.connect('http://121.40.97.183:4000');
    socket.emit('online', JSON.stringify({ "user_id": broker_id, "user_type": 2 }));
    socket.emit('show-history', JSON.stringify({ "user_id": broker_id, "target_id": open_id, "user_type": 2 }));
    socket.on('disconnect',function(){
		console.log('disconnected')
	});
	
	socket.on('reconnect',function(){
		console.log('reconnected')
	});

	socket.on('receive-message', function (data) {
		var html = "";
		var m = JSON.parse(data);
		if(m.user_type == 1) {
			html += '<div class="chat-div chat-div-female chat-div-customer">';
		} else {
			html += '<div class="chat-div chat-div-male chat-div-manage">';
		}
		html += '<div class="chat-head"></div>';
		html += '<div class="chat-pop"><p>' + m.message + '</p></div>';
		html += '</div>';
		$("#dialogue-center-chat").append(html);

		play_ring("/chat/ring/msg.wav")
	});
	
    socket.on('receive-history', function (data) {
    	var messages = JSON.parse(data);
    	var messages = messages.reverse();
    	var html = "";
    	for(var i in messages) {
			var m = JSON.parse(messages[i]);
			if(m.user_type == 1) {
				html += '<div class="chat-div chat-div-female chat-div-customer">';
			} else {
				html += '<div class="chat-div chat-div-male chat-div-manage">';
			}
			html += '<div class="chat-head"></div>';
			html += '<div class="chat-pop"><p>' + m.message + '</p></div>';
			html += '</div>';
    	}
    	$("#dialogue-center-chat").html(html);
	});

    $("#btnSendMsg").click(function() {
        alert("123");
    	socket.emit('send-message', JSON.stringify({ "user_id": broker_id, "target_id": open_id, "user_type": 2, "message": $("#msg_box").val() }));
	});
})

function play_ring(url){
	var embed = '<embed id="ring" src="'+url+'" loop="0" autostart="true" hidden="true" style="height:0px; width:0px;0px;"></embed>';
	$("#ring").html(embed);
}
</script>
</body>