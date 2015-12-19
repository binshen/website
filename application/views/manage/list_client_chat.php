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
			                  <span class="cus-txt"><i class="cus-name"> 姓名：<?php echo $row['nickname']; ?></i><br /> 性别：<?php echo @$sex[$row['sex']]; ?></span>
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
            <div class="chat-div chat-div-female chat-div-customer">
              <div class="chat-head"></div>
                <div class="chat-pop">
                  <p>你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？</p>
                 </div>

            </div>
            <div class="chat-div chat-div-female chat-div-customer">
               <div class="chat-head">
                </div>
                <div class="chat-pop">
                  <p>你好，大德世家 ，长江花园你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？</p>
                </div>

            </div>
            <div class="chat-div chat-div-male chat-div-manage">
               <div class="chat-head">
               </div>
                <div class="chat-pop">
                  <p>你好，请问有什么问题你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？你好，请问城北有哪些好的学区房推荐？</p>
               </div>

            </div>
            <div class="chat-div chat-div-female chat-div-customer">
               <div class="chat-head">
                </div>
                <div class="chat-pop">
                  <p>你好，请问有什么问题</p>
                </div>
            </div>
             <div class="chat-div chat-div-male chat-div-manage">
              <div class="chat-head">
                             </div>
                <div class="chat-pop">
                  <p>你好，请问有什么问题</p>
               </div>

            </div>
            <div class="chat-div chat-div-female chat-div-customer">
               <div class="chat-head">
                </div>
                <div class="chat-pop">
                  <p>你好，请问有什么问题</p>
                </div>
            </div>
           <div class="chat-div chat-div-male chat-div-manage">
               <div class="chat-head">
                                </div>
                 <div class="chat-pop">
                   <p>你好，请问有什么问题</p>
                </div>
             </div>
             <div class="chat-div chat-div-female chat-div-customer">
                <div class="chat-head">
                 </div>
                 <div class="chat-pop">
                   <p>你好，请问有什么问题</p>
                 </div>
             </div>
              <div class="chat-div chat-div-male chat-div-manage">
              <div class="chat-head">
                               </div>
                 <div class="chat-pop">
                   <p>你好，请问有什么问题</p>
                </div>

             </div>
             <div class="chat-div chat-div-female chat-div-customer">
                <div class="chat-head">
                 </div>
                 <div class="chat-pop">
                   <p>你好，请问有什么问题</p>
                 </div>
             </div>
              <div class="chat-div chat-div-male chat-div-manage">
              <div class="chat-head">
                               </div>
                 <div class="chat-pop">
                   <p>你好，请问有什么问题</p>
                </div>

             </div>
             <div class="chat-div chat-div-female chat-div-customer">
                <div class="chat-head">
                 </div>
                 <div class="chat-pop">
                   <p>你好，请问有什么问题</p>
                 </div>
             </div>
                <div class="chat-div chat-div-male chat-div-manage">
                <div class="chat-head">
                                   </div>
                   <div class="chat-pop">
                     <p>你好，请问有什么问题</p>
                  </div>

               </div>
               <div class="chat-div chat-div-female chat-div-customer">
                  <div class="chat-head">
                   </div>
                   <div class="chat-pop">
                     <p>你好，请问有什么问题</p>
                   </div>
               </div>
               <div class="chat-div chat-div-male chat-div-manage">
                <div class="chat-head">
                                 </div>
                  <div class="chat-pop">
                    <p>你好，请问有什么问题</p>
                 </div>

              </div>
              <div class="chat-div chat-div-female chat-div-customer">
                 <div class="chat-head">
                  </div>
                  <div class="chat-pop">
                    <p>你好，请问有什么问题</p>
                  </div>
              </div>
                 <div class="chat-div chat-div-male chat-div-manage">
                  <div class="chat-head">
                                     </div>
                    <div class="chat-pop">
                      <p>你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题你好，请问有什么问题</p>
                   </div>

                </div>
                <div class="chat-div chat-div-female chat-div-customer">
                   <div class="chat-head">
                    </div>
                    <div class="chat-pop">
                      <p>你好，请问有什么问题</p>
                    </div>
                </div>
          </div>
          <div class="dialogue-center-input">
              <div class="chat-txt-input">
                  <input type="text" value="" class="input-txt" />
                  <a href="javascript:void(0)" class="set-btn">发送</a>
              </div>
              <div class="chat-input-head">
              </div>
          </div>
       </div>
       <div class="dialogue-right">
          <div class="dialogue-right-tit">浏览记录</div>
          <div class="dialogue-right-body" id="dialogue-right-body">
              <div class="history-list">
                <div class="clearfix">
                  <span class="s-img"><img src="http://dummyimage.com/70x50/000/fff" alt="" width="70" height="50" /></span>
                  <p><span class="s01">金城花园</span>
                  <span class="s02">90㎡ | 三房 | 69万</span>
                  <span class="s03">城东</span></p>
                </div>
                  <span class="s-label"><i>学区房</i><i>精装修</i><i>学区房</i><i>学区房</i><i>精装修</i><i>学区房</i></span>
              </div>
               <div class="history-list">
                <div class="clearfix">
                  <span class="s-img"><img src="http://dummyimage.com/70x50/000/fff" alt="" width="70" height="50" /></span>
                  <p><span class="s01">金城花园</span>
                  <span class="s02">90㎡ | 三房 | 69万</span>
                  <span class="s03">城东</span></p>
                </div>
                  <span class="s-label"><i>学区房</i><i>精装修</i><i>学区房</i></span>
              </div>
               <div class="history-list">
                <div class="clearfix">
                  <span class="s-img"><img src="http://dummyimage.com/70x50/000/fff" alt="" width="70" height="50" /></span>
                  <p><span class="s01">金城花园</span>
                  <span class="s02">90㎡ | 三房 | 69万</span>
                  <span class="s03">城东</span></p>
                </div>
                  <span class="s-label"><i>学区房</i><i>精装修</i><i>学区房</i></span>
              </div>
               <div class="history-list">
                <div class="clearfix">
                  <span class="s-img"><img src="http://dummyimage.com/70x50/000/fff" alt="" width="70" height="50" /></span>
                  <p><span class="s01">金城花园</span>
                  <span class="s02">90㎡ | 三房 | 69万</span>
                  <span class="s03">城东</span></p>
                </div>
                  <span class="s-label"><i>学区房</i><i>精装修</i><i>学区房</i></span>
              </div>
               <div class="history-list">
                <div class="clearfix">
                  <span class="s-img"><img src="http://dummyimage.com/70x50/000/fff" alt="" width="70" height="50" /></span>
                  <p><span class="s01">金城花园</span>
                  <span class="s02">90㎡ | 三房 | 69万</span>
                  <span class="s03">城东</span></p>
                </div>
                  <span class="s-label"><i>学区房</i><i>精装修</i><i>学区房</i></span>
              </div>
               <div class="history-list">
                <div class="clearfix">
                  <span class="s-img"><img src="http://dummyimage.com/70x50/000/fff" alt="" width="70" height="50" /></span>
                  <p><span class="s01">金城花园</span>
                  <span class="s02">90㎡ | 三房 | 69万</span>
                  <span class="s03">城东</span></p>
                </div>
                  <span class="s-label"><i>学区房</i><i>精装修</i><i>学区房</i></span>
              </div>
              
          </div>
       </div>
  </div>
<script src="/chat/js/single-iScroll.js" charset="gbk"></script>
<script src="/chat/js/jquery-ui.min.js" charset="gbk"></script>
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
    $("#dialogue-center-name").html( $(this).children().find(".cus-name").html());
   // $("#dialogue-right-body").append();
})
</script>
</body>