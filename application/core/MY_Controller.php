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
     * 获取页码列表
     * 例如<上一页>...56789<下一页>
     * @param int $total 总页数
     * @param int $current 当前页
     * @param int $page_list_size 显示页码个数
     * @return array 显示页码的数组
     **/
    public function get_page_list($total,$current,$page_list_size = '5')
    {
	    $page= array();
		if($total<$page_list_size){
			for($i=1;$i<=$total;$i++){
				$page[]=$i;
			}
		}else{
			if($current <= ceil($page_list_size/2)){
			//当前页小于居中页码，则正常打印
				for($i=1;$i<=$page_list_size;$i++){
					$page[]=$i;
				}
				
			}else if($current > ($total - ceil($page_list_size/2))){
			//最后几页正常打印
				for($i=0;$i<$page_list_size;$i++){
					$page[]=$total-$i;
				}
				$page = array_reverse($page);
			}else{
				for($i=$current-floor($page_list_size/2);$i<=$current+floor($page_list_size/2);$i++){
					$page[]=$i;
				}
			}
		}
		return $page;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */