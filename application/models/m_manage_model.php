<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 网站后台模型
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		bin.shen
 *        
 */
class M_manage_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }

    public function get_list($uid) {
//     	if($this->session->userdata('group_id') == '3'){
//     		$user_type_id = 2;
//     	}else{
//     		$user_type_id = 1;
//     	}
    	$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
    	$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
//    	$this->db->where('a.user_type',$user_type_id);
    	$this->db->where('broker_id',$uid);
    	
    	$this->db->order_by('exe_status', 'desc');
    	$this->db->order_by('refresh_time', 'desc');
    	$this->db->order_by('a.id', 'desc');
    	
    	$data['res_list'] = $this->db->get()->result();
    	
    	$rs = $this->db->select('count(1) num')->from('house_collect')->where('user_id',$uid)->get()->row();
    	$data['collect_count'] = $rs->num;
    	
    	return $data;
    }
    
    public function refresh($id){
    	$house = $this->db->select()->from('house')->where('id',$id)->get()->row_array();
    	$refresh_time = $house['refresh_time'];
    	if(!empty($refresh_time)) {
    		$refresh_date = substr($refresh_time, 0, 10);
    		if($refresh_date == date('Y-m-d', time())) {
    			return -2;
    		}
    	}
    	$this->db->where('id',$id);
    	$ret = $this->db->update('house',array('refresh_time'=>date('Y-m-d H:i:s',time())));
    	if($ret) {
    		return 1;
    	} else {
    		return -1;
    	}
    }
    
    public function down_up($id,$exe_status){
    	$this->db->where('id',$id);
    	return $this->db->update('house',array('exe_status'=>$exe_status));
    }
    
    public function get_house_detail($id){
    	return $this->db->select()->from('house')->where('id',$id)->get()->row_array();
    }
    
    public function post_edit(){
    	$data = array(
    			'name'=>$this->input->post('name'),
    			'total_price'=>$this->input->post('total_price'),
    			'acreage'=>$this->input->post('acreage'),
    	);
    	$this->db->where('id',$this->input->post('id'));
    	return $this->db->update('house',$data);
    }
		
    public function get_collects(){
    	$user_id = $this->session->userdata('user_id');
//     	if($this->session->userdata('group_id') == '3'){
//     		$user_type_id = 2;
//     	}else{
//     		$user_type_id = 1;
//     	}
    	$this->db->select('a.*,b.name house_name,total_price,room,lounge,toilet,refresh_time,c.name xq_name,d.name region_name')->from('house_collect a');
    	$this->db->join('house b','a.house_id	= b.id','left');
    	$this->db->join('xiaoqu c','b.xq_id	= c.id','left');
    	$this->db->join('house_region d','b.region_id	= d.id','left');
//    	$this->db->where('a.user_type',$user_type_id);
    	$this->db->where('a.user_id',$user_id);
    	$data['list'] = $this->db->get()->result_array();
    	
    	$rs = $this->db->select('count(1) num')->from('house')->where('user_id',$user_id)->get()->row();
    	$data['house_count'] = $rs->num;
    	return $data;
    }
  
}
