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
	public function del_pic($folder,$pic,$id){
		//echo $id;die;
		if($id){
			$this->db->where('pic_short',$pic);
			$this->db->delete('house_img');
		}
		if(@unlink('./././uploadfiles/pics/'.$folder.'/'.$pic)){
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
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['rel_name'] = null;
		//list
		$this->db->select('*');
		$this->db->from('admin');
		if($this->input->post('rel_name')){
			$this->db->like('rel_name',$this->input->post('rel_name'));
			$data['rel_name'] = $this->input->post('rel_name');
		}
	
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
}
