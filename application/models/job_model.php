<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
    function mostRepeatedValues($array){
    	if(empty($array) or !is_array($array)){
    		return false;
    	}
    	$array = array_count_values($array);
    	arsort($array);
    	$array = array_slice($array, 0, 1, true);
    	return array_keys($array)[0];
    }
    
    public function match_house($access_token) {
    	header("Content-type: text/html; charset=utf-8");
    	
    	$weixins = $this->db->get('weixin')->result_array();
    	foreach($weixins as $weixin) {
    		
    		$open_id = $weixin['openid'];
    		
    		$this->db->select('b.id, b.region_id, b.total_price, b.substyle_id, b.acreage, b.room, b.feature');
    		$this->db->from('house_track a');
    		$this->db->join('house b', 'a.house_id = b.id', 'left');
    		
    		$house_ids = array();
    		$search_regions = array();
    		$search_styles = array();
    		$search_prices = array();
    		$search_acreages = array();
    		$search_types = array();
    		$search_features = array();
    		$house_tracks = $this->db->where('a.open_id', $open_id)->get()->result_array();
    		
    		if(empty($house_tracks)) return;
    		
    		foreach ($house_tracks as $t) {
    			if(!empty($t['id'])) {
    				$house_ids[] =  $t['id'];
    			}
    			if(!empty($t['region_id'])) {
    				$search_regions[] = $t['region_id'];
    			}
    			if(!empty($t['substyle_id'])) {
    				$search_styles[] = $t['substyle_id'];
    			}
    			if(!empty($t['total_price'])) {
    				$total_price = floatval($t['total_price']);
    				if($total_price <= 50) {
    					$search_prices[] = 1;
    				} else if($total_price <= 80) {
    					$search_prices[] = 2;
    				} else if($total_price <= 100) {
    					$search_prices[] = 3;
    				} else if($total_price <= 120) {
    					$search_prices[] = 4;
    				} else if($total_price <= 150) {
    					$search_prices[] = 5;
    				} else if($total_price <= 200) {
    					$search_prices[] = 6;
    				} else if($total_price <= 250) {
    					$search_prices[] = 7;
    				} else if($total_price <= 300) {
    					$search_prices[] = 8;
    				} else if($total_price <= 500) {
    					$search_prices[] = 9;
    				} else {
    					$search_prices[] = 10;
    				} 
    			}
    			if(!empty($t['acreage'])) {
    				$acreage = floatval($t['acreage']);
    				if($acreage <= 50) {
    					$search_acreages[] = 1;
    				} else if($acreage <= 70) {
    					$search_acreages[] = 2;
    				} else if($acreage <= 90) {
    					$search_acreages[] = 3;
    				} else if($acreage <= 120) {
    					$search_acreages[] = 4;
    				} else if($acreage <= 150) {
    					$search_acreages[] = 5;
    				} else if($acreage <= 200) {
    					$search_acreages[] = 6;
    				} else if($acreage <= 300) {
    					$search_acreages[] = 7;
    				} else {
    					$search_prices[] = 8;
    				}
    			}
    			if(!empty($t['room'])) {
    				$search_types[] = $t['room'];
    			}
    			if(!empty($t['feature'])) {
    				$features = explode(',', $t['feature']);
    				$search_features = array_merge($search_features, $features);
    			}
    		}
    		$search_region = $this->mostRepeatedValues($search_regions);
    		$search_style = $this->mostRepeatedValues($search_styles);
    		$search_price = $this->mostRepeatedValues($search_prices);
    		$search_acreage = $this->mostRepeatedValues($search_acreages);
    		$search_type = $this->mostRepeatedValues($search_types);
    		$search_feature = $this->mostRepeatedValues($search_features);
    		    		
    		$this->db->select('a.*, b.name AS region_name, c.name AS xq_name, c.address AS address ');
    		$this->db->from('house a');
    		$this->db->join('house_region b', 'a.region_id = b.id', 'left');
    		$this->db->join('xiaoqu c', 'a.xq_id = c.id', 'left');
    		if(!empty($search_region)) {
    			$search_region = intval($search_region);
    			if($search_region == 6) {
    				$this->db->where_in('a.region_id', array(1,2,3,4,5,6));
    			} else {
    				$this->db->where('a.region_id', $search_region);
    			}
    		}
    		if(!empty($search_style))
    			$this->db->where('a.substyle_id',$search_style);
    		if(!empty($search_price)){
    			$search_price = intval($search_price);
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
    		if(!empty($search_acreage)) {
    			$search_acreage = intval($search_acreage);
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
	    	if(!empty($search_type)) {
	   			$search_type = intval($search_type);
	   			if($search_type > 5) {
	   				$this->db->where('a.room >', '5');
	   			} else {
	   				$this->db->where('a.room', $search_type);
	   			}
	   		}
    		if(!empty($search_feature))
    			$this->db->like('feature', $search_feature);
 
    		$this->db->where('a.type_id', 2);
    		//$this->db->where_not_in('a.id', $house_ids);
    		$this->db->limit(6);
    		$this->db->order_by('a.id', 'desc');
    		$house_list = $this->db->get()->result_array();

    		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
    		$content = array();
    		$content['touser'] = $open_id;
    		$content['msgtype'] = 'news';
    		$articles = array();
    		$today = date('Y-m-d');
    		foreach ($house_list as $h) {
    			$title = $h['region_name'] . $h['xq_name'] . $h['room'] . '室' . $h['lounge'] . '厅 ' . $h['acreage'] . '㎡' . $h['total_price'] . '万'; 
    			$articles[] = array(
    				'title' => urlencode($title),
    				'url' => 'http://www.funmall.com.cn/b_house/view_detail/' . $h['id'],
    				'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/' . $h['bg_pic']
    			);
    			
    			$this->updateHousePush($open_id, $h['id'], $today);
    		}
    		$content['news'] = array('articles' => $articles);
    		$this->post($url, $content);
    	}
    }
    
    private function updateHousePush($open_id, $house_id, $date) {
    	$this->db->from('house_push');
    	$this->db->where('open_id', $open_id);
    	$this->db->where('house_id', $house_id);
    	$this->db->where('date', $date);
    	$data_house_push = $this->db->get()->row_array();
    	if(empty($data_house_push)) {
    		$data_house_push = array(
    			'open_id' => $open_id,
    			'house_id' => $house_id,
    			'date' => $date
    		);
    		$this->db->insert('house_push', $data_house_push);
    	}
    }
}