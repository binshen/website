<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 扩展业务控制器
 *
 * @package		app
 * @subpackage	Libraries
 * @category	controller
 * @author      yaobin<645894453@qq.com>
 *        
 */
class MY_Controller extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct();
        ini_set('date.timezone','Asia/Shanghai');
        $this->cismarty->assign('base_url',base_url());//url路径
        if($this->session->userdata('member_username')){
        	$this->cismarty->assign('member_username',$this->session->userdata('member_username'));
        }else{
        	$this->cismarty->assign('member_username','');
        }
    }
    
	//重载smarty方法assign
	public function assign($key,$val) {  
        $this->cismarty->assign($key,$val);  
    }  
    
	//重载smarty方法display
    public function display($html) {
        $this->cismarty->display($html);  
    }
    
    /**
     * 获取产品菜单的树状结构
     **/
    public function subtree($arr,$id=0,$lev=1)
    {
    	static $subs = array();
    	foreach($arr as $v){
    		if((int)$v['parent_id']==$id){
    		    $v['lev'] = $lev;
    		    $subs[]=$v;
    		    $this->subtree($arr,$v['id'],$lev+1);
    		}
    	}
    	return $subs;
    }
    
    /**
     * 提示信息
     * @param varchar $message 提示信息
     * @param varchar $url 跳转页面，如果为空则后退
     * @param int $type 提示类型，1是自动关闭的提示框，2是错误提示框
     **/
    public function show_message($message,$url=null,$type=1){
    	if($url){
    		$js = "location.href='".$url."';";
    	}else{
    		$js = "history.back();";
    	}
    
    	if($type=='1'){
    		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>".$message."</title>
				<script src='".base_url()."js/jquery.min.js'></script>
				<link rel='stylesheet' href='".base_url()."css/easydialog.css'>
				</head>
				<body>
				<script src='".base_url()."js/easydialog.min.js'></script>
				<script>
				var callFn = function(){
				  ".$js."
				};
				easyDialog.open({
					container : {
						content : '".$message."'
					},
					autoClose : 1200,
					callback : callFn
			
				});
    
				</script>
				</body>
				</html>";
    	}
    	exit;
    }
    

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */