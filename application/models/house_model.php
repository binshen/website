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
class House_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }

    public function get_second_hand_list() {
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 1;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    	
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('house');
     	if($this->input->post('search_region'))
     		$this->db->where('region_id',$this->input->post('search_region'));
    	$this->db->where('type_id', 2);
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    	
    	$data['rel_name'] = null;
    	//list
    	$this->db->select('a.*');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		if($this->input->post('search_region'))
     		$this->db->where('region_id',$this->input->post('search_region'));
    	$this->db->where('type_id', 2);
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);
    	$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }
    
    public function get_search_region_list() {
    	return $this->db->get_where('house_region', array('id >' => 6))->result_array();
    }
    
    public function get_search_style_list() {
    	return $this->db->get_where('house_substyle')->result_array();
    }
}