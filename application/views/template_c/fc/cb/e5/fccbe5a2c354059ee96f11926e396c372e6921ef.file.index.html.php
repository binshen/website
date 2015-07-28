<?php /* Smarty version Smarty-3.1.16, created on 2015-07-28 10:31:18
         compiled from "application\views\index.html" */ ?>
<?php /*%%SmartyHeaderCode:1960755b6e9761cf065-27303114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fccbe5a2c354059ee96f11926e396c372e6921ef' => 
    array (
      0 => 'application\\views\\index.html',
      1 => 1437972446,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1960755b6e9761cf065-27303114',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_url' => 0,
    'news1' => 0,
    'row' => 0,
    'news2' => 0,
    'k' => 0,
    'news3' => 0,
    'search_text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55b6e9763ac4d7_80478668',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b6e9763ac4d7_80478668')) {function content_55b6e9763ac4d7_80478668($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>房猫</title>
<meta name="keywords" content="房猫,昆山" />
<meta name="description" content="" />
<link href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
js/jquery-1.8.3.min.js" ></script>
<script type="text/javascript" src="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
js/dpl-jquery.slide.js"></script>
</head>
<body>
<div class="wraper">
   <?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

   
    <!--------------头部导航start---------------->
    <div class="gobal-nav">
    	<span class="nav-search"><em>搜索分类</em><i class="trag2 trag1-gray-t"></i></span>
        <ul class="ul-nav">
        	<li><a href="" class="headline"><em></em>头条</a></li>
            <li><a href="" class="housesource"><em></em>房源</a></li>
            <li><a href="" class="housefav"><em></em>房猫惠购</a></li>
            <li><a href="" class="housemedia"><em></em>自媒体</a></li>
        </ul>
        <div class="user-info">
        	<em class="login-logo"></em>
        	<a href="" target="_blank">登录</a>
            <a href="" target="_blank">注册</a>
        </div>
    </div>
    <!--------------头部导航end---------------->
    <!--------------首页主体内容start---------------->
    <div class="main clearfix">
    	<div class="index-nav">
        	<ul class="ul-menu">
                <li>
                    <div class="category-menu-tit"><i class="i-menu-icon i-buy"></i><i class="i-menu">买房</i></div>
                    
                 </li>
                <li>
                    <div class="category-menu-tit"><i class="i-menu-icon i-sell"></i><i class="i-menu">卖房</i></div>
                     
                </li>
                <li>
                    <div class="category-menu-tit"><i class="i-menu-icon i-lease"></i><i class="i-menu">出租</i></div>
                    
                </li>
                <li class="last">
                    <div class="category-menu-tit"><i class="i-menu-icon i-renting"></i><i class="i-menu">租房</i></div>
                   
                </li>
            </ul>
            <!----------------买房------------------->
			<div class="category-menu-content">
            	<div class="category-menu-line clearfix">
                	<span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link"><a href="" target="_blank">独栋</a><a href="" target="_blank">联排</a><a href="" target="_blank">双拼</a><a href="" target="_blank">叠加</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                    <p class="menu-link menu-link-two"><a href="" target="_blank">一室</a><a href="" target="_blank">二室</a><a href="" target="_blank">三室</a><a href="" target="_blank">四室</a><a href="" target="_blank">五室</a><a href="" target="_blank">五室以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link"><a href="" target="_blank">普通公寓 </a><a href="" target="_blank">商务公寓</a><a href="" target="_blank">双拼</a><a href="" target="_blank">酒店式公寓</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link"><a href="" target="_blank">单纯性</a><a href="" target="_blank">商住型</a><a href="" target="_blank">双拼</a><a href="" target="_blank">综合性</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link"><a href="" target="_blank">30㎡以下</a><a href="" target="_blank">30-90㎡</a><a href="" target="_blank"> 90-180㎡</a><a href="" target="_blank">180㎡以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">厂房</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                </div>
			</div>
            <!----------------卖房------------------->
             <div class="category-menu-content">
                <div class="category-menu-line clearfix">
                    <div class="category-menu-line clearfix">
                        <span class="category-menu-line-tit">厂房</span>
                        <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                    </div>
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                    <p class="menu-link menu-link-two"><a href="" target="_blank">一室</a><a href="" target="_blank">二室</a><a href="" target="_blank">三室</a><a href="" target="_blank">四室</a><a href="" target="_blank">五室</a><a href="" target="_blank">五室以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link"><a href="" target="_blank">独栋</a><a href="" target="_blank">联排</a><a href="" target="_blank">双拼</a><a href="" target="_blank">叠加</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link"><a href="" target="_blank">普通公寓 </a><a href="" target="_blank">商务公寓</a><a href="" target="_blank">双拼</a><a href="" target="_blank">酒店式公寓</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link"><a href="" target="_blank">单纯性</a><a href="" target="_blank">商住型</a><a href="" target="_blank">双拼</a><a href="" target="_blank">综合性</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link"><a href="" target="_blank">30㎡以下</a><a href="" target="_blank">30-90㎡</a><a href="" target="_blank"> 90-180㎡</a><a href="" target="_blank">180㎡以上</a></p>
                </div>
            </div>
            <!----------------出租------------------->
             <div class="category-menu-content">
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link"><a href="" target="_blank">普通公寓 </a><a href="" target="_blank">商务公寓</a><a href="" target="_blank">双拼</a><a href="" target="_blank">酒店式公寓</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                    <p class="menu-link menu-link-two"><a href="" target="_blank">一室</a><a href="" target="_blank">二室</a><a href="" target="_blank">三室</a><a href="" target="_blank">四室</a><a href="" target="_blank">五室</a><a href="" target="_blank">五室以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link"><a href="" target="_blank">独栋</a><a href="" target="_blank">联排</a><a href="" target="_blank">双拼</a><a href="" target="_blank">叠加</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link"><a href="" target="_blank">单纯性</a><a href="" target="_blank">商住型</a><a href="" target="_blank">双拼</a><a href="" target="_blank">综合性</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link"><a href="" target="_blank">30㎡以下</a><a href="" target="_blank">30-90㎡</a><a href="" target="_blank"> 90-180㎡</a><a href="" target="_blank">180㎡以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">厂房</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                </div>
            </div>
             <!----------------租房------------------->
             <div class="category-menu-content">
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link"><a href="" target="_blank">单纯性</a><a href="" target="_blank">商住型</a><a href="" target="_blank">双拼</a><a href="" target="_blank">综合性</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                    <p class="menu-link menu-link-two"><a href="" target="_blank">一室</a><a href="" target="_blank">二室</a><a href="" target="_blank">三室</a><a href="" target="_blank">四室</a><a href="" target="_blank">五室</a><a href="" target="_blank">五室以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link"><a href="" target="_blank">独栋</a><a href="" target="_blank">联排</a><a href="" target="_blank">双拼</a><a href="" target="_blank">叠加</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link"><a href="" target="_blank">普通公寓 </a><a href="" target="_blank">商务公寓</a><a href="" target="_blank">双拼</a><a href="" target="_blank">酒店式公寓</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link"><a href="" target="_blank">30㎡以下</a><a href="" target="_blank">30-90㎡</a><a href="" target="_blank"> 90-180㎡</a><a href="" target="_blank">180㎡以上</a></p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">厂房</span>
                    <p class="menu-link"><a href="" target="_blank">玉山</a><a href="" target="_blank">周市</a><a href="" target="_blank">巴城</a><a href="" target="_blank">张浦</a><a href="" target="_blank">陆家</a><a href="" target="_blank">花桥</a><a href="" target="_blank">千灯</a><a href="" target="_blank">周庄</a><br /><a href="" target="_blank">锦溪</a><a href="" target="_blank">淀山湖</a></p>
                </div>
            </div>
	</div>	
<div class="lay965">
             <div class="focus-news">
                <div class="focusPic focusPic1">
                     <div id="slide01" class="tab">
                        <a href="javascript:void(0)" class="prev" onClick="focusPic1.prev()" ></a>
                        <a href="javascript:void(0)" class="next" onClick="focusPic1.next()"></a> 
                         <ul>
                         <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['news1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>

                         <li><a href="#" target="_blank"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
" width="515" height="280" /></a></li>
                         <?php ob_start();?><?php } ?><?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>

                         </ul>
                    </div>
                     <div class="control" id ="slide01_control">
                     	 <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['news1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>

                         <i class="toc"></i>
                         <?php ob_start();?><?php } ?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>

                     </div>
                </div>
                <div class="focusPic focusPic2">
                     <div id="slide02" class="tab">
                        <a href="javascript:void(0)" class="prev" onClick="focusPic2.prev()" ></a>
                        <a href="javascript:void(0)" class="next" onClick="focusPic2.next()"></a> 
                         <div class="slide">
                         	<ul class="pics">
                         	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['news2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['row']->key;
?><?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>

	                         	<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['k']->value==0||$_smarty_tpl->tpl_vars['k']->value==4||$_smarty_tpl->tpl_vars['k']->value==8) {?><?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>

	                         	<li>
	                         	<a href="#" target="_blank" class="aPic aPicW128"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
" width="128" height="195" /><i class="iTit"><em class="fz14"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title2'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
</i></a>
                         	    <?php ob_start();?><?php } elseif ($_smarty_tpl->tpl_vars['k']->value==3||$_smarty_tpl->tpl_vars['k']->value==7||$_smarty_tpl->tpl_vars['k']->value==11) {?><?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>

                         	    <a href="#" target="_blank" class="aPic aPicW128"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
" width="128" height="195" /><i class="iTit"><em class="fz14"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title2'];?>
<?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>
</i></a>
                         	    </li>
                         	    <?php ob_start();?><?php } else { ?><?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>

                         	    <a href="#" target="_blank" class="aPic aPicW128"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
" width="128" height="195" /><i class="iTit"><em class="fz14"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title2'];?>
<?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>
</i></a>
                         	    <?php ob_start();?><?php }?><?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>

                                
                            <?php ob_start();?><?php } ?><?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>

                           </ul>
                        </div>
                    </div>
                </div>
             </div>  
             <div class="newsPic">
             	<div class="newPic-top clearfix">
             		<a href="" target="_blank" class="aWid170"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['pic'];?>
<?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>
" width="170" height="280" /></a>
                    <div class="hotGuide">
                        <div class="guideTxt">
                            <span class="guide-tit"><a href="" target="_blank">《昆山楼市》杂志6-7刊抢先看&gt;</a></span>
                            <p class="guide-link"><a href="" target="_blank">市场行情</a><a href="" target="_blank">特别策划</a><a href="" target="_blank">名盘鉴赏</a><br /><a href="" target="_blank">楼市前线</a><a href="" target="_blank">楼相百态</a><a href="" target="_blank">独家调查</a></p>
                        </div>
                    	<a href="" target="_blank" class="aPic aPicW270"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['pic'];?>
<?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>
" width="270" height="190" /><i class="iTit"><em class="fz20">街区商铺59万起</em><br />吃货天堂-昆城广场</i></a>
                    </div>
                </div>
                <div class="newPic-btm clearfix">
                	<a href="" target="_blank" class="aWid170"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['pic'];?>
<?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>
" width="170" height="195" /></a>
                    <a href="" target="_blank" class="aPic aPicW270"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['pic'];?>
<?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>
" width="270" height="195" /><i class="iTit"><em class="fz20">街区商铺59万起</em><br />吃货天堂-昆城广场</i></a>
                </div>
             </div>      
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<form action="/house/second_hand_list" method="POST" id="funmall_index_form">
	<input type="hidden" id="search_text" name="search_text" value="<?php ob_start();?><?php echo (($tmp = @$_smarty_tpl->tpl_vars['search_text']->value)===null||$tmp==='' ? '' : $tmp);?>
<?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>
">
</form>
<script>
$(function(){
	//左侧搜索分类
	$('.index-nav li').mouseenter(function(){
		var ind = $(this).index();
		$('.index-nav li').removeClass('current');
		$('.category-menu-content').hide();
		$(this).addClass('current');
		$('.category-menu-content').eq(ind).show();
	})
	$('.index-nav').mouseleave(function(){
		$('.index-nav li').removeClass('current');
		$('.category-menu-content').hide();
	});
	//焦点图切换
	window.focusPic1 = new Slide({
		target: $( '#slide01 li' ),
		control: $( '#slide01_control i' ),
		effect: 'slide',
		stay:3000,
		autoPlay:true
  	});
 	window.focusPic2 = new Slide.scroll({
		target: $( '#slide02 .slide li' ),
		width: 516,
		autoPlay: true
	});
   	$('.focusPic').mouseenter(function(){
	   	$(this).addClass('slide-pic-hover');
   	}).mouseleave(function(){
	   	$('.focusPic').removeClass('slide-pic-hover');
	});
   	
   	$("#btnSearchText").click(function(event) {
		event.preventDefault();
		$("#search_text").val($("#question").val());
		if($(".ks-select-pop").find(".current").text() == "二手房") {
			$("#funmall_index_form").attr('action', '/house/second_hand_list');
		} else {
			$("#funmall_index_form").attr('action', '/house/new_house_list');
		}
		$("#funmall_index_form").submit();
	});
});
</script>
</body>
</html>
<?php }} ?>
