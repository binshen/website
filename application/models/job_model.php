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
    	return array_values($array)[0];
    }
    
    public function match_house() {
    	
    	$weixins = $this->db->get('weixin')->result_array();
    	foreach($weixins as $weixin) {
    		
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
    		$house_tracks = $this->db->where('a.open_id', $weixin['openid'])->get()->result_array();
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

    	}
    }
}