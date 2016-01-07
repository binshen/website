<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 网站后台模型
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Manage_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
    /**
     * 用户登录检查
     * 
     * @return boolean
     */
    public function check_login ($brokerOnly=false)
    {
        $login_id = $this->input->post('username');
        $passwd = $this->input->post('password');
        $this->db->from('admin');
        $this->db->where('username', $login_id);
        $this->db->where('passwd', sha1($passwd));
        if($brokerOnly) {
        	$this->db->where('admin_group <=', '2');
        }
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
        	$res = $rs->row();
        	$user_info['user_id'] = $res->id;
            $user_info['username'] = $this->input->post('username');
            $user_info['group_id'] = $res->admin_group;
            $user_info['rel_name'] = $res->rel_name;
            //$user_info['user_type_id'] = 1;
            $user_info['manager_group'] = $res->manager_group;
            $user_info['company_id'] = $res->company_id;
            $user_info['subsidiary_id'] = $res->subsidiary_id;
            if($brokerOnly) {
            	$user_info['login_broker_id'] = $res->id;
            	$user_info['login_broker_tel'] = $res->tel;
            }
            $this->session->set_userdata($user_info);
            return true;
        } else {
//         	$this->db->from('users');
//         	$this->db->where('username', $login_id);
//         	$this->db->where('password', sha1($passwd));
//         	$rs = $this->db->get();
//         	if ($rs->num_rows() > 0) {
//         		$res = $rs->row();
//         		$user_info['user_id'] = $res->id;
//         		$user_info['username'] = $this->input->post('username');
//         		$user_info['group_id'] = 3;
//         		$user_info['rel_name'] = $res->username;
//         		$user_info['user_type_id'] = 2;
//         		$this->session->set_userdata($user_info);
//         		return true;
//         	}else{
        		return false;
//       	}
        }
    }
    
    /**
     * 修改密码
     * 
     */
    public function change_pwd ()
    {
        $login_id = $this->input->post('username');
        $newpassword = $this->input->post('newpassword');
        
		$rs=$this->db->where('username', $login_id)->update('admin', array('passwd'=>sha1($newpassword))); 
        if ($rs) {
            return 1;
        } else {
            return $rs;
        }
    }
    
    /**
     *
     * ***************************************yaobin*******************************************************************
     */
	public function list_new_house(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house');
		$this->db->where('type_id','1');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS style_name, d.name AS orientation_name, e.name AS decoration_name, f.name AS xiaoqu_name');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_style c', 'a.style_id = c.id', 'left');
		$this->db->join('house_orientation d', 'a.orientation_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.decoration_id = e.id', 'left');
		$this->db->join('xiaoqu f', 'a.xq_id = f.id', 'left');
		$this->db->where('type_id','1');
		if($this->input->post('name')){
			$this->db->like('a.name',$this->input->post('name'));
			$data['name'] = $this->input->post('name');
		}
		
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}    
	
	
    
	
	//ajax删除图片
	public function del_pic($folder,$type_id,$pic,$id){
		//echo $id;die;
		if($id){
			$this->db->where('pic_short',$pic);
			$this->db->delete('house_img');
		}
		@unlink('./././uploadfiles/pics/'.$folder.'/'.$type_id.'/'.$pic);
		@unlink('./././uploadfiles/pics/'.$folder.'/'.$type_id.'/'.str_replace('_thumb', '', $pic));
		$data = array(
				'flag'=>1,
				'pic'=>$pic
		);
		return $data;
	}
	
	public function get_feature(){
		$rs = $this->db->select()->from('feature')->get()->result_array();
		$data = array();
		foreach($rs as $k=>$v){
			$data[$v['type_id']][] = $v['name'];
		}
		return $data;
	}
	
	public function list_xq_dialog(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('xiaoqu');
		if($this->input->post('jianpin'))
			$this->db->like('jianpin',$this->input->post('jianpin'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['jianpin'] = null;
		//list
		$this->db->select();
		$this->db->from('xiaoqu');
		if($this->input->post('jianpin')){
			$this->db->like('jianpin',$this->input->post('jianpin'));
			$data['jianpin'] = $this->input->post('jianpin');
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_new_house(){
		$data = array(
			'name'=>$this->input->post('name'),				
			'xq_id'=>$this->input->post('xq_id'),				
			'discount'=>$this->input->post('discount'),				
			'unit_price'=>$this->input->post('unit_price'),
			'kp_date'=>$this->input->post('kp_date'),
			'jf_date'=>$this->input->post('jf_date'),
			'cq_limit'=>$this->input->post('cq_limit'),
			'bs_area'=>$this->input->post('bs_area'),
			'estate_mng'=>$this->input->post('estate_mng'),
			'estate_price'=>$this->input->post('estate_price'),	
			'sell_addr'=>$this->input->post('sell_addr'),
			'developer'=>$this->input->post('developer'),
			'dev_phono'=>$this->input->post('dev_phono'),
			'estate_type'=>$this->input->post('estate_type'),
			'plot_rate'=>$this->input->post('plot_rate'),
			'greening_rate'=>$this->input->post('greening_rate'),
			'feature'=>implode(',', $this->input->post('feature')),
			'type_id'=>1,
			'folder'=>$this->input->post('folder'),
			'bg_pic'=>$this->input->post('is_bg'),
			'description'=>$this->input->post('description'),
			'region_id'=>$this->input->post('region_id'),
			'style_id'=>$this->input->post('style_id'),
			'zd_area'=>$this->input->post('zd_area'),
			'jz_area'=>$this->input->post('jz_area'),
			'house_design'=>$this->input->post('house_design'),
			'mian_hx'=>$this->input->post('mian_hx'),
			'circle_line'=>$this->input->post('circle_line'),
			'decoration_id'=>$this->input->post('decoration_id'),
			'substyle_id'=>$this->input->post('substyle_id'),
			'recommend'=>$this->input->post('recommend'),
		);
		
		$this->db->trans_start();//--------开始事务
		
		if($this->input->post('id')){//修改
			$this->db->where('id',$this->input->post('id'));
			$this->db->update('house',$data);
			$h_id = $this->input->post('id');
			
			$this->db->where('h_id',$this->input->post('id'));
			$this->db->delete('house_img');
			
			$this->db->where('h_id',$this->input->post('id'));
			$this->db->delete('house_hold');
			
			$this->db->where('h_id',$this->input->post('id'));
			$this->db->delete('price_trend');
		}else{//新增
			$this->db->insert('house',$data);
			$h_id = $this->db->insert_id();
		}
		
		$data_line = array();
		$data_hx = array();
		$data_price = array();
		
		
		for($i=1;$i<=5;$i++){
			if($this->input->post('pic_short'.$i)){
				foreach($this->input->post('pic_short'.$i) as $k=>$v){
					$data_line[] = array(
						'h_id'=>$h_id,
						'type_id'=>$i,
						'pic'=>str_replace('_thumb', '', $v),
						'pic_short'=>$v
					);
				}
			}
		}
		$this->db->insert_batch('house_img', $data_line);
		
		$room = $this->input->post('room');
		$lounge = $this->input->post('lounge');
		$toilet = $this->input->post('toilet');
		$area = $this->input->post('area');
		$month = $this->input->post('month');
		$price = $this->input->post('price');
		$title = $this->input->post('title');
		$orientation_id = $this->input->post('orientation_id');
		
		foreach($this->input->post('pic_short6') as $k=>$v){
			$data_hx[] = array(
					'h_id'=>$h_id,
					'pic'=>str_replace('_thumb', '', $v),
					'pic_short'=>$v,
					'room'=> $room[$k],
					'lounge'=> $lounge[$k],
					'toilet'=> $toilet[$k],
					'area'=> $area[$k],
					'title'=> $title[$k],
					'orientation_id'=> $orientation_id[$k],
			);
		}
		$this->db->insert_batch('house_hold', $data_hx);
		
		foreach($month as $k=>$v){
			$data_price[] = array(
				'h_id'=>$h_id,
				'month'=>$v,
				'price'=>$price[$k],
				'region_id'=>$this->input->post('region_id'),
				'substyle_id'=>$this->input->post('substyle_id'),
			);
		}
		
		$this->db->insert_batch('price_trend', $data_price);
		
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function delete_new_house($id){
		$this->db->where('id',$id);
		$rs = $this->db->delete('house');
		if($rs)
			return 1;
		else
			return -1;
	}
	
	public function get_new_house($id){
		$data = $this->db->select('a.*,b.name xq_name')->from('house a')->join('xiaoqu b','a.xq_id = b.id','left')->where('a.id',$id)->get()->row_array();
		$data['pics'] = $this->db->select()->from('house_img')->where('h_id',$id)->get()->result();
		$data['hx_pics'] = $this->db->select()->from('house_hold')->where('h_id',$id)->get()->result();
		$data['list'] = $this->db->select()->from('price_trend')->where('h_id',$id)->order_by('month','acs')->get()->result();
		return $data;
	}
	
	/**
	 * 分页列出新闻类别
	 */
	public function list_news(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('news');
		if($this->input->post('title'))
			$this->db->like('title',$this->input->post('title'));
		if($this->input->post('type_id'))
			$this->db->where('type_id',$this->input->post('type_id'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['title'] = null;
		//list
		$this->db->select('a.*,b.name xq_name');
		$this->db->from('news a');
		$this->db->join('xiaoqu b','a.xq_id=b.id','left');
		if($this->input->post('title')){
			$this->db->like('title',$this->input->post('title'));
		}
	
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'cdate', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'asc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	/**
	 * 保存新闻
	 */
	public function save_news($data){
		$this->db->trans_start();
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('news', $data);
		}else{//新增
			$data['cdate'] = date('Y-m-d H:i:s',time());
			$this->db->insert('news', $data);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}
	
	/**
	 * 删除新闻类别
	 */
	public function delete_news($id){
		$data = $this->get_news($id);
		$rs = $this->db->delete('news', array('id' => $id));
		if($rs){
			@unlink('./././uploadfiles/news/'.$data['img']);//del old img
			return 1;
		}else{
			return $this->db_error;
		}
	}
	
	/**
	 * 获取新闻详情
	 */
	public function get_news($id){
		$this->db->select('a.*,b.name xq_name')->from('news a')->join('xiaoqu b','a.xq_id=b.id','left')->where('a.id', $id);
		$data = $this->db->get()->row_array();
		return $data;
	}
	
	public function list_share(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('share');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total?$rs_total->num:0;
	
		//list
		$this->db->select('id,name');
		$this->db->from('share');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by('id', 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_share(){
		$this->db->trans_start();
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('share', array('name'=>$this->input->post('name')));
		}else{//新增
			$this->db->insert('share', array('name'=>$this->input->post('name')));
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}
	
	public function delete_share($id){
		$data = $this->get_news($id);
		$rs = $this->db->delete('share', array('id' => $id));
		if($rs){
			return 1;
		}else{
			return $this->db_error;
		}
	}
	
	public function get_share($id){
		$this->db->select()->from('share')->where('id', $id);
		$data = $this->db->get()->row_array();
		
		$data['list'] = $this->db->select('a.*,b.name cname,b.company_id')->from('share_company a')
		->join('subsidiary b','a.cid=b.id')
		->where('a.tid',$id)->get()->result();
		
		return $data;
	}
	
	public function add_share_company($tid,$cid,$pid){
		$data = array(
				'tid'=>$tid,
				'cid'=>$cid,
				'pid'=>$pid
		);
		return $this->db->insert('share_company',$data);
	}
	
	public function del_share_company($tid,$cid,$pid){
		$this->db->where('tid',$tid);
		$this->db->where('cid',$cid);
		return $this->db->delete('share_company');
	}
    


    /**
     *
     * ***************************************shenbin*******************************************************************
     */
	/**
	 * 经纪人管理
	 */
	public function list_broker(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('admin');
		if($this->input->post('rel_name'))
			$this->db->like('rel_name',$this->input->post('rel_name'));
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('company_id', $this->session->userdata('company_id'));
		} else if($this->session->userdata('manager_group') == 2) {
			$this->db->where('company_id', $this->session->userdata('company_id'));
			$this->db->where('subsidiary_id', $this->session->userdata('subsidiary_id'));
		}
		$this->db->where('id >', 1);
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['rel_name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS company_name, d.name AS subsidiary_name');
		$this->db->from('admin a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('company c', 'a.company_id = c.id', 'left');
		$this->db->join('subsidiary d', 'a.subsidiary_id = d.id', 'left');
		if($this->input->post('rel_name')){
			$this->db->like('a.rel_name',$this->input->post('rel_name'));
			$data['rel_name'] = $this->input->post('rel_name');
		}
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('a.company_id', $this->session->userdata('company_id'));
		} else if($this->session->userdata('manager_group') == 2) {
			$this->db->where('a.company_id', $this->session->userdata('company_id'));
			$this->db->where('a.subsidiary_id', $this->session->userdata('subsidiary_id'));
		}
		$this->db->where('a.id >', 1);
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function save_broker() {
		$manager_group = 0;
		if($this->input->post('manager_1')) {
			$manager_group = 1;
		} else if($this->input->post('manager_2')) {
			$manager_group = 2;
		}
		$data = array(
			'username' => $this->input->post('tel'),
			'passwd' => sha1('888888'),
			'tel' => $this->input->post('tel'),
			'company_id' => $this->input->post('company_id'),
			'subsidiary_id' => $this->input->post('subsidiary_id'),
			'rel_name' => $this->input->post('rel_name'),
			'region_id' => $this->input->post('region_id'),
			'house_count' => $this->input->post('house_count'),
			'admin_group' => 2,
			'manager_group' => $manager_group
		);
		
		$res = $this->db->select('house_count,broker_count')->from('subsidiary')->where('id',$this->input->post('subsidiary_id'))->get()->row();
		$house_count = $res->house_count;
		$broker_count = $res->broker_count;
		
		$this->db->select('sum(house_count) house_count')->from('admin')->where('subsidiary_id',$this->input->post('subsidiary_id'));
		if($this->input->post('id'))
			$this->db->where('id !=',$this->input->post('id'));
		$rs = $this->db->get()->row();
		if($rs->house_count + $this->input->post('house_count') > $house_count)
			return -2;
			
		$this->db->select('count(1) broker_count')->from('admin')->where('subsidiary_id',$this->input->post('subsidiary_id'));
		if($this->input->post('id'))
			$this->db->where('id !=',$this->input->post('id'));
		$rs = $this->db->get()->row();
		if($rs->broker_count + 1 > $broker_count)
			return -3;
		
		$this->db->trans_start();//--------开始事务
		
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('admin', $data);
		} else {
			$this->db->insert('admin', $data);
		}
		$this->db->trans_complete();//------结束事务
    	if ($this->db->trans_status() === FALSE) {
    		return -1;
    	} else {
    		return 1;
    	} 
	}

	public function get_broker($id) {
		return $this->db->get_where('admin', array('id' => $id))->row_array();
	}
	
	public function delete_broker($id) {
		$this->db->where('id', $id);
		return $this->db->delete('admin');
	}
	
	public function get_region_list() {
		return $this->db->get('house_region')->result();
	}
	
	public function get_admin_by_tel($tel) {
		return $this->db->get_where('admin', array('tel' => $tel))->row_array();
	}
	
	/**
	 * 房源特色
	 */
	public function list_house_feature(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('feature');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		
		//list
		$this->db->select('*')->from('feature');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_feature() {
		$data = array(
			'type_id' => $this->input->post('type_id'),
			'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('feature', $data);
		} else {
			$this->db->insert('feature', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_feature($id) {
		return $this->db->get_where('feature', array('id' => $id))->row_array();
	}
	
	public function delete_house_feature($id) {
		$this->db->where('id', $id);
		return $this->db->delete('feature');
	}
	
	/**
	 * 楼盘类型
	 */
	public function list_house_style(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_style');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('*')->from('house_style');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_style() {
		$data = array(
				'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('house_style', $data);
		} else {
			$this->db->insert('house_style', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_style($id) {
		return $this->db->get_where('house_style', array('id' => $id))->row_array();
	}
	
	public function delete_house_style($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house_style');
	}
	
	/**
	 * 所在区域
	 */
	public function list_house_region(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_region');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('*')->from('house_region');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_region() {
		$data = array(
			'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('house_region', $data);
		} else {
			$this->db->insert('house_region', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_region($id) {
		return $this->db->get_where('house_region', array('id' => $id))->row_array();
	}
	
	public function delete_house_region($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house_region');
	}
	
	public function list_house_orientation(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_orientation');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('*')->from('house_orientation');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_orientation() {
		$data = array(
			'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('house_orientation', $data);
		} else {
			$this->db->insert('house_orientation', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_orientation($id) {
		return $this->db->get_where('house_orientation', array('id' => $id))->row_array();
	}
	
	public function delete_house_orientation($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house_orientation');
	}
	
	/**
	 * 装修状况
	 */
	public function list_house_decoration(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_decoration');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('*')->from('house_decoration');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_decoration() {
		$data = array(
			'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('house_decoration', $data);
		} else {
			$this->db->insert('house_decoration', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_decoration($id) {
		return $this->db->get_where('house_decoration', array('id' => $id))->row_array();
	}
	
	public function delete_house_decoration($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house_decoration');
	}
	
	/**
	 * 小区信息
	 */
	public function list_xiaoqu(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('xiaoqu');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('*')->from('xiaoqu');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_xiaoqu() {
		$data = array(
			'name' => $this->input->post('name'),
			'short' => $this->input->post('short'),
			'jianpin' => $this->input->post('jianpin'),
			'address' => $this->input->post('address'),
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('xiaoqu', $data);
		} else {
			$this->db->insert('xiaoqu', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_xiaoqu($id) {
		return $this->db->get_where('xiaoqu', array('id' => $id))->row_array();
	}
	
	public function delete_xiaoqu($id) {
		$this->db->where('id', $id);
		return $this->db->delete('xiaoqu');
	}
	
	public function get_style_list() {
		return $this->db->get('house_style')->result();
	}
	
	public function get_decoration_list() {
		return $this->db->get('house_decoration')->result();
	}
	
	public function get_orientation_list() {
		return $this->db->get('house_orientation')->result();
	}
	
	/**
	 * 二手房信息
	 */
	public function list_sd_house($term_id = NULL){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
		$this->db->where('type_id', 2);
		if($this->session->userdata('group_id') == 2) {
			$this->db->where('broker_id', $this->session->userdata('user_id'));
		}

		if($term_id){
			$where = "(id not in (select house_id from term_house where term_id = ".$term_id."))";
			$this->db->where($where);
		}
		
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS style_name, d.name AS orientation_name, e.name AS decoration_name, f.name AS xiaoqu_name');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_style c', 'a.style_id = c.id', 'left');
		$this->db->join('house_orientation d', 'a.orientation_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.decoration_id = e.id', 'left');
		$this->db->join('xiaoqu f', 'a.xq_id = f.id', 'left');
		if($this->input->post('name')){
			$this->db->like('a.name',$this->input->post('name'));
			$data['name'] = $this->input->post('name');
		}
		$this->db->where('type_id', 2);
		if($this->session->userdata('group_id') == 2) {
			$this->db->where('broker_id', $this->session->userdata('user_id'));
		}
		
		if($term_id){
			$where = "(a.id not in (select house_id from term_house where term_id = ".$term_id."))";
			$this->db->where($where);
		}
		
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function list_sd_house_cloud(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
		$this->db->where('type_id', 2);
		if($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 0) {//普通业务员
			$this->db->where('broker_id', $this->session->userdata('user_id'));
		}

		if($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 2) {//分店店长
			$this->db->where('subsidiary_id', $this->session->userdata('subsidiary_id'));
		}

		if($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 1) {//总店店长
			$this->db->where('company_id', $this->session->userdata('company_id'));
		}

		$where = "(id not in (select hid from cloud_house))";
		$this->db->where($where);

		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		$data['name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS style_name, d.name AS orientation_name, e.name AS decoration_name, f.name AS xiaoqu_name');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_style c', 'a.style_id = c.id', 'left');
		$this->db->join('house_orientation d', 'a.orientation_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.decoration_id = e.id', 'left');
		$this->db->join('xiaoqu f', 'a.xq_id = f.id', 'left');
		if($this->input->post('name')){
			$this->db->like('a.name',$this->input->post('name'));
			$data['name'] = $this->input->post('name');
		}
		$this->db->where('type_id', 2);
		if($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 0) {//普通业务员
			$this->db->where('broker_id', $this->session->userdata('user_id'));
		}

		if($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 2) {//分店店长
			$this->db->where('subsidiary_id', $this->session->userdata('subsidiary_id'));
		}

		if($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 1) {//总店店长
			$this->db->where('company_id', $this->session->userdata('company_id'));
		}

		$where = "(a.id not in (select hid from cloud_house))";
		$this->db->where($where);

		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function list_broker_dialog(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('admin');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('rel_name'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['name'] = null;
		//list
		$this->db->select();
		$this->db->from('admin');
		if($this->input->post('name')){
			$this->db->like('name',$this->input->post('name'));
			$data['name'] = $this->input->post('name');
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_sd_house() {
		$data = array(
			'name' => $this->input->post('name'),
			'sub_title' => $this->input->post('sub_title'),
			'type_id' => $this->input->post('type_id'),
			'xq_id' => $this->input->post('xq_id'),
			'region_id' => $this->input->post('region_id'),
			'style_id' => $this->input->post('style_id'),
			'substyle_id' => $this->input->post('substyle_id'),
			'total_price' => $this->input->post('total_price'),
			'acreage' => $this->input->post('acreage'),
			'room' => $this->input->post('room'),
			'lounge' => $this->input->post('lounge'),
			'toilet' => $this->input->post('toilet'),
			'feature' => @implode(',', $this->input->post('feature')),
			'orientation_id' => $this->input->post('orientation_id'),
			'floor' => $this->input->post('floor'),
			'total_floor' => $this->input->post('total_floor'),
			'decoration_id' => $this->input->post('decoration_id'),
			'build_year' => $this->input->post('build_year'),
			'estate_price' => $this->input->post('estate_price'),
			'facility' => $this->input->post('facility'),
			'broker_id' => $this->session->userdata('user_id'),
			'description' => $this->input->post('description'),
			//'house_pic' => $this->input->post('house_pic'),
			'folder' => $this->input->post('folder'),
			'bg_pic' => $this->input->post('is_bg'),
			'recommend'=>$this->input->post('recommend')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$h_id = $this->input->post('id');
			$this->db->where('id', $h_id);
			$this->db->update('house', $data);
			
			$this->db->delete('house_img', array('h_id' => $h_id));
		} else {
			$this->db->insert('house', $data);
			$h_id = $this->db->insert_id();
		}
		
		$folder = $this->input->post('folder');
		$desc = $this->input->post('desc');
		$is_bg = $this->input->post('is_bg');
		$pic_short1 = $this->input->post('pic_short1');
		foreach ($pic_short1 as $idx => $pic) {
			$pic_data = array(
				'h_id' => $h_id,
				'type_id' => 1,
				'pic' => str_replace('_thumb', '', $pic),
				'pic_short' => $pic
			);
			$this->db->insert('house_img', $pic_data);
		}
		
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_sd_house($id) {
		$this->db->select('a.*, b.name AS xq_name');
		$this->db->from('house a');
		$this->db->join('xiaoqu b', 'a.xq_id = b.id', 'left');
		$this->db->where('a.id', $id);
		return $this->db->get()->row_array();
	}
	
	public function delete_sd_house($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house');
	}
	
	public function get_upload_house_img($h_id) {
		return $this->db->get_where('house_img', array('h_id' => $h_id, 'type_id' => 1))->result_array();
	}
	
	
	
	/**
	 * 租房信息
	 */
	public function list_rent_house(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
		$this->db->where('type_id', 3);
		if($this->session->userdata('group_id') == 2) {
			$this->db->where('broker_id', $this->session->userdata('user_id'));
		}
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['rel_name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS style_name, d.name AS orientation_name, e.name AS decoration_name, f.name AS xiaoqu_name');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_style c', 'a.style_id = c.id', 'left');
		$this->db->join('house_orientation d', 'a.orientation_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.decoration_id = e.id', 'left');
		$this->db->join('xiaoqu f', 'a.xq_id = f.id', 'left');
		if($this->input->post('name')){
			$this->db->like('a.name',$this->input->post('name'));
			$data['rel_name'] = $this->input->post('name');
		}
		$this->db->where('type_id', 3);
		if($this->session->userdata('group_id') == 2) {
			$this->db->where('broker_id', $this->session->userdata('user_id'));
		}
	
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_rent_house() {
		$data = array(
			'name' => $this->input->post('name'),
			'sub_title' => $this->input->post('sub_title'),
			'type_id' => $this->input->post('type_id'),
			'xq_id' => $this->input->post('xq_id'),
			'region_id' => $this->input->post('region_id'),
			'style_id' => $this->input->post('style_id'),
			'substyle_id' => $this->input->post('substyle_id'),
			'unit_price' => $this->input->post('unit_price'),
			'acreage' => $this->input->post('acreage'),
			'room' => $this->input->post('room'),
			'lounge' => $this->input->post('lounge'),
			'toilet' => $this->input->post('toilet'),
			'feature' => @implode(',', $this->input->post('feature')),
			'orientation_id' => $this->input->post('orientation_id'),
			'floor' => $this->input->post('floor'),
			'total_floor' => $this->input->post('total_floor'),
			'decoration_id' => $this->input->post('decoration_id'),
			'build_year' => $this->input->post('build_year'),
			'estate_price' => $this->input->post('estate_price'),
			'facility' => $this->input->post('facility'),
			'broker_id' => $this->session->userdata('user_id'),
			'description' => $this->input->post('description'),
			//'house_pic' => $this->input->post('house_pic'),
			'folder' => $this->input->post('folder'),
			'bg_pic' => $this->input->post('is_bg'),
			'rent_style_id' => $this->input->post('rent_style_id'),
			'rent_type_id' => $this->input->post('rent_type_id'),
			'recommend'=>$this->input->post('recommend')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$h_id = $this->input->post('id');
			$this->db->where('id', $h_id);
			$this->db->update('house', $data);
				
			$this->db->delete('house_img', array('h_id' => $h_id));
		} else {
			$this->db->insert('house', $data);
			$h_id = $this->db->insert_id();
		}
	
		$folder = $this->input->post('folder');
		$desc = $this->input->post('desc');
		$is_bg = $this->input->post('is_bg');
		$pic_short1 = $this->input->post('pic_short1');
		foreach ($pic_short1 as $idx => $pic) {
			$pic_data = array(
					'h_id' => $h_id,
					'type_id' => 1,
					'pic' => str_replace('_thumb', '', $pic),
					'pic_short' => $pic
			);
			$this->db->insert('house_img', $pic_data);
		}
	
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_rent_house($id) {
		return $this->get_sd_house($id);
	}
	
	public function delete_rent_house($id) {
		return $this->delete_sd_house($id);
	}
	
	/**
	 * 楼盘类型（二级）
	 */
	public function list_house_substyle(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_substyle');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('a.*, b.name AS style_name')->from('house_substyle a');
		$this->db->join('house_style b', 'a.style_id = b.id', 'left');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_substyle() {
		$data = array(
			'style_id' => $this->input->post('style_id'),
			'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('house_substyle', $data);
		} else {
			$this->db->insert('house_substyle', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_substyle($id) {
		return $this->db->get_where('house_substyle', array('id' => $id))->row_array();
	}
	
	public function delete_house_substyle($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house_substyle');
	}
	
	public function get_substyle_list_by_parent($id) {
		return $this->db->get_where('house_substyle', array('style_id' => $id))->result_array();
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	public function get_all_xiaoqu_list() {
		return $this->db->get('xiaoqu')->result_array();
	}
	
	public function update_xiaoqu_jianpin($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('xiaoqu', $data);
	}
	
	public function add_broker_batch($data) {
		
		$this->db->trans_start();//--------开始事务
		$this->db->insert_batch('admin', $data);
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	//  经纪人接口
	//////////////////////////////////////////////////////////////////////////////////
	/**
	 * 公司信息
	 */
	public function list_company(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('company');
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('id', $this->session->userdata('company_id'));
		} else if($this->session->userdata('manager_group') == 2) {
			$this->db->where('id', -1);
		}
		
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('*')->from('company');
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('id', $this->session->userdata('company_id'));
		} else if($this->session->userdata('manager_group') == 2) {
			$this->db->where('id', -1);
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_company() {
		$data = array(
			'name' => $this->input->post('name'),
			'company_count' => $this->input->post('company_count'),
			'broker_count' => $this->input->post('broker_count'),
			'house_count' => $this->input->post('house_count'),
			'address' => $this->input->post('address'),
			'tel' => $this->input->post('tel'),
			'description' => $this->input->post('description')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('company', $data);
		} else {
			$this->db->insert('company', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_company($id) {
		return $this->db->get_where('company', array('id' => $id))->row_array();
	}
	
	public function delete_company($id) {
		$this->db->where('id', $id);
		return $this->db->delete('company');
	}
	
	/**
	 * 分店信息
	 */
	public function list_subsidiary($tid = null){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('subsidiary');
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('company_id', $this->session->userdata('company_id'));
		} else if($this->session->userdata('manager_group') == 2) {
			$this->db->where('id', $this->session->userdata('subsidiary_id'));
		}
		
		if($this->input->post('company_id'))
			$this->db->where('company_id',$this->input->post('company_id'));
		
		if($tid){
			$where = "(id not in (select cid from share_company where tid = ".$tid."))";
			$this->db->where($where);
		}
		
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		$data['company_id'] = null;
	
		//list
		$this->db->select('a.*, b.name AS company_name');
		$this->db->from('subsidiary a');
		$this->db->join('company b', 'a.company_id = b.id', 'left');
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('a.company_id', $this->session->userdata('company_id'));
		} else if($this->session->userdata('manager_group') == 2) {
			$this->db->where('a.id', $this->session->userdata('subsidiary_id'));
		}
		if($this->input->post('company_id')){
			$this->db->where('company_id',$this->input->post('company_id'));
			$data['company_id'] = $this->input->post('company_id');
		}
		
		if($tid){
			$where = "(a.id not in (select cid from share_company where tid = ".$tid."))";
			$this->db->where($where);
		}
			
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'a.id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_subsidiary() {
		$res = $this->db->select('company_count,house_count,broker_count')->from('company')->where('id',$this->input->post('company_id'))->get()->row();
		$company_count = $res->company_count;
		$house_count = $res->house_count;
		$broker_count = $res->broker_count;
		
		$this->db->select('count(1) num')->from('subsidiary');
		$this->db->where('company_id',$this->input->post('company_id'));
		if($this->input->post('id'))
			$this->db->where('id !=',$this->input->post('id'));
		$rs = $this->db->get()->row();
		
		if($rs->num + 1 > $company_count){
			return -2;
		}
		
		$data = array(
			'company_id' => $this->input->post('company_id'),
			'name' => $this->input->post('name'),
			'house_count' => $this->input->post('house_count'),
			'broker_count' => $this->input->post('broker_count')
		);
		
		$this->db->select('sum(house_count) house_count')->from('subsidiary')->where('company_id',$this->input->post('company_id'));
		if($this->input->post('id'))
			$this->db->where('id !=',$this->input->post('id'));
		$rs = $this->db->get()->row();
		if($rs->house_count + $this->input->post('house_count') > $house_count)
			return -3;
			
		$this->db->select('sum(broker_count) broker_count')->from('subsidiary')->where('company_id',$this->input->post('company_id'));
		if($this->input->post('id'))
			$this->db->where('id !=',$this->input->post('id'));
		$rs = $this->db->get()->row();
		if($rs->broker_count + $this->input->post('broker_count') > $broker_count)
			return -4;
		
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('subsidiary', $data);
		} else {
			$this->db->insert('subsidiary', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_subsidiary($id) {
		return $this->db->get_where('subsidiary', array('id' => $id))->row_array();
	}
	
	public function delete_subsidiary($id) {
		$this->db->where('id', $id);
		return $this->db->delete('subsidiary');
	}
	
	public function get_company_list($id=NULL) {
		if(empty($id)) {
			return $this->db->get('company')->result();
		} else {
			return $this->db->get_where('company', array('id' => $id))->result();
		}
	}
	
	public function get_subsidiary_list_by_company($id, $sid = NULL) {
		if(empty($sid)) {
			return $this->db->get_where('subsidiary', array('company_id' => $id))->result_array();
		} else {
			return $this->db->get_where('subsidiary', array('company_id' => $id, 'id' => $sid))->result_array();
		}
	}
	

	public function list_term(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('term');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['name'] = null;
		//list
		$this->db->select('*');
		$this->db->from('term');
		if($this->input->post('name')){
			$this->db->like('name',$this->input->post('name'));
		}
	
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'created', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'asc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function save_term($data){
		$this->db->trans_start();
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('term', $data);
		}else{//新增
			$data['created'] = date('Y-m-d H:i:s',time());
			$this->db->insert('term', $data);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}

	public function delete_term($id){
		$data = $this->get_term($id);
		$rs = $this->db->delete('term', array('id' => $id));
		if($rs){
			@unlink('./././uploadfiles/term/'.$data['img']);//del old img
			return 1;
		}else{
			return $this->db_error;
		}
	}

	public function get_term($id){
		$this->db->from('term a')->where('id', $id);
		$data = $this->db->get()->row_array();
		
		$data['list'] = $this->db->select('a.*,b.name house_name')->from('term_house a')->join('house b','a.house_id=b.id','left')->where('a.term_id',$id)->get()->result();
		return $data;
	}
	
	public function add_term_house($term_id,$house_id){
		$data = array(
				'term_id'=>$term_id,
				'house_id'=>$house_id
		);
		return $this->db->insert('term_house',$data);
	}

	public function add_cloud_house($house_id){
		$data = array(
			'hid'=>$house_id,
			'bid'=>$this->session->userdata('user_id'),
			'cid'=>$this->session->userdata('company_id'),
			'sid'=>$this->session->userdata('subsidiary_id'),
			'cdate'=>date('Y-m-d H:i:s',time())
		);
		return $this->db->insert('cloud_house',$data);
	}
	
	public function del_term_house($term_id,$house_id){
		$this->db->where('term_id',$term_id);
		$this->db->where('house_id',$house_id);
		return $this->db->delete('term_house');
	}

	public function del_cloud_house($house_id){
		$this->db->where('hid',$house_id);
		$this->db->where('bid',$this->session->userdata('user_id'));
		return $this->db->delete('cloud_house');
	}
	
	public function list_all_company(){
		return $this->db->select('id,name')->from('company')->get()->result_array();
	}
	
	public function list_binding() {
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
		
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('wx_user a');
		$this->db->join('admin b', 'a.broker_id = b.id', 'inner');
		$this->db->join('subsidiary c', 'b.subsidiary_id = c.id', 'left');
		$this->db->join('company d', 'b.company_id = d.id', 'left');
		if($this->session->userdata('admin_group') == 2) {
			$this->db->where('b.id', $this->session->userdata('user_id'));
		}
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		
		//list
		$this->db->select('a.id, a.open_id, b.rel_name AS broker_name, b.username, b.tel, c.name AS company_name, d.name AS subsidiary_name');
		$this->db->from('wx_user a');
		$this->db->join('admin b', 'a.broker_id = b.id', 'inner');
		$this->db->join('subsidiary c', 'b.subsidiary_id = c.id', 'left');
		$this->db->join('company d', 'b.company_id = d.id', 'left');
		if($this->session->userdata('admin_group') == 2) {
			$this->db->where('b.id', $this->session->userdata('user_id'));
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function delete_binding($id) {
		$this->db->where('id',$id);
		return $this->db->delete('wx_user');
	}
	
	public function list_tracking() {
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_track a');
		$this->db->from('wx_user t', 'a.open_id = t.open_id', 'left');
		$this->db->join('house b', 'a.house_id = b.id', 'inner');
		$this->db->join('xiaoqu c', 'b.xq_id = c.id', 'left');
		$this->db->join('house_region d', 'b.region_id = d.id', 'left');
		if($this->session->userdata('admin_group') == 2) {
			$this->db->where('t.broker_id', $this->session->userdata('user_id'));
		}
		
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		//list
		$this->db->select('a.id, a.open_id, b.id AS house_id, b.total_price, b.acreage, b.room, b.lounge, b.toilet, b.feature, c.name AS xiaoqu_name, d.name AS region_name');
		$this->db->from('house_track a');
		$this->db->from('wx_user t', 'a.open_id = t.open_id', 'left');
		$this->db->join('house b', 'a.house_id = b.id', 'inner');
		$this->db->join('xiaoqu c', 'b.xq_id = c.id', 'left');
		$this->db->join('house_region d', 'b.region_id = d.id', 'left');
		if($this->session->userdata('admin_group') == 2) {
			$this->db->where('t.broker_id', $this->session->userdata('user_id'));
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function delete_tracking($id) {
		$this->db->where('id',$id);
		return $this->db->delete('house_track');
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
	/**
	 * 经纪人微站专题页封面页
	 */
	public function list_article(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('article a');
		$this->db->join('admin b', 'a.broker_id = b.id');
		if($this->session->userdata('login_broker_id')) {
			$this->db->where('a.broker_id', $this->session->userdata('login_broker_id'));
		}
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		//list
		$this->db->select('a.*, b.rel_name');
		$this->db->from('article a');
		$this->db->join('admin b', 'a.broker_id = b.id');
		if($this->session->userdata('login_broker_id')) {
			$this->db->where('a.broker_id', $this->session->userdata('login_broker_id'));
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_article() {
		$data = array(
			'broker_id' => $this->session->userdata('user_id'),
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'force_show' => $this->input->post('force_show'),
			'created' => date('Y-m-d H:i:s'),
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			unset($data['created']);
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('article', $data);
		} else {
			$this->db->insert('article', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_article($id) {
		return $this->db->get_where('article', array('id' => $id))->row_array();
	}
	
	public function delete_article($id) {
		$this->db->where('id', $id);
		return $this->db->delete('article');
	}

	public function cloud_house(){
		$this->db->select('b.id,b.name')->from('cloud_house a');
		$this->db->join('house b','a.hid=b.id','left');
		if($this->session->userdata('manager_group') == 1) {
			$this->db->where('a.cid', $this->session->userdata('company_id'));
		}
		if($this->session->userdata('manager_group') == 2) {
			$this->db->where('a.sid', $this->session->userdata('subsidiary_id'));
		}
		if($this->session->userdata('manager_group') == 0 && $this->session->userdata('admin_group') == 1) {
			$this->db->where('a.bid', $this->session->userdata('login_broker_id'));
		}
		$data = $this->db->get()->result();
		return $data;
	}
	
	public function list_house_push(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 100;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
		
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_push');
		if($this->session->userdata('login_broker_id')) {
			$this->db->where('broker_id', $this->session->userdata('login_broker_id'));
		}
		if($this->input->post('open_id'))
			$this->db->where('open_id', $this->input->post('open_id'));
		if($this->input->post('date'))
			$this->db->where('date', $this->input->post('date'));
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		
		$data['open_id'] = null;
		$data['date'] = null;
		
		//list
		$this->db->select('a.*, d.name, c.nickname');
		$this->db->from('house_push a');
		$this->db->join('house b', 'a.house_id = b.id');
		$this->db->join('weixin c', 'a.open_id = c.openid');
		$this->db->join('xiaoqu d', 'b.xq_id = d.id');
		if($this->session->userdata('login_broker_id')) {
			$this->db->where('a.broker_id', $this->session->userdata('login_broker_id'));
		}
		if($this->input->post('open_id')) {
			$this->db->where('open_id', $this->input->post('open_id'));
			$data['open_id'] = $this->input->post('open_id');
		}
		if($this->input->post('date')) {
			$this->db->where('date', $this->input->post('date'));
			$data['date'] = $this->input->post('date');
		}
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function list_wx_user() {
		return $this->db->get_where('weixin', array('subscribe' => 1, 'nickname <>' => ''))->result_array();
	}
	
	public function list_house_push_dialog() {
		
		// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 50;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
    	$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
    	if($this->input->post('search_xiaoqu')) {
    		$this->db->like('d.name', $this->input->post('search_xiaoqu'));
    	}
    	if($this->input->post('search_region')) {
    		$search_region = intval($this->input->post('search_region'));
    		if($search_region == 6) {
    			$this->db->where_in('a.region_id', array(1,2,3,4,5,6));
    		} else {
    			$this->db->where('a.region_id', $search_region);
    		}
    	}
    	if($this->input->post('search_style'))
    		$this->db->where('a.substyle_id',$this->input->post('search_style'));
    	if($this->input->post('search_price')){
    		$search_price = intval($this->input->post('search_price'));
    		if($search_price == 1) {
    			$this->db->where('a.total_price <=', '50');
    		} else if($search_price == 2) {
    			$this->db->where('a.total_price >',  '50');
    			$this->db->where('a.total_price <=', '80');
    		} else if($search_price == 3) {
    			$this->db->where('a.total_price >',  '80');
    			$this->db->where('a.total_price <=', '100');
    		} else if($search_price == 4) {
    			$this->db->where('a.total_price >',  '100');
    			$this->db->where('a.total_price <=', '120');
    		} else if($search_price == 5) {
    			$this->db->where('a.total_price >',  '120');
    			$this->db->where('a.total_price <=', '150');
    		} else if($search_price == 6) {
    			$this->db->where('a.total_price >',  '150');
    			$this->db->where('a.total_price <=', '200');
    		} else if($search_price == 7) {
    			$this->db->where('a.total_price >',  '200');
    			$this->db->where('a.total_price <=', '250');
    		} else if($search_price == 8) {
    			$this->db->where('a.total_price >',  '250');
    			$this->db->where('a.total_price <=', '300');
    		} else if($search_price == 9) {
    			$this->db->where('a.total_price >',  '300');
    			$this->db->where('a.total_price <=', '500');
    		} else if($search_price == 10) {
    			$this->db->where('a.total_price >',  '500');
    		}
    	}
    	if($this->input->post('search_acreage')) {
    		$search_acreage = intval($this->input->post('search_acreage'));
    		if($search_acreage == 1) {
    			$this->db->where('a.acreage <=', '50');
    		} else if($search_acreage == 2) {
    			$this->db->where('a.acreage >',  '50');
    			$this->db->where('a.acreage <=', '70');
    		} else if($search_acreage == 3) {
    			$this->db->where('a.acreage >',  '70');
    			$this->db->where('a.acreage <=', '90');
    		} else if($search_acreage == 4) {
    			$this->db->where('a.acreage >',  '90');
    			$this->db->where('a.acreage <=', '120');
    		} else if($search_acreage == 5) {
    			$this->db->where('a.acreage >',  '120');
    			$this->db->where('a.acreage <=', '150');
    		} else if($search_acreage == 6) {
    			$this->db->where('a.acreage >',  '150');
    			$this->db->where('a.acreage <=', '200');
    		} else if($search_acreage == 7) {
    			$this->db->where('a.acreage >',  '200');
    			$this->db->where('a.acreage <=', '300');
    		} else if($search_acreage == 8) {
    			$this->db->where('a.acreage >',  '300');
    		}
    	}
    	if($this->input->post('search_type')) {
    		$search_type = intval($this->input->post('search_type'));
    		if($search_type > 5) {
    			$this->db->where('a.room >', '5');
    		} else {
    			$this->db->where('a.room', $search_type);
    		}
    	}
    	if($this->input->post('search_feature'))
    		$this->db->like('a.feature', $this->input->post('search_feature'));
    	if($this->input->post('search_text')) {
    		$t = $this->input->post('search_text');
    		$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%' OR c.name LIKE '%" . $t . "%' OR d.name LIKE '%" . $t . "%')";
    		$this->db->where($where);
    	}
    	$this->db->where('a.type_id', 2);
    	$this->db->where('a.exe_status', 1);

    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;

    	$data['search_xiaoqu'] = null;
    	$data['search_region'] = null;
    	$data['search_type'] = null;
    	//list
    	$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
    	$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
    	if($this->input->post('search_xiaoqu')) {
    		$this->db->like('d.name', $this->input->post('search_xiaoqu'));
    		$data['search_xiaoqu'] = $this->input->post('search_xiaoqu');
    	}
   	 	if($this->input->post('search_region')) {
     		$search_region = intval($this->input->post('search_region'));
     		if($search_region == 6) {
     			$this->db->where_in('a.region_id', array(1,2,3,4,5,6));
     		} else {
     			$this->db->where('a.region_id', $search_region);
     		}
     		$data['search_region'] = $search_region;
    	}
		if($this->input->post('search_style'))
			$this->db->where('a.substyle_id',$this->input->post('search_style'));
		if($this->input->post('search_price')){
			$search_price = intval($this->input->post('search_price'));
			if($search_price == 1) {
     			$this->db->where('a.total_price <=', '50');
     		} else if($search_price == 2) {
     			$this->db->where('a.total_price >',  '50');
     			$this->db->where('a.total_price <=', '80');
     		} else if($search_price == 3) {
     			$this->db->where('a.total_price >',  '80');
     			$this->db->where('a.total_price <=', '100');
     		} else if($search_price == 4) {
     			$this->db->where('a.total_price >',  '100');
     			$this->db->where('a.total_price <=', '120');
     		} else if($search_price == 5) {
     			$this->db->where('a.total_price >',  '120');
     			$this->db->where('a.total_price <=', '150');
     		} else if($search_price == 6) {
     			$this->db->where('a.total_price >',  '150');
     			$this->db->where('a.total_price <=', '200');
     		} else if($search_price == 7) {
     			$this->db->where('a.total_price >',  '200');
     			$this->db->where('a.total_price <=', '250');
     		} else if($search_price == 8) {
     			$this->db->where('a.total_price >',  '250');
     			$this->db->where('a.total_price <=', '300');
     		} else if($search_price == 9) {
     			$this->db->where('a.total_price >',  '300');
     			$this->db->where('a.total_price <=', '500');
     		} else if($search_price == 10) {
     			$this->db->where('a.total_price >',  '500');
     		}
		}
		if($this->input->post('search_acreage')) {
			$search_acreage = intval($this->input->post('search_acreage'));
			if($search_acreage == 1) {
				$this->db->where('a.acreage <=', '50');
			} else if($search_acreage == 2) {
				$this->db->where('a.acreage >',  '50');
				$this->db->where('a.acreage <=', '70');
			} else if($search_acreage == 3) {
				$this->db->where('a.acreage >',  '70');
				$this->db->where('a.acreage <=', '90');
			} else if($search_acreage == 4) {
				$this->db->where('a.acreage >',  '90');
				$this->db->where('a.acreage <=', '120');
			} else if($search_acreage == 5) {
				$this->db->where('a.acreage >',  '120');
				$this->db->where('a.acreage <=', '150');
			} else if($search_acreage == 6) {
				$this->db->where('a.acreage >',  '150');
				$this->db->where('a.acreage <=', '200');
			} else if($search_acreage == 7) {
				$this->db->where('a.acreage >',  '200');
				$this->db->where('a.acreage <=', '300');
			} else if($search_acreage == 8) {
				$this->db->where('a.acreage >',  '300');
			}
		}
		if($this->input->post('search_type')) {
			$search_type = intval($this->input->post('search_type'));
			if($search_type > 5) {
				$this->db->where('a.room >', '5');
			} else {
				$this->db->where('a.room', $search_type);
			}
			$data['search_type'] = $search_type;
		}
		if($this->input->post('search_feature'))
			$this->db->like('a.feature', $this->input->post('search_feature'));
		if($this->input->post('search_text')) {
			$t = $this->input->post('search_text');
			$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%' OR c.name LIKE '%" . $t . "%' OR d.name LIKE '%" . $t . "%')";
			$this->db->where($where);
		}
    	$this->db->where('a.type_id', 2);
    	$this->db->where('a.exe_status', 1);
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);

    	$orderField = $this->input->post('search_order');
    	if($orderField == 1) {
    		$orderDirection = $this->input->post('order_price_dir');
    		if($orderDirection == 1) {
    			$this->db->order_by('a.total_price', 'desc');
    		} else {
    			$this->db->order_by('a.total_price', 'asc');
    		}
    	} else {
    		$this->db->order_by('refresh_time', 'desc');
    		$this->db->order_by('a.id', 'desc');
    	}

    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
	}
	
	public function get_bind_wx_users() {
		$this->db->select('a.open_id, b.nickname, b.sex, b.headimgurl');
		$this->db->distinct();
		$this->db->from('wx_user a');
		$this->db->join('weixin b', 'a.open_id = b.openid');
		$group_id = $this->session->userdata('group_id');
		if($group_id > 1) {
			$broker_id = $this->session->userdata('user_id');
			$this->db->where('a.broker_id', $broker_id);
		}
		$this->db->where('b.subscribe', 1);
		return $this->db->get()->result_array();
	}
	
	public function list_house_tracks($open_id) {
		$this->db->select('a.id, a.room, a.total_price, a.acreage, a.bg_pic, a.feature, b.name AS region_name, c.name AS xq_name, t.call_time');
		$this->db->from('house_track t');
		$this->db->join('house a', 't.house_id = a.id', 'inner');
		$this->db->join('house_region b', 'a.region_id = b.id', 'inner');
		$this->db->join('xiaoqu c', 'a.xq_id = c.id', 'inner');
		$this->db->where('t.open_id', $open_id);
		$this->db->order_by('t.date', 'desc');
		$this->db->limit(20);
		return $this->db->get()->result_array();
	}
}
