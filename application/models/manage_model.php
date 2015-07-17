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
    public function check_login ()
    {
        $login_id = $this->input->post('username');
        $passwd = $this->input->post('password');
        $this->db->from('admin');
        $this->db->where('username', $login_id);
        $this->db->where('passwd', sha1($passwd));
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            $user_info['username'] = $this->input->post('username');
            $this->session->set_userdata($user_info);
            return true;
        } else {
            return false;
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
		$this->db->from($this->tables[4]);
		if($this->input->post('title'))
			$this->db->like('title',$this->input->post('title'));
		
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		
		$data['title'] = null;
		//list
		$this->db->select('*');
		$this->db->from("{$this->tables[4]}");
		if($this->input->post('title')){
			$this->db->like('title',$this->input->post('title'));
			$data['title'] = $this->input->post('title');
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
		if(@unlink('./././uploadfiles/pics/'.$folder.'/'.$type_id.'/'.$pic)){
			$data = array(
					'flag'=>1,
					'pic'=>$pic
			);
		}else{
			$data = array(
					'flag'=>1,
					'pic'=>$pic
			);
		}
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
    


    /**
     *
     * ***************************************shenbin*******************************************************************
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
		$this->db->where('id >', 1);
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['rel_name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name');
		$this->db->from('admin a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		if($this->input->post('rel_name')){
			$this->db->like('a.rel_name',$this->input->post('rel_name'));
			$data['rel_name'] = $this->input->post('rel_name');
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
		$data = array(
			'username' => $this->input->post('tel'),
			'passwd' => sha1('888888'),
			'tel' => $this->input->post('tel'),
			'company_name' => $this->input->post('company_name'),
			'rel_name' => $this->input->post('rel_name'),
			'region_id' => $this->input->post('region_id')
		);
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
	
	public function list_house_feature(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house_feature');
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		
		//list
		$this->db->select('*')->from('house_feature');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
	
	public function save_house_feature() {
		$data = array(
			'name' => $this->input->post('name')
		);
		$this->db->trans_start();//--------开始事务
	
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('house_feature', $data);
		} else {
			$this->db->insert('house_feature', $data);
		}
		$this->db->trans_complete();//------结束事务
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}
	}
	
	public function get_house_feature($id) {
		return $this->db->get_where('house_feature', array('id' => $id))->row_array();
	}
	
	public function delete_house_feature($id) {
		$this->db->where('id', $id);
		return $this->db->delete('house_feature');
	}
	
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
			'address' => $this->input->post('address')
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
	
	public function list_sd_house(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['rel_name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_style c', 'a.style_id = c.id', 'left');
		$this->db->join('house_orientation d', 'a.region_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.region_id = e.id', 'left');
		$this->db->join('house_style f', 'a.style_id = f.id', 'left');
		if($this->input->post('name')){
			$this->db->like('a.name',$this->input->post('name'));
			$data['rel_name'] = $this->input->post('name');
		}
		
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}
}
