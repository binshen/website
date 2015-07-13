<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 系统设置模型
 * 可用于抓取系统初始数据以及定义系统变量和获取一些首页需要的信息
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Sysconfig_model extends MY_Model
{
	protected $tables = array(
            'product_type',
			'about',
			'news_type',
			'contact',
			'news',
			'teams',
			'team_type'

    );
	
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
	/**
     * 获取页面标题关键字等属性
     */
	public function get_pageset()
	{
		$pageset=array(
							'title'=>'捷安特单车运动服务(昆山)有限公司',
							'keywords'=>'捷安特单车运动服务(昆山)有限公司',
							'descrip'=>'捷安特单车运动服务(昆山)有限公司',
							'ico'=>'images/favicon.ico',
							'gif'=>'images/1.gif'
							//'websit_0_1'=>'http://tmyegg.kssina.com'
		);
		return $pageset;
	}
	
//	/**
//     * 获取所有产品类别
//     * @param $where 查询条件，为空则查询所有
//     */
//	public function get_product_type($where=null){
//        $this->db->select('*');
//        $this->db->from("{$this->tables[0]}");
//        if($where){
//        	$this->db->where('parent_id',$where);
//        }
//        $res = $this->db->get()->result_array();
//		return $res;        
//	}
	
//	/**
//     * 获取一级目录下的二级子目录
//     */
//	public function get_memu(){
//
//		$this->db->select('id,title');
//		$this->db->from("{$this->tables[1]}");
//		$res['about'] = $this->db->get()->result_array();
//		
//		$this->db->select('id,name');
//		$this->db->from("{$this->tables[2]}");
//		$this->db->where('parent_id',0);
//        $res['news'] = $this->db->get()->result_array();
//        
// 		$this->db->select('id,name');
//		$this->db->from("{$this->tables[6]}");
//        $res['team_type'] = $this->db->get()->result_array();
//        
//		return $res;        
//	}
	
//	/**
//     * 获取联系方式
//     */
//	public function get_contact(){
//		$this->db->select('*')->from($this->tables[3]);
//		return $this->db->get()->row_array();
//	}
	
//	/**
//     * 获取首页新闻信息
//     */
//	public function get_index_news(){
//		$this->db->select('*')->from($this->tables[4])->order_by('order_num','desc')->limit('5');
//		return $this->db->get()->result_array();
//	}
	
//	/**
//     * 获取首页团队信息
//     */
//	public function get_index_teams(){
//		$this->db->select('id,name,img')->from($this->tables[5])->order_by('order_num')->limit('8');
//		return $this->db->get()->result_array();
//	}
	
}

/* End of file sysconfig_model.php */
/* Location: ./application/models/sysconfig_model.php */