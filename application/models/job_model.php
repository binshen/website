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
    
    function mostRepeatedValues($array,$length=0){
    	if(empty($array) or !is_array($array)){
    		return false;
    	}
    	$array = array_count_values($array);
    	arsort($array);
    	if($length>0){
    		$array = array_slice($array, 0, $length, true);
    	}
    	return $array;
    }
    
    public function match_house() {
    	
    	$weixins = $this->db->get('weixin')->result_array();
    	foreach($weixins as $weixin) {
    		
    		$this->db->select('b.id, b.region_id, b.total_price, b.substyle_id, b.acreage, b.room, b.feature');
    		$this->db->from('house_track a');
    		$this->db->join('house b', 'a.house_id = b.id', 'left');
    		
    		$house_ids = array();
    		$search_region = array();
    		$search_style = array();
    		$search_price = array();
    		$search_acreage = array();
    		$search_type = array();
    		$search_feature = array();
    		$house_tracks = $this->db->where('a.open_id', $weixin['openid'])->get()->result_array();
    		var_dump($house_tracks);
    		foreach ($house_tracks as $t) {
    			if(!empty($t['id'])) {
    				$house_ids[] =  $t['id'];
    			}
    			if(!empty($t['region_id'])) {
    				$search_region[] = $t['region_id'];
    			}
    			if(!empty($t['substyle_id'])) {
    				$search_style[] = $t['substyle_id'];
    			}
    			if(!empty($t['total_price'])) {
    				$search_price[] = $t['total_price'];
    			}
    			if(!empty($t['acreage'])) {
    				$search_acreage[] = $t['acreage'];
    			}
    			if(!empty($t['room'])) {
    				$search_type[] = $t['room'];
    			}
    			if(!empty($t['feature'])) {
    				$search_feature[] = $t['feature'];
    			}
    		}
    		var_dump($search_region);
    		var_dump($this->mostRepeatedValues($search_region, 5));
    	}
    	
    	echo "============================";
    }
}