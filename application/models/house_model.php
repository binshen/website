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

    public function get_second_hand_detail($id) {
    	$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
    	$this->db->select('e.rel_name, e.company_name, g.name AS b_region_name, h.name AS decoration_name, d.latitude, d.longitude ');
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

    public function get_user_house_count($user_id) {
    	return $this->db->get_where('house', array('user_id' => $user_id))->num_rows();
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
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
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
     		$this->db->where_in('a.id', $h_ids?$h_ids:'');
     	}
     	if($this->input->post('search_feature'))
     		$this->db->like('a.feature', $this->input->post('search_feature'));
     	if($this->input->post('search_text')) {
     		$t = $this->input->post('search_text');
     		$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%')";
     		$this->db->where($where);
     	}
    	$this->db->where('type_id', 1);
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;

    	$data['rel_name'] = null;
    	//list
    	$this->db->select('a.*, b.name AS region_name, c.name AS xq_name, c.address AS address ');
    	$this->db->from('house a');
    	$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    	$this->db->join('xiaoqu c', 'a.xq_id = c.id', 'left');
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
     		$this->db->where_in('a.id', $h_ids?$h_ids:'');
     	}
		if($this->input->post('search_feature'))
			$this->db->like('feature', $this->input->post('search_feature'));

		if($this->input->post('search_text')) {
			$t = $this->input->post('search_text');
			$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%')";
			$this->db->where($where);
		}

    	$this->db->where('a.type_id', 1);
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);

    	$orderField = $this->input->post('search_order');
    	if($orderField == 1) {
    		$orderDirection = $this->input->post('order_price_dir');
    		if($orderDirection == 1) {
    			$this->db->order_by('a.unit_price', 'desc');
    		} else {
    			$this->db->order_by('a.unit_price', 'asc');
    		}
    	} else {
    		$this->db->order_by('a.id', 'desc');
    	}
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }

    public function get_second_hand_house_pics($id){
    	return $this->db->select()->from('house_img')->where('h_id',$id)->order_by('id','desc')->get()->result_array();
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

    public function get_house_news_row($xq_id){
    	$data = $this->db->select()->from('news')->where('xq_id',$xq_id)->order_by('cdate','desc')->get()->row_array();
    	if($data){
    		$data['content'] = mb_substr(strip_tags(str_replace(' ','',$data['content'])),0,160,'utf-8');
    		return $data;
    	}else{
    		return null;
    	}
    }

    public function get_new_house_detail($id){
    	$this->db->select('a.*,b.name decoration_name,c.name substyle_name,d.name region_name,e.name xq_name,e.latitude,e.longitude');
    	$this->db->from('house a');
    	$this->db->join('house_decoration b','a.decoration_id=b.id','left');
    	$this->db->join('house_substyle c','a.substyle_id=c.id','left');
    	$this->db->join('house_region d','a.region_id=d.id','left');
    	$this->db->join('xiaoqu e','a.xq_id=e.id','left');
    	$this->db->where('a.id',$id);
    	return $this->db->get()->row_array();
    }

    public function get_search_region_list() {
    	return $this->db->get_where('house_region', array('id >' => 6))->result_array();
    }

    public function get_search_style_list() {
    	return $this->db->get_where('house_substyle')->result_array();
    }

    public function get_new_house_pics($id){
    	$data = array();
    	$rs = $this->db->select()->from('house_img')->where('h_id',$id)->order_by('type_id','acs')->get()->result_array();
    	foreach($rs as $v){
    		$data[$v['type_id']][] = $v;
    	}
    	return $data;
    }

   	public function get_new_house_huxing($id){
   		$this->db->select('a.*,b.name orientation_name')->from('house_hold a');
   		$this->db->join('house_orientation b','a.orientation_id=b.id','left');
   		$this->db->where('h_id',$id);
   		$this->db->limit(3,0);
   		return $this->db->get()->result_array();
   	}

   	public function get_new_house_price($id,$region_id,$substyle_id){
   		$data['own_price'] = $this->db->select()->from('price_trend')->where('h_id',$id)->order_by('month','acs')->limit(12,0)->get()->result_array();
   		$months = array();
   		foreach($data['own_price'] as $v){
   			$months[] = $v['month'];
   		}
   		$data['avg_price'] = $this->db->select('CAST(avg(price) as SIGNED) price,month')->from('price_trend')
   			->where_in('month',$months)->where('region_id',$region_id)->where('substyle_id',$substyle_id)
   			->group_by('month')
   			->order_by('month','acs')
   			->get()->result_array();

   		$count_own = count($data['own_price']);
   		$count_avg = count($data['avg_price']);
   		if($count_own > 2){
   			$own_price = $data['own_price'][$count_own-1]['price'];
   			$own_prev_price = $data['own_price'][$count_own-2]['price'];
   			$own_proportion = round(($own_price-$own_prev_price)/$own_prev_price*100,2);
   		}else{
   			$own_proportion = '';
   		}

   		if($count_avg > 2){
   			$avg_price = $data['avg_price'][$count_avg-1]['price'];
   			$avg_prev_price = $data['avg_price'][$count_avg-2]['price'];
   			$avg_proportion = round(($avg_price-$avg_prev_price)/$avg_prev_price*100,2);
   		}else{
   			$avg_proportion = '';
   		}
   		$data['own_proportion'] = $own_proportion;
   		$data['avg_proportion'] = $avg_proportion;


   		return $data;
   	}

   	public function get_article_list($id){

   		$rs = $this->db->select('a.id,xq_id,b.name region_name,a.name,region_id')->from('house a')->join('house_region b','a.region_id=b.id','left')->where('a.id',$id)->get()->row_array();
   		$data['tag'] = $rs;
   		$data['list'] = $this->db->select()->from('news')->where('xq_id',$rs['xq_id'])->order_by('cdate','desc')->get()->result_array();
   		foreach($data['list'] as $k=>$v){
   			$data['list'][$k]['content'] = mb_substr(strip_tags(str_replace(' ','',$v['content'])),0,85,'utf-8');
   		}
   		return $data;
   	}

   	public function get_article_detail($h_id,$id,$flag){
   		if($flag){
   			$rs = $this->db->select('id')->from('house')->where('xq_id',$h_id)->get()->row();
   			if($rs){
   				$h_id = $rs->id;
   				$data['tag'] = $this->db->select('a.id,xq_id,b.name region_name,a.name,region_id')->from('house a')->join('house_region b','a.region_id=b.id','left')->where('a.id',$h_id)->get()->row_array();
   			}else{
   				$data['tag'] = '';
   			}

   		}else{
   			$data['tag'] = $this->db->select('a.id,xq_id,b.name region_name,a.name,region_id')->from('house a')->join('house_region b','a.region_id=b.id','left')->where('a.id',$h_id)->get()->row_array();
   		}


   		$data['detail'] = $this->db->select()->from('news')->where('id',$id)->get()->row_array();
   		return $data;
   	}

   	public function get_huxing_list($h_id,$count,$pageNum){
   		$rs = $this->db->select('a.id,xq_id,b.name region_name,a.name,region_id,count(c.id) count_huxing')->from('house a')
   		->join('house_region b','a.region_id=b.id','left')
   		->join('house_hold c','a.id=c.h_id','left')
   		->where('a.id',$h_id)
   		->group_by('c.h_id')
   		->get()->row_array();
   		$data['tag'] = $rs;
   		$rs = $this->db->select('folder')->from('house')->where('id',$h_id)->get()->row();
   		$data['folder'] = $rs->folder;

   		// 每页显示的记录条数，默认20条
   		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 9;
   		//$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

   		//获得总记录数
   		$this->db->select('count(1) as num');
   		$this->db->from('house_hold');
   		$this->db->where('h_id', $h_id);
   		if($count != 'all'){
   			$this->db->where('room',$count);
   		}

   		$rs_total = $this->db->get()->row();
   		//总记录数
   		$data['countPage'] = $rs_total->num;
   		$data['count'] = $count;
   		//list
   		$this->db->select();
   		$this->db->from('house_hold');
   		$this->db->where('h_id', $h_id);
   		if($count != 'all'){
   			$this->db->where('room',$count);
   		}
   		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);
   		$data['res_list'] = $this->db->get()->result();
   		$data['pageNum'] = $pageNum;
   		$data['numPerPage'] = $numPerPage;
   		return $data;
   	}


   	public function get_recommend_list(){
   		$this->db->select('a.name name,unit_price,a.id id,feature,bg_pic,b.name region_name')->from('house a');
   		$this->db->join('house_region b','a.region_id=b.id','left')->where('recommend','1')->limit(4,0);
   		return $this->db->get()->result_array();
   	}

   	/**
   	 * 租房
   	 */
   	public function get_rent_house_list() {
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
   		if($this->input->post('search_feature')) {
   			$this->db->like('a.feature', $this->input->post('search_feature'));
   		}
   		if($this->input->post('search_rent_style')){
   			$this->db->where('a.rent_style_id', $this->input->post('search_rent_style'));
   		}
   		if($this->input->post('search_text')) {
   			$t = $this->input->post('search_text');
   			$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%' OR c.name LIKE '%" . $t . "%' OR d.name LIKE '%" . $t . "%')";
   			$this->db->where($where);
   		}
   		$this->db->where('a.type_id', 3);

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
   		if($this->input->post('search_feature')) {
   			$this->db->like('feature', $this->input->post('search_feature'));
   		}
   		if($this->input->post('search_rent_style')){
   			$this->db->where('a.rent_style_id', $this->input->post('search_rent_style'));
   		}
   		if($this->input->post('search_text')) {
   			$t = $this->input->post('search_text');
   			$where = "(a.name LIKE '%" . $t . "%' OR a.sub_title LIKE '%" . $t . "%' OR b.name LIKE '%" . $t . "%' OR c.name LIKE '%" . $t . "%' OR d.name LIKE '%" . $t . "%')";
   			$this->db->where($where);
   		}
   		$this->db->where('a.type_id', 3);
   		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);

   		$orderField = $this->input->post('search_order');
   		if($orderField == 1) {
   			$orderDirection = $this->input->post('order_price_dir');
   			if($orderDirection == 1) {
   				$this->db->order_by('a.unit_price', 'desc');
   			} else {
   				$this->db->order_by('a.unit_price', 'asc');
   			}
   		} else {
   			$this->db->order_by('a.id', 'desc');
   		}

   		$data['res_list'] = $this->db->get()->result();
   		$data['pageNum'] = $pageNum;
   		$data['numPerPage'] = $numPerPage;
   		return $data;
   	}

   	public function get_rent_house_detail($id) {
   		$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
   		$this->db->select('e.rel_name, e.company_name, g.name AS b_region_name, h.name AS decoration_name, d.latitude, d.longitude ');
   		$this->db->from('house a');
   		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
   		$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
   		$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
   		$this->db->join('admin e', 'a.broker_id = e.id', 'left');
   		$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
   		$this->db->join('house_region g', 'e.region_id = g.id', 'left');
   		$this->db->join('house_decoration h', 'a.decoration_id = h.id', 'left');
   		$this->db->where('a.type_id', 3);
   		return $this->db->where('a.id', $id)->get()->row_array();
   	}

   	public function get_recommended_house_list($type_id){
   		$this->db->select('a.name, a.total_price, a.unit_price, a.id, a.feature, a.bg_pic, a.acreage, a.room, a.lounge, b.name AS region_name, c.name AS xq_name');
   		$this->db->from('house a');
   		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
   		$this->db->join('xiaoqu c', 'a.xq_id = c.id', 'left');
   		$this->db->where('type_id', $type_id);
   		$this->db->where('recommend', '1');
   		$this->db->limit(4,0);
   		return $this->db->get()->result_array();
   	}

	public function list_xiaoqu() {
		return $this->db->select('id,name')->from('xiaoqu')->get()->result_array();
	}

	public function save_publish() {

		$type_id = $this->input->post('type_id');
		$data = array(
			'name' => $this->input->post('name'),
			'sub_title' => $this->input->post('sub_title'),
			'type_id' => $type_id,
			'xq_id' => $this->input->post('xq_id'),
			'region_id' => $this->input->post('region_id'),
			'style_id' => $this->input->post('style_id'),
			'substyle_id' => $this->input->post('substyle_id'),
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
			'description' => $this->input->post('description'),
			'folder' => $this->input->post('folder'),
			'bg_pic' => $this->input->post('is_bg'),
			'user_name' => $this->input->post('user_name'),
			'user_tel' => $this->input->post('user_tel'),
			'user_id' => $this->session->userdata('member_id')
		);

		if($type_id == 2) {
			$data['total_price'] = $this->input->post('total_price');
		} else {
			$data['unit_price'] = $this->input->post('unit_price');
			$data['rent_style_id'] = $this->input->post('rent_style_id');
		}

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
		$pic_short = $this->input->post('pic_short');
		foreach ($pic_short as $idx => $pic) {
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_m_index() {
		return $this->db->order_by('is_top', 'desc')->get('term')->result_array();
	}

	public function get_m_house_region() {
		return $this->db->get('house_region')->result_array();
	}

	public function get_m_house_list($term_id, $pageNum) {
		// 每页显示的记录条数，默认10条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 10;
		//$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		if($term_id > 0) {
			$this->db->from('term t1');
			$this->db->join('term_house t2', 't2.term_id = t1.id', 'inner');
			$this->db->join('house a', 't2.house_id = a.id', 'inner');
		} else {
			$this->db->from('house a');
		}
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
		$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
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
			$this->db->like('a.feature', $this->input->post('search_feature'));
		if($term_id > 0) {
			$this->db->where('t1.id', $term_id);
		}
		$this->db->where('a.type_id >', 1);
		$this->db->where('a.exe_status', 1);

		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		$data['rel_name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, f.name AS style_name');
		if($term_id > 0) {
			$this->db->from('term t1');
			$this->db->join('term_house t2', 't2.term_id = t1.id', 'inner');
			$this->db->join('house a', 't2.house_id = a.id', 'inner');
		} else {
			$this->db->from('house a');
		}
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
		$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
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
			$this->db->like('a.feature', $this->input->post('search_feature'));
		if($term_id > 0) {
			$this->db->where('t1.id', $term_id);
		}
		$this->db->where('a.type_id >', 1);
		$this->db->where('a.exe_status', 1);
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);

		$orderField = $this->input->post('search_order');
		$this->db->order_by('a.refresh_time', 'desc');
		$this->db->order_by('a.id', 'desc');

		$data['res_list'] = $this->db->get()->result_array();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function get_m_house_detail($hid) {
		$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.tel AS tel, f.name AS style_name');
		$this->db->select('e.rel_name, e.company_name, g.name AS b_region_name, h.name AS decoration_name, d.latitude, d.longitude ');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
		$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
		$this->db->join('admin e', 'a.broker_id = e.id', 'left');
		$this->db->join('house_substyle f', 'a.substyle_id = f.id', 'left');
		$this->db->join('house_region g', 'e.region_id = g.id', 'left');
		$this->db->join('house_decoration h', 'a.decoration_id = h.id', 'left');
		//$this->db->where('a.type_id', 2);
		return $this->db->where('a.id', $hid)->get()->row_array();
	}

	public function get_m_term($id) {
		return $this->db->get_where('term', array('id' => $id))->row_array();
	}

	public function collect_house($uid, $hid) {
		$collected = $this->check_collect_house($uid, $hid);
		if(!$collected) {
			$data = array();
			$data['user_id'] = $uid;
			$data['house_id'] = $hid;
			return $this->db->insert('house_collect', $data);
		} else {
			return false;
		}
	}

	public function check_collect_house($uid, $hid) {
		$collect = $this->db->get_where('house_collect', array('user_id' => $uid, 'house_id' => $hid))->row_array();
		return empty($collect)?false:true;
	}

	public function get_broker_by_id($id) {
		$this->db->select('a.id, a.rel_name, a.tel, a.pic, a.ticket, b.name AS company_name, c.name AS subsidiary_name');
		$this->db->from('admin a');
		$this->db->join('company b', 'a.company_id = b.id', 'left');
		$this->db->join('subsidiary c', 'a.subsidiary_id = c.id', 'left');
		return $this->db->where('a.id', $id)->get()->row_array();
	}

	public function get_company_by_broker($b_id) {
		$this->db->select('b.*');
		$this->db->from('admin a');
		$this->db->join('company b', 'a.company_id = b.id', 'left');
		return $this->db->where('a.id', $b_id)->get()->row_array();
	}

	public function get_b_all_house_list($pageNum) {
		// 每页显示的记录条数，默认10条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 10;
		//$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
		$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.decoration_id = e.id', 'left');
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
			$this->db->like('a.feature', $this->input->post('search_feature'));
		$this->db->where('a.type_id', 2);
		$this->db->where('a.exe_status', 1);

		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		$data['rel_name'] = null;
		//list
		$this->db->select('a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.name AS decoration_name, f.name AS style_name');
		$this->db->from('house a');
		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
		$this->db->join('house_orientation c', 'a.orientation_id = c.id', 'left');
		$this->db->join('xiaoqu d', 'a.xq_id = d.id', 'left');
		$this->db->join('house_decoration e', 'a.decoration_id = e.id', 'left');
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
			$this->db->like('a.feature', $this->input->post('search_feature'));
		$this->db->where('a.type_id', 2);
		$this->db->where('a.exe_status', 1);
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage);

		$orderField = $this->input->post('search_order');
		$this->db->order_by('a.refresh_time', 'desc');
		$this->db->order_by('a.id', 'desc');

		$data['res_list'] = $this->db->get()->result_array();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function get_b_broker_house_list($broker_id, $pageNum) {
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 10;
		$rs = $this->db->select('subsidiary_id')->from('admin')->where('id',$broker_id)->get()->row();
		$cid = $rs->subsidiary_id;
		$limit_num = ($pageNum - 1) * $numPerPage;

		$sql_broker = "SELECT
											id
										FROM
											admin
										WHERE
											subsidiary_id IN (
												SELECT DISTINCT
													(cid) cid
												FROM
													share_company
												WHERE
													tid IN (
														SELECT DISTINCT
															(tid)
														FROM
															share_company
														WHERE
															cid = '{$cid}'
													)
											)";

		$query_broker = $this->db->query($sql_broker);
		$broker_arr = $query_broker->result_array();

		$brokers = array();

		foreach($broker_arr as $k=>$v){
			$brokers[] = $v['id'];
		}

		if(!$brokers){
			$rs = $this->db->select('id')->from('admin')->where('subsidiary_id',$cid)->get()->result_array();
			foreach($rs as $k=>$v){
				$brokers[] = $v['id'];
			}
		}

		$brokers_str = implode(',',$brokers);

		$rs = $this->db->select('company_id pid')->from('subsidiary')->where('id',$cid)->get()->row();
		$pid = $rs->pid;

		$order = array();

		$order[] = $broker_id;

		$rs = $this->db->select('id')->from('admin')->where('subsidiary_id',$cid)->get()->result_array();
		foreach($rs as $k=>$v){
			$order[] = $v['id'];
		}

		$rs = $this->db->select('a.id id')->from('admin a')->join('subsidiary b','a.subsidiary_id = b.id','left')->where('b.company_id',$pid)
					->where('a.id !=',$broker_id)->where('a.subsidiary_id !=',$cid)->where_in('a.id',$brokers)->get()->result_array();

		foreach($rs as $k=>$v){
			$order[] = $v['id'];
		}

		$rs = $this->db->select('a.id id')->from('admin a')->join('subsidiary b','a.subsidiary_id = b.id','left')
					->where('b.company_id !=',$pid)->where_in('a.id',$brokers)->get()->result_array();

		foreach($rs as $k=>$v){
			$order[] = $v['id'];
		}


		$locate = implode(',',$order);
		$where = '';

		if($this->input->post('search_region')) {
			$search_region = intval($this->input->post('search_region'));

			if($search_region == 6) {
				$this->db->where_in('a.region_id', array(1,2,3,4,5,6));
				$where .= ' and a.region_id in (1,2,3,4,5,6)';
			} else {
				$where .= " and a.region_id = {$search_region}";
			}
		}
		if($this->input->post('search_style'))
			$where .= " and a.substyle_id = {$this->input->post('search_style')}";
		if($this->input->post('search_price')){
			$search_price = intval($this->input->post('search_price'));
			if($search_price == 1) {
				$where .= " and a.total_price <= 50";
			} else if($search_price == 2) {
				$where .= " and a.total_price > 50 and a.total_price <= 80";
			} else if($search_price == 3) {
				$where .= " and a.total_price > 80 and a.total_price <= 100";
			} else if($search_price == 4) {
				$where .= " and a.total_price > 100 and a.total_price <= 120";
			} else if($search_price == 5) {
				$where .= " and a.total_price > 120 and a.total_price <= 150";
			} else if($search_price == 6) {
				$where .= " and a.total_price > 150 and a.total_price <= 200";
			} else if($search_price == 7) {
				$where .= " and a.total_price > 200 and a.total_price <= 250";
			} else if($search_price == 8) {
				$where .= " and a.total_price > 250 and a.total_price <= 300";
			} else if($search_price == 9) {
				$where .= " and a.total_price > 300 and a.total_price <= 500";
			} else if($search_price == 10) {
				$where .= " and a.total_price > 500";
			}
		}
		if($this->input->post('search_acreage')) {
			$search_acreage = intval($this->input->post('search_acreage'));
			if($search_acreage == 1) {
				$where .= " and a.acreage <= 50";
			} else if($search_acreage == 2) {
				$where .= " and a.acreage > 50 and a.acreage <= 70";
			} else if($search_acreage == 3) {
				$where .= " and a.acreage > 70 and a.acreage <= 90";
			} else if($search_acreage == 4) {
				$where .= " and a.acreage > 90 and a.acreage <= 120";
			} else if($search_acreage == 5) {
				$where .= " and a.acreage > 120 and a.acreage <= 150";
			} else if($search_acreage == 6) {
				$where .= " and a.acreage > 150 and a.acreage <= 200";
			} else if($search_acreage == 7) {
				$where .= " and a.acreage > 200 and a.acreage <= 300";
			} else if($search_acreage == 8) {
				$this->db->where('a.acreage >',  '300');
				$where .= " and a.acreage > 300";
			}
		}
		if($this->input->post('search_type')) {
			$search_type = intval($this->input->post('search_type'));
			if($search_type > 5) {
				$where .= " and a.room > 5";
			} else {
				$where .= " and a.room = {$search_type}";
			}
		}
		if($this->input->post('search_feature'))
			$where .= " and a.feature like '%{$this->input->post('search_feature')}%'";
		$sql_count = "select count(1) num from(
							(SELECT
									a.id id
								FROM
									house a
								WHERE
									a.broker_id IN ({$brokers_str}) and a.type_id > 1 and a.exe_status = 1 {$where})

							UNION(
								select hid id from cloud_house
							)
						) aa";

		$query_count = $this->db->query($sql_count);
		$rs_count = $query_count->row();
		$data['countPage'] = $rs_count->num;
		$data['rel_name'] = null;
		$sql = "select * from
							(
							(SELECT
								a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.name AS decoration_name, f.name AS style_name
							FROM
								house a
							LEFT JOIN house_region b ON a.region_id = b.id
							LEFT JOIN house_orientation c ON a.orientation_id = c.id
							LEFT JOIN xiaoqu d ON a.xq_id = d.id
							LEFT JOIN house_decoration e ON a.decoration_id = e.id
							LEFT JOIN house_substyle f ON a.substyle_id = f.id
							WHERE
								a.broker_id IN ({$brokers_str})
							and a.type_id > 1 and a.exe_status = 1 {$where} order by locate(a.broker_id,'{$locate}'),refresh_time desc,id desc)

							UNION (
						 	SELECT
								a.*, b.name AS region_name, c.name AS orientation_name, d.name AS xq_name, d.address AS address, e.name AS decoration_name, f.name AS style_name
							FROM
								house a
							LEFT JOIN house_region b ON a.region_id = b.id
							LEFT JOIN house_orientation c ON a.orientation_id = c.id
							LEFT JOIN xiaoqu d ON a.xq_id = d.id
							LEFT JOIN house_decoration e ON a.decoration_id = e.id
							LEFT JOIN house_substyle f ON a.substyle_id = f.id
							WHERE
								a.id IN (SELECT ch.hid from cloud_house ch) {$where}
							and a.type_id > 1 and a.exe_status = 1 order by refresh_time desc,id desc
							)
							 ) aa limit {$limit_num},{$numPerPage};";
		$query = $this->db->query($sql);
		$data['res_list'] = $query->result_array();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;

	}

	public function track_house($open_id, $house_id) {
		$this->db->from('house_track');
		$this->db->where('open_id', $open_id);
		$this->db->where('house_id', $house_id);
		$track_data = $this->db->get()->row_array();
		if(empty($track_data) && $house_id > 0) {
			$this->db->query("INSERT INTO house_track (open_id, house_id, date) VALUES('{$open_id}', '{$house_id}', '".date('Y-m-d H:i:s')."')");
		}
	}

	public function get_connected_brokers($open_id) {
		$this->db->select('a.*, b.rel_name, b.tel, c.address');
		$this->db->from('wx_user a');
		$this->db->join('admin b', 'a.broker_id = b.id');
		$this->db->join('company c', 'b.company_id = c.id');
		$this->db->where('a.open_id', $open_id);
		$this->db->order_by('a.updated DESC');
		return $this->db->get()->result_array();
	}

	public function choose_broker($id) {
		$this->db->select('a.*, b.rel_name');
		$this->db->from('wx_user a');
		$this->db->join('admin b', 'a.broker_id = b.id');
		$this->db->where('a.id', $id);
		$wx_user = $this->db->get()->row_array();
		if(!empty($wx_user)) {
			$this->db->where('id', $id);
			$this->db->update('wx_user', array('updated'=>date("Y-m-d H:i:s")));
		}
		return $wx_user;
	}

	public function get_article($broker_id) {
		$this->db->select('a.*, b.rel_name');
		$this->db->from('article a');
		$this->db->join('admin b', 'a.broker_id = b.id');
		$this->db->order_by('updated DESC');
		if(!empty($broker_id)) {
			$this->db->where('broker_id', $broker_id);
		}
		$result = $this->db->get()->row_array();
		if(empty($result)) {
			$this->db->select('a.*, b.rel_name');
			$this->db->from('article a');
			$this->db->join('admin b', 'a.broker_id = b.id');
			$this->db->order_by('force_show DESC, updated DESC');
			$result = $this->db->get()->row_array();
		}
		return $result;
	}
}
