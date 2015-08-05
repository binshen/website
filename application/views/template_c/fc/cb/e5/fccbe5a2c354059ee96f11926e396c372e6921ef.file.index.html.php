<?php /* Smarty version Smarty-3.1.16, created on 2015-08-05 09:08:01
         compiled from "application\views\index.html" */ ?>
<?php /*%%SmartyHeaderCode:1960755b6e9761cf065-27303114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fccbe5a2c354059ee96f11926e396c372e6921ef' => 
    array (
      0 => 'application\\views\\index.html',
      1 => 1438669495,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1960755b6e9761cf065-27303114',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55b6e9763ac4d7_80478668',
  'variables' => 
  array (
    'base_url' => 0,
    'style_list_1' => 0,
    'item' => 0,
    'style_list_2' => 0,
    'style_list_3' => 0,
    'style_list_4' => 0,
    'style_list_5' => 0,
    'style_list_6' => 0,
    'style_list_7' => 0,
    'news1' => 0,
    'row' => 0,
    'news2' => 0,
    'k' => 0,
    'news3' => 0,
    'news5' => 0,
    'news4' => 0,
    'member_username' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b6e9763ac4d7_80478668')) {function content_55b6e9763ac4d7_80478668($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include 'C:\\Users\\bin.shen\\git\\website\\application\\libraries\\smarty\\plugins\\function.site_url.php';
?><!doctype html>
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
<link href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
js/layer/skin/layer.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
js/layer/layer.js"></script>
</head>
<body>
<div class="wraper">
   <?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

   
    <!--------------头部导航start---------------->
<?php echo $_smarty_tpl->getSubTemplate ("header_login.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!--------------头部导航end---------------->
    <!--------------首页主体内容start---------------->
    <div class="main clearfix">
    	<div class="index-nav">
        	<ul class="ul-menu">
                <li>
                    <div class="category-menu-tit"><i class="i-menu-icon i-buy"></i><i class="i-menu" style="letter-spacing:0px">买新房</i></div>
                 </li>
                <li>
                    <div class="category-menu-tit"><i class="i-menu-icon i-sell"></i><i class="i-menu" style="letter-spacing:0px">买二手房</i></div>
                </li>
                <li>
                    <div class="category-menu-tit"><i class="i-menu-icon i-lease"></i><i class="i-menu">卖房</i></div>
                </li>
                <li class="last">
                    <div class="category-menu-tit"><i class="i-menu-icon i-renting"></i><i class="i-menu">租房</i></div>
                </li>
            </ul>
            <!----------------买房------------------->
			<div class="category-menu-content">
				<div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
<a href="javascript:void(0);" onclick="redirect(1,1,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
');" target="_self" style="letter-spacing:1px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
</a><?php ob_start();?><?php } ?><?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>

                    </p>
                    <p class="menu-link menu-link-two">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
<a href="javascript:void(0);" onclick="redirect(1,1,2,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
</a><?php ob_start();?><?php } ?><?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
</p>
                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_3']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
<a href="javascript:void(0);" onclick="redirect(1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
</a><?php ob_start();?><?php } ?><?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>

                    </p>
                </div>
            	<div class="category-menu-line clearfix">
                	<span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_4']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
<a href="javascript:void(0);" onclick="redirect(1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
</a><?php ob_start();?><?php } ?><?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_5']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
<a href="javascript:void(0);" onclick="redirect(1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>
</a><?php ob_start();?><?php } ?><?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_6']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>
<a href="javascript:void(0);" onclick="redirect(1,12,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>
</a><?php ob_start();?><?php } ?><?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">厂房</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_7']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp30=ob_get_clean();?><?php echo $_tmp30;?>
<a href="javascript:void(0);" onclick="redirect(1,13,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp31=ob_get_clean();?><?php echo $_tmp31;?>
');" target="_self" style="letter-spacing:1px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp32=ob_get_clean();?><?php echo $_tmp32;?>
</a><?php ob_start();?><?php } ?><?php $_tmp33=ob_get_clean();?><?php echo $_tmp33;?>

                    </p>
                </div>
			</div>
            <!----------------卖房------------------->
             <div class="category-menu-content">
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp34=ob_get_clean();?><?php echo $_tmp34;?>
<a href="javascript:void(0);" onclick="redirect(2,1,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp35=ob_get_clean();?><?php echo $_tmp35;?>
');" target="_self" style="letter-spacing:1px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp36=ob_get_clean();?><?php echo $_tmp36;?>
</a><?php ob_start();?><?php } ?><?php $_tmp37=ob_get_clean();?><?php echo $_tmp37;?>

                    </p>
                    <p class="menu-link menu-link-two">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp38=ob_get_clean();?><?php echo $_tmp38;?>
<a href="javascript:void(0);" onclick="redirect(2,1,2,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp39=ob_get_clean();?><?php echo $_tmp39;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp40=ob_get_clean();?><?php echo $_tmp40;?>
</a><?php ob_start();?><?php } ?><?php $_tmp41=ob_get_clean();?><?php echo $_tmp41;?>
</p>
                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_3']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp42=ob_get_clean();?><?php echo $_tmp42;?>
<a href="javascript:void(0);" onclick="redirect(2,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp43=ob_get_clean();?><?php echo $_tmp43;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp44=ob_get_clean();?><?php echo $_tmp44;?>
</a><?php ob_start();?><?php } ?><?php $_tmp45=ob_get_clean();?><?php echo $_tmp45;?>

                    </p>
                </div>
            	<div class="category-menu-line clearfix">
                	<span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_4']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp46=ob_get_clean();?><?php echo $_tmp46;?>
<a href="javascript:void(0);" onclick="redirect(2,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp47=ob_get_clean();?><?php echo $_tmp47;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp48=ob_get_clean();?><?php echo $_tmp48;?>
</a><?php ob_start();?><?php } ?><?php $_tmp49=ob_get_clean();?><?php echo $_tmp49;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_5']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp50=ob_get_clean();?><?php echo $_tmp50;?>
<a href="javascript:void(0);" onclick="redirect(2,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp51=ob_get_clean();?><?php echo $_tmp51;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp52=ob_get_clean();?><?php echo $_tmp52;?>
</a><?php ob_start();?><?php } ?><?php $_tmp53=ob_get_clean();?><?php echo $_tmp53;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_6']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp54=ob_get_clean();?><?php echo $_tmp54;?>
<a href="javascript:void(0);" onclick="redirect(2,12,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp55=ob_get_clean();?><?php echo $_tmp55;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp56=ob_get_clean();?><?php echo $_tmp56;?>
</a><?php ob_start();?><?php } ?><?php $_tmp57=ob_get_clean();?><?php echo $_tmp57;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">厂房</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_7']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp58=ob_get_clean();?><?php echo $_tmp58;?>
<a href="javascript:void(0);" onclick="redirect(2,13,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp59=ob_get_clean();?><?php echo $_tmp59;?>
');" target="_self" style="letter-spacing:1px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp60=ob_get_clean();?><?php echo $_tmp60;?>
</a><?php ob_start();?><?php } ?><?php $_tmp61=ob_get_clean();?><?php echo $_tmp61;?>

                    </p>
                </div>
            </div>
            <!----------------卖房------------------>
             <div class="category-menu-content">
                <dl class="category-menu-dl">
                    <dt>1</dt>
                    <dd><span>在房猫发房</span><br />简单2步即可完成发布，方便快捷免费！</dd>
                    <dt>2</dt>
                    <dd><span>优质经纪人全程服务</span><br />简单2步即可完成发布，方便快捷免费！</dd>
                    <dt>3</dt>
                    <dd><span>大量买家</span><br />简单2步即可完成发布，方便快捷免费！</dd>
                </dl>
                <a href="javascript:void(0);" class="publish-btn" id="btnPublish"><em></em>免费发布房源</a>
            </div>
             <!----------------租房------------------->
             <div class="category-menu-content">
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">住宅</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp62=ob_get_clean();?><?php echo $_tmp62;?>
<a href="javascript:void(0);" onclick="redirect(3,1,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp63=ob_get_clean();?><?php echo $_tmp63;?>
');" target="_self" style="letter-spacing:1px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp64=ob_get_clean();?><?php echo $_tmp64;?>
</a><?php ob_start();?><?php } ?><?php $_tmp65=ob_get_clean();?><?php echo $_tmp65;?>

                    </p>
                    <p class="menu-link menu-link-two">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp66=ob_get_clean();?><?php echo $_tmp66;?>
<a href="javascript:void(0);" onclick="redirect(3,1,2,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp67=ob_get_clean();?><?php echo $_tmp67;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp68=ob_get_clean();?><?php echo $_tmp68;?>
</a><?php ob_start();?><?php } ?><?php $_tmp69=ob_get_clean();?><?php echo $_tmp69;?>
</p>
                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">公寓</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_3']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp70=ob_get_clean();?><?php echo $_tmp70;?>
<a href="javascript:void(0);" onclick="redirect(3,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp71=ob_get_clean();?><?php echo $_tmp71;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp72=ob_get_clean();?><?php echo $_tmp72;?>
</a><?php ob_start();?><?php } ?><?php $_tmp73=ob_get_clean();?><?php echo $_tmp73;?>

                    </p>
                </div>
            	<div class="category-menu-line clearfix">
                	<span class="category-menu-line-tit">别墅</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_4']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp74=ob_get_clean();?><?php echo $_tmp74;?>
<a href="javascript:void(0);" onclick="redirect(3,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp75=ob_get_clean();?><?php echo $_tmp75;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp76=ob_get_clean();?><?php echo $_tmp76;?>
</a><?php ob_start();?><?php } ?><?php $_tmp77=ob_get_clean();?><?php echo $_tmp77;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">写字楼</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_5']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp78=ob_get_clean();?><?php echo $_tmp78;?>
<a href="javascript:void(0);" onclick="redirect(3,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp79=ob_get_clean();?><?php echo $_tmp79;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp80=ob_get_clean();?><?php echo $_tmp80;?>
</a><?php ob_start();?><?php } ?><?php $_tmp81=ob_get_clean();?><?php echo $_tmp81;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">商铺</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_6']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp82=ob_get_clean();?><?php echo $_tmp82;?>
<a href="javascript:void(0);" onclick="redirect(3,12,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp83=ob_get_clean();?><?php echo $_tmp83;?>
');" target="_self"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp84=ob_get_clean();?><?php echo $_tmp84;?>
</a><?php ob_start();?><?php } ?><?php $_tmp85=ob_get_clean();?><?php echo $_tmp85;?>

                    </p>
                </div>
                <div class="category-menu-line clearfix">
                    <span class="category-menu-line-tit">厂房</span>
                    <p class="menu-link">
                    	<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['style_list_7']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_tmp86=ob_get_clean();?><?php echo $_tmp86;?>
<a href="javascript:void(0);" onclick="redirect(3,13,1,'<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp87=ob_get_clean();?><?php echo $_tmp87;?>
');" target="_self" style="letter-spacing:1px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp88=ob_get_clean();?><?php echo $_tmp88;?>
</a><?php ob_start();?><?php } ?><?php $_tmp89=ob_get_clean();?><?php echo $_tmp89;?>

                    </p>
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
?><?php $_tmp90=ob_get_clean();?><?php echo $_tmp90;?>

                         <li><a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp91=ob_get_clean();?><?php echo $_tmp91;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['xq_id'];?>
<?php $_tmp92=ob_get_clean();?><?php echo $_tmp92;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp93=ob_get_clean();?><?php echo $_tmp93;?>
/1" target="_blank"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp94=ob_get_clean();?><?php echo $_tmp94;?>
" width="515" height="280" /></a></li>
                         <?php ob_start();?><?php } ?><?php $_tmp95=ob_get_clean();?><?php echo $_tmp95;?>

                         </ul>
                    </div>
                     <div class="control" id ="slide01_control">
                     	 <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['news1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp96=ob_get_clean();?><?php echo $_tmp96;?>

                         <i class="toc"></i>
                         <?php ob_start();?><?php } ?><?php $_tmp97=ob_get_clean();?><?php echo $_tmp97;?>

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
?><?php $_tmp98=ob_get_clean();?><?php echo $_tmp98;?>

	                         	<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['k']->value==0||$_smarty_tpl->tpl_vars['k']->value==4||$_smarty_tpl->tpl_vars['k']->value==8) {?><?php $_tmp99=ob_get_clean();?><?php echo $_tmp99;?>

	                         	<li>
	                         	<a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp100=ob_get_clean();?><?php echo $_tmp100;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['xq_id'];?>
<?php $_tmp101=ob_get_clean();?><?php echo $_tmp101;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp102=ob_get_clean();?><?php echo $_tmp102;?>
/1" target="_blank" class="aPic aPicW128"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp103=ob_get_clean();?><?php echo $_tmp103;?>
" width="128" height="195" /><i class="iTit"><em class="fz14"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
<?php $_tmp104=ob_get_clean();?><?php echo $_tmp104;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title2'];?>
<?php $_tmp105=ob_get_clean();?><?php echo $_tmp105;?>
</i></a>
                         	    <?php ob_start();?><?php } elseif ($_smarty_tpl->tpl_vars['k']->value==3||$_smarty_tpl->tpl_vars['k']->value==7||$_smarty_tpl->tpl_vars['k']->value==11) {?><?php $_tmp106=ob_get_clean();?><?php echo $_tmp106;?>

                         	    <a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp107=ob_get_clean();?><?php echo $_tmp107;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['xq_id'];?>
<?php $_tmp108=ob_get_clean();?><?php echo $_tmp108;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp109=ob_get_clean();?><?php echo $_tmp109;?>
/1" target="_blank" class="aPic aPicW128"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp110=ob_get_clean();?><?php echo $_tmp110;?>
" width="128" height="195" /><i class="iTit"><em class="fz14"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
<?php $_tmp111=ob_get_clean();?><?php echo $_tmp111;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title2'];?>
<?php $_tmp112=ob_get_clean();?><?php echo $_tmp112;?>
</i></a>
                         	    </li>
                         	    <?php ob_start();?><?php } else { ?><?php $_tmp113=ob_get_clean();?><?php echo $_tmp113;?>

                         	    <a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp114=ob_get_clean();?><?php echo $_tmp114;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['xq_id'];?>
<?php $_tmp115=ob_get_clean();?><?php echo $_tmp115;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp116=ob_get_clean();?><?php echo $_tmp116;?>
/1" target="_blank" class="aPic aPicW128"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
<?php $_tmp117=ob_get_clean();?><?php echo $_tmp117;?>
" width="128" height="195" /><i class="iTit"><em class="fz14"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
<?php $_tmp118=ob_get_clean();?><?php echo $_tmp118;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['title2'];?>
<?php $_tmp119=ob_get_clean();?><?php echo $_tmp119;?>
</i></a>
                         	    <?php ob_start();?><?php }?><?php $_tmp120=ob_get_clean();?><?php echo $_tmp120;?>

                                
                            <?php ob_start();?><?php } ?><?php $_tmp121=ob_get_clean();?><?php echo $_tmp121;?>

                           </ul>
                        </div>
                    </div>
                </div>
             </div>  
             <div class="newsPic">
             	<div class="newPic-top clearfix">
             		<a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp122=ob_get_clean();?><?php echo $_tmp122;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['xq_id'];?>
<?php $_tmp123=ob_get_clean();?><?php echo $_tmp123;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['id'];?>
<?php $_tmp124=ob_get_clean();?><?php echo $_tmp124;?>
/1" target="_blank" class="aWid170"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news3']->value['pic'];?>
<?php $_tmp125=ob_get_clean();?><?php echo $_tmp125;?>
" width="170" height="280" /></a>
                    <div class="hotGuide">
                        <div class="guideTxt">
                            <span class="guide-tit"><a href="" target="_blank">《昆山楼市》杂志6-7刊抢先看&gt;</a></span>
                            <p class="guide-link"><a href="" target="_blank">市场行情</a><a href="" target="_blank">特别策划</a><a href="" target="_blank">名盘鉴赏</a><br /><a href="" target="_blank">楼市前线</a><a href="" target="_blank">楼相百态</a><a href="" target="_blank">独家调查</a></p>
                        </div>
                    	<a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp126=ob_get_clean();?><?php echo $_tmp126;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[0]['xq_id'];?>
<?php $_tmp127=ob_get_clean();?><?php echo $_tmp127;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[0]['id'];?>
<?php $_tmp128=ob_get_clean();?><?php echo $_tmp128;?>
/1" target="_blank" class="aPic aPicW270"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[0]['pic'];?>
<?php $_tmp129=ob_get_clean();?><?php echo $_tmp129;?>
" width="270" height="190" /><i class="iTit"><em class="fz20"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[0]['title'];?>
<?php $_tmp130=ob_get_clean();?><?php echo $_tmp130;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[0]['title2'];?>
<?php $_tmp131=ob_get_clean();?><?php echo $_tmp131;?>
</i></a>
                    </div>
                </div>
                <div class="newPic-btm clearfix">
                	<a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp132=ob_get_clean();?><?php echo $_tmp132;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news4']->value['xq_id'];?>
<?php $_tmp133=ob_get_clean();?><?php echo $_tmp133;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news4']->value['id'];?>
<?php $_tmp134=ob_get_clean();?><?php echo $_tmp134;?>
/1" target="_blank" class="aWid170"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news4']->value['pic'];?>
<?php $_tmp135=ob_get_clean();?><?php echo $_tmp135;?>
" width="170" height="195" /></a>
                    <a href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'house/article_detail'),$_smarty_tpl);?>
<?php $_tmp136=ob_get_clean();?><?php echo $_tmp136;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[1]['xq_id'];?>
<?php $_tmp137=ob_get_clean();?><?php echo $_tmp137;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[1]['id'];?>
<?php $_tmp138=ob_get_clean();?><?php echo $_tmp138;?>
/1" target="_blank" class="aPic aPicW270"><img src="/uploadfiles/news/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[1]['pic'];?>
<?php $_tmp139=ob_get_clean();?><?php echo $_tmp139;?>
" width="270" height="195" />
                    <i class="iTit"><em class="fz20"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[1]['title'];?>
<?php $_tmp140=ob_get_clean();?><?php echo $_tmp140;?>
</em><br /><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['news5']->value[1]['title2'];?>
<?php $_tmp141=ob_get_clean();?><?php echo $_tmp141;?>
</i></a>
                </div>
             </div>      
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


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
   	
   	$("#btnPublish").click(function() {
   		<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['member_username']->value) {?><?php $_tmp142=ob_get_clean();?><?php echo $_tmp142;?>

   			document.location="/house/publish";
        <?php ob_start();?><?php } else { ?><?php $_tmp143=ob_get_clean();?><?php echo $_tmp143;?>

        	layer.alert("发布房源请先登录！");
        <?php }?>
   	});
});

function redirect(t, s, k, v) {
	$("#search_text").val("");
	$("#search_region").val("");
	$("#search_type").val("");
	$("#search_acreage").val("");
	$("#search_style").val(s);
	if(s == 1) {
		if(k == 1) {
			$("#search_region").val(v);
		} else {
			$("#search_type").val(v);
		}
	} else if(s == 12) {
		$("#search_acreage").val(v);
	} else if(k == 13) {
		$("#search_region").val(v);
	}
	if(t == 1) {
		$("#searchHouseForm").attr('action', '/house/new_house_list');
	} else if(t == 2) {
		$("#searchHouseForm").attr('action', '/house/second_hand_list');
	} else {
		$("#searchHouseForm").attr('action', '/house/rent_house_list');
	}
	$("#searchHouseForm").submit();
}
</script>
</body>
</html>
<?php }} ?>
