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
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    	
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
    	$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
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
    		$this->db->like('feature', $this->input->post('search_feature'));
    	if($this->input->post('search_text')) {
    		$t = $this->input->post('search_text');
    		$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%' OR c.name LIKE '%" . $t . "%' OR d.name LIKE '%" . $t . "%')";
    		$this->db->where($where);
    	}
    	$this->db->where('a.type_id', 2);
    	
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    	
    	$data['rel_name'] = null;
    	//list
    	$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
    	$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
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
			$this->db->like('feature', $this->input->post('search_feature'));
		if($this->input->post('search_text')) {
			$t = $this->input->post('search_text');
			$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%' OR c.name LIKE '%" . $t . "%' OR d.name LIKE '%" . $t . "%')";
			$this->db->where($where);
		}
    	$this->db->where('a.type_id', 2);
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
    		$this->db->order_by('a.id', 'desc');
    	}
    	
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }

    public function get_second_hand_detail($id) {
    	$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
    	$this->db->select('e.rel_name, e.company_name, g.name AS b_region_name, h.name AS decoration_name, ');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
    	$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
    	$this->db->join('house_region g', 'e.region_id = g.id', 'left');
    	$this->db->join('house_decoration h', 'a.decoration_id = h.id', 'left');
    	$this->db->where('a.type_id', 2);
    	return $this->db->where('a.id', $id)->get()->row_array();
    }
    
    public function get_broker_house_count($broker_id) {
    	return $this->db->get_where('house', array('broker_id' => $broker_id))->num_rows();
    }
    
    public function get_new_house_list() {
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    	
    	if($this->input->post('search_type')) {
    		$this->db->select('distinct(h_id)')->from('house_hold');
    		$search_type = intval($this->input->post('search_type'));
    		if($search_type > 5) {
    			$this->db->where('room >', '5');
    		} else {
    			$this->db->where('room', $search_type);
    		}
    		$rs = $this->db->get()->result_array();
    		$h_ids = array();
    		foreach($rs as $v){
    			$h_ids[] = $v['h_id'];
    		}
    	}
    	
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('house');
     	if($this->input->post('search_region')) {
     		$search_region = intval($this->input->post('search_region'));
     		if($search_region == 6) {
     			$this->db->where_in('region_id', array(1,2,3,4,5,6));
     		} else {
     			$this->db->where('region_id', $search_region);
     		}
    	}
     	if($this->input->post('search_style'))
     		$this->db->where('substyle_id',$this->input->post('search_style'));
     	
    	if($this->input->post('search_price')){
			$search_price = intval($this->input->post('search_price'));
			if($search_price == 1) {
     			$this->db->where('unit_price <', '5000');
     		} else if($search_price == 2) {
     			$this->db->where('unit_price >=',  '5000');
     			$this->db->where('unit_price <=', '6000');
     		} else if($search_price == 3) {
     			$this->db->where('unit_price >=',  '6000');
     			$this->db->where('unit_price <=', '7000');
     		} else if($search_price == 4) {
     			$this->db->where('unit_price >=',  '7000');
     			$this->db->where('unit_price <=', '8000');
     		} else if($search_price == 5) {
     			$this->db->where('unit_price >=',  '8000');
     			$this->db->where('unit_price <=', '10000');
     		} else if($search_price == 6) {
     			$this->db->where('unit_price >=',  '10000');
     			$this->db->where('unit_price <=', '15000');
     		} else if($search_price == 10) {
     			$this->db->where('unit_price >',  '15000');
     		}
		}
     	if($this->input->post('search_acreage')) {
     		$search_acreage = intval($this->input->post('search_acreage'));
     		if($search_acreage == 1) {
     			$this->db->where('acreage <=', '50');
     		} else if($search_acreage == 2) {
     			$this->db->where('acreage >',  '50');
     			$this->db->where('acreage <=', '70');
     		} else if($search_acreage == 3) {
     			$this->db->where('acreage >',  '70');
     			$this->db->where('acreage <=', '90');
     		} else if($search_acreage == 4) {
     			$this->db->where('acreage >',  '90');
     			$this->db->where('acreage <=', '120');
     		} else if($search_acreage == 5) {
     			$this->db->where('acreage >',  '120');
     			$this->db->where('acreage <=', '150');
     		} else if($search_acreage == 6) {
     			$this->db->where('acreage >',  '150');
     			$this->db->where('acreage <=', '200');
     		} else if($search_acreage == 7) {
     			$this->db->where('acreage >',  '200');
     			$this->db->where('acreage <=', '300');
     		} else if($search_acreage == 8) {
     			$this->db->where('acreage >',  '300');
     		}
     	}     	
     	if($this->input->post('search_type')) {
     		$this->db->where_in('id', $h_ids);
     	}     		
     	if($this->input->post('search_feature'))
     		$this->db->like('feature', $this->input->post('search_feature'));

    	$this->db->where('type_id', 1);
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    	
    	$data['rel_name'] = null;
    	//list
    	$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
    	$this->db->join('admin e', 'a.broker_id = e.id', 'left');
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
     			$this->db->where('a.unit_price <', '5000');
     		} else if($search_price == 2) {
     			$this->db->where('a.unit_price >=',  '5000');
     			$this->db->where('a.unit_price <=', '6000');
     		} else if($search_price == 3) {
     			$this->db->where('a.unit_price >=',  '6000');
     			$this->db->where('a.unit_price <=', '7000');
     		} else if($search_price == 4) {
     			$this->db->where('a.unit_price >=',  '7000');
     			$this->db->where('a.unit_price <=', '8000');
     		} else if($search_price == 5) {
     			$this->db->where('a.unit_price >=',  '8000');
     			$this->db->where('a.unit_price <=', '10000');
     		} else if($search_price == 6) {
     			$this->db->where('a.unit_price >=',  '10000');
     			$this->db->where('a.unit_price <=', '15000');
     		} else if($search_price == 10) {
     			$this->db->where('a.unit_price >',  '15000');
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
     		$this->db->where_in('a.id', $h_ids);
     	}  
		if($this->input->post('search_feature'))
			$this->db->like('feature', $this->input->post('search_feature'));
		
    	$this->db->where('a.type_id', 1);
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);
    	$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }
    
    public function get_house_rooms($h_id){
    	if(!$h_id)
    		return null;
    	$data = array();
    	$room = $this->db->select('h_id,count(room) count,room')->from('house_hold')->where_in('h_id',$h_id)
    	->group_by('h_id,room')->get()->result_array();
    	foreach ($room as $k=>$v){
    		$data[$v['h_id']][] = $v;
    	}
    	return $data;
    }
    
    public function get_house_news($xq_id){
    	if(!$xq_id)
    		return null;
    	$data = array();
    	$sql = 'SELECT
						*
					FROM
						(
							SELECT
								id,title,xq_id
							FROM
								news
							WHERE
								xq_id IN ('.implode(',', $xq_id).')
							ORDER BY
								xq_id,
								cdate DESC
						) a
					GROUP BY
						xq_id';
    	$query = $this->db->query($sql);
    	$news = $query->result_array();
    	foreach ($news as $k=>$v){
    		$data[$v['xq_id']][] = $v;
    	}
    	return $data;
    }
    
    public function get_search_region_list() {
    	return $this->db->get_where('house_region', array('id >' => 6))->result_array();
    }
    
    public function get_search_style_list() {
    	return $this->db->get_where('house_substyle')->result_array();
    }
}
