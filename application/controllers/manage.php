<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台画面控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		yaobin<645894453@qq.com>
 *
 */
class Manage extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('manage_model');
		$this->load->library('image_lib');
		$this->load->helper('directory');
		$this->load->model('house_model');
		$this->load->model('api_model');
		$this->load->model('job_model');
	}

	function _remap($method,$params = array())
	{
		if(! $this->session->userdata('username'))
		{
			if($this->input->is_ajax_request()){
				header('Content-type: text/json');
				echo '{
                        "statusCode":"301",
                        "message":"\u4f1a\u8bdd\u8d85\u65f6\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55\u3002"
                    }';
			}else{
				redirect(site_url('manage_login/login'));
			}

		}else{
			return call_user_func_array(array($this, $method), $params);
		}
	}

	public function index()
	{
		$this->load->view('manage/index.php');
	}

	private function is_admin() {
		return $this->session->userdata('group_id') == 1 || ($this->session->userdata('group_id') == 2 && $this->session->userdata('manager_group') == 1);
	}
	
	/**
	 *
	 * ***************************************yaobin*******************************************************************
	 */
	public function list_new_house(){
		$data = $this->manage_model->list_new_house();
		$this->load->view('manage/list_new_house.php',$data);
	}
	
	public function add_new_house(){
		$data['feature_list'] = $this->manage_model->get_feature();
		$data['style_list'] = $this->manage_model->get_style_list();
		if(!empty($data['style_list'])) {
			$data['substyle_list'] = $this->manage_model->get_substyle_list_by_parent($data['style_list'][0]->id);
		}
		$data['region_list'] = $this->manage_model->get_region_list();
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$data['orientation_list'] = $this->manage_model->get_orientation_list();
		$this->load->view('manage/add_new_house.php',$data);
	}
	
	public function delete_new_house($id){
		$rs = $this->manage_model->delete_new_house($id);
		if($rs === 1){
			form_submit_json("200", "操作成功", "list_new_house", "", "");
		}else{
			form_submit_json("300", $rs);
		}
	}
	
	//$flag如果存在则是选择户型
	public function add_pics($time,$type_id,$flag=null){
		$data['time'] = $time;
		$data['type_id'] = $type_id;
		$data['flag'] = $flag;
		
		$this->load->view('manage/add_pics.php',$data);
	}
	
	public function save_pics($time,$type_id){
		if (is_readable('./././uploadfiles/pics/'.$time) == false) {
			mkdir('./././uploadfiles/pics/'.$time);
		}
		
		if (is_readable('./././uploadfiles/pics/'.$time.'/'.$type_id) == false) {
			mkdir('./././uploadfiles/pics/'.$time.'/'.$type_id);
		}
	
		$path = './././uploadfiles/pics/'.$time.'/'.$type_id;
	
		//设置缩小图片属性
		$config_small['image_library'] = 'gd2';
		$config_small['create_thumb'] = TRUE;
		$config_small['quality'] = 80;
		$config_small['maintain_ratio'] = TRUE; //保持图片比例
		$config_small['new_image'] = $path;
		$config_small['width'] = 300;
		$config_small['height'] = 190;
	
		//设置原图限制
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
	
		if($this->upload->do_upload()){
			$data = $this->upload->data();//返回上传文件的所有相关信息的数组
			$config_small['source_image'] = $data['full_path']; //文件路径带文件名
			$this->image_lib->initialize($config_small);
			$this->image_lib->resize();
			form_submit_json("200", "操作成功", "");
		}else{
			form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
			exit;
		}
	}
	

	
	//ajax获取图片信息
	public function get_pics($time,$typ_id){
		$path = './././uploadfiles/pics/'.$time.'/'.$typ_id;
		$map = directory_map($path);
		$data = array();
		//整理图片名字，取缩略图片
		foreach($map as $v){
			if(substr(substr($v,0,strrpos($v,'.')),-5) == 'thumb'){
				$data['img'][] = $v;
			}
		}
		$data['time'] = $time;//文件夹名称
		echo json_encode($data);
	}
	
	//ajax删除图片
	public function del_pic($folder,$type_id,$pic,$id=null){
		$data = $this->manage_model->del_pic($folder,$type_id,$pic,$id);
		echo json_encode($data);
	}
	
	//清理不使用的图片数据
	public function clear_pics(){
		$rs = $this->manage_model->clear_pics();
		if($rs === 1){
			form_submit_json("200", "操作成功", "");
		}else{
			form_submit_json("300", $rs);
		}
	}
	
	public function list_xq_dialog(){
		
		$data = $this->manage_model->list_xq_dialog();
		$this->load->view('manage/list_xq_dialog.php', $data);
	}
	
	public function save_new_house(){
		$rs = $this->manage_model->save_new_house();
		if($rs == 1){
			form_submit_json("200", "操作成功", 'list_new_house');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function get_new_house($id){
		$data['main'] = $this->db->select()->from('house')->where('id',$id)->get()->row_array();
		$data['pics'] = $this->db->select()->from('house_img')->where('h_id',$id)->get()->result_array();
		$data['hx_pics'] = $this->db->select()->from('house_hold')->where('h_id',$id)->get()->result_array();
		return $data;
	}
	
	public function edit_new_house($id) {
		$data = $this->manage_model->get_new_house($id);
		$data['feature_list'] = $this->manage_model->get_feature();
		$data['style_list'] = $this->manage_model->get_style_list();
		if(!empty($data['style_id'])) {
			$data['substyle_list'] = $this->manage_model->get_substyle_list_by_parent($data['style_id']);
		}
		$data['region_list'] = $this->manage_model->get_region_list();
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$data['orientation_list'] = $this->manage_model->get_orientation_list();
		$this->load->view('manage/add_new_house.php',$data);
	}
	
	public function upload_pic(){
		$path = './././uploadfiles/others/';
		$path_out = '/uploadfiles/others/';
		$msg = '';
	
		//设置原图限制
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '1000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
	
		if($this->upload->do_upload('filedata')){
			$data = $this->upload->data();
			$targetPath = $path_out.$data['file_name'];
			$msg="{'url':'".$targetPath."','localname':'','id':'1'}";
			$err = '';
		}else{
			$err = $this->upload->display_errors();
		}
		echo "{'err':'".$err."','msg':".$msg."}";
	}
	
	public function list_news(){
		$data = $this->manage_model->list_news();
		$this->load->view('manage/list_news.php',$data);
	}
	
	public function add_news(){
		$this->load->view('manage/add_news.php');
	}
	
	public function delete_news($id){
		$rs = $this->manage_model->delete_news($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function edit_news($id){
		$data = $this->manage_model->get_news($id);
		$this->load->view('manage/add_news.php',$data);
	}
	
	public function save_news(){
		if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
			@unlink('./././uploadfiles/news/'.$this->input->post('old_img'));//del old img
		}else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
			form_submit_json("300", "请添加图片");exit;
		}
	
		if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
			$data = $this->input->post();
			unset($data['ajax']);
			unset($data['old_img']);
			unset($data['xq_name']);
			$rs = $this->manage_model->save_news($data);
		}else{
			$config['upload_path'] = './././uploadfiles/news';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$img_info = $this->upload->data();
				$data = $this->input->post();
				$data['pic'] = $img_info['file_name'];
				unset($data['ajax']);
				unset($data['old_img']);
				unset($data['xq_name']);
				$rs = $this->manage_model->save_news($data);
			}else{
				form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
				exit;
			}
		}
	
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function list_share(){
		$data = $this->manage_model->list_share();
		$this->load->view('manage/list_share.php',$data);
	}
	
	public function add_share(){
		$this->load->view('manage/add_share.php');
	}
	
	public function save_share(){
		$rs = $this->manage_model->save_share();
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_share");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function delete_share($id){
		$rs = $this->manage_model->delete_share($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_share", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function edit_share($id){
		$data = $this->manage_model->get_share($id);
		$this->load->view('manage/edit_share.php',$data);
	}
	
	public function add_share_company($tid,$cid,$pid){
		$rs = $this->manage_model->add_share_company($tid,$cid,$pid);
		if($rs)
			echo '1';
		else
			echo '-1';
	}
	
	public function del_share_company($tid,$cid,$pid){
		$rs = $this->manage_model->del_share_company($tid,$cid,$pid);
		if($rs)
			echo '1';
		else
			echo '-1';
	}
	
	

	/**
	 *
	 * ***************************************shenbin*******************************************************************
	 */
	/**
	 * 二手房管理
	 */
	public function list_broker_dialog(){
	
		$data = $this->manage_model->list_broker_dialog();
		$this->load->view('manage/list_broker_dialog.php', $data);
	}
	
	public function list_sd_house() {
		$data = $this->manage_model->list_sd_house();
		$this->load->view('manage/list_sd_house.php', $data);
	}
	
	public function list_sd_house_dialog($term_id) {
		$data = $this->manage_model->list_sd_house($term_id);
		$data['term_id'] = $term_id;
		$this->load->view('manage/list_sd_house_dialog.php', $data);
	}

	public function list_sd_house_cloud() {
		$data = $this->manage_model->list_sd_house_cloud();
		$this->load->view('manage/list_sd_house_cloud.php', $data);
	}
	
	public function add_sd_house() {
		$data['feature_list'] = $this->manage_model->get_feature();
		$data['style_list'] = $this->manage_model->get_style_list();
		if(!empty($data['style_list'])) {
			$data['substyle_list'] = $this->manage_model->get_substyle_list_by_parent($data['style_list'][0]->id);
		}
		$data['region_list'] = $this->manage_model->get_region_list();
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$data['orientation_list'] = $this->manage_model->get_orientation_list();
		$this->load->view('manage/add_sd_house.php',$data);
	}
	
	public function save_sd_house() {
		$ret = $this->manage_model->save_sd_house();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_sd_house');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_sd_house($id) {
		$data = $this->manage_model->get_sd_house($id);
		$data['house_img'] = $this->manage_model->get_upload_house_img($data['id']);
		$data['feature_list'] = $this->manage_model->get_feature();
		$data['style_list'] = $this->manage_model->get_style_list();
		if(!empty($data['style_id'])) {
			$data['substyle_list'] = $this->manage_model->get_substyle_list_by_parent($data['style_id']);
		}
		$data['region_list'] = $this->manage_model->get_region_list();
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$data['orientation_list'] = $this->manage_model->get_orientation_list();
		$this->load->view('manage/add_sd_house.php',$data);
	}
	
	public function delete_sd_house($id) {
		$ret = $this->manage_model->delete_sd_house($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_sd_house', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}	
	}
	
	/**
	 * 租房管理
	 */
	public function list_rent_house() {
		$data = $this->manage_model->list_rent_house();
		$this->load->view('manage/list_rent_house.php', $data);
	}
	
	public function add_rent_house() {
		$data['feature_list'] = $this->manage_model->get_feature();
		$data['style_list'] = $this->manage_model->get_style_list();
		if(!empty($data['style_list'])) {
			$data['substyle_list'] = $this->manage_model->get_substyle_list_by_parent($data['style_list'][0]->id);
		}
		$data['region_list'] = $this->manage_model->get_region_list();
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$data['orientation_list'] = $this->manage_model->get_orientation_list();
		
		$data['rent_style_list'] = array(
			(object)array('id' => 1, 'name' => '整租'),
			(object)array('id' => 2, 'name' => '合租')
		);
		$data['rent_type_list'] = array(
			(object)array('id' => 1, 'name' => '付三押一'),
			(object)array('id' => 2, 'name' => '付二压一'),
			(object)array('id' => 3, 'name' => '付一压一'),
			(object)array('id' => 4, 'name' => '其他')
		);
		$this->load->view('manage/add_rent_house.php', $data);
	}
	
	public function save_rent_house() {
		$ret = $this->manage_model->save_rent_house();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_rent_house');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_rent_house($id) {
		$data = $this->manage_model->get_rent_house($id);
		$data['house_img'] = $this->manage_model->get_upload_house_img($data['id']);
		$data['feature_list'] = $this->manage_model->get_feature();
		$data['style_list'] = $this->manage_model->get_style_list();
		if(!empty($data['style_id'])) {
			$data['substyle_list'] = $this->manage_model->get_substyle_list_by_parent($data['style_id']);
		}
		$data['region_list'] = $this->manage_model->get_region_list();
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$data['orientation_list'] = $this->manage_model->get_orientation_list();
		
		$data['rent_style_list'] = array(
				(object)array('id' => 1, 'name' => '整租'),
				(object)array('id' => 2, 'name' => '合租')
		);
		$data['rent_type_list'] = array(
				(object)array('id' => 1, 'name' => '付三押一'),
				(object)array('id' => 2, 'name' => '付二压一'),
				(object)array('id' => 3, 'name' => '付一压一'),
				(object)array('id' => 4, 'name' => '其他')
		);
		$this->load->view('manage/add_rent_house.php',$data);
	}
	
	public function delete_rent_house($id) {
		$ret = $this->manage_model->delete_rent_house($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_rent_house', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 经纪人管理
	 */
	public function list_broker() {
		$data = $this->manage_model->list_broker();
		$this->load->view('manage/list_broker.php', $data);
	}
	
	public function add_broker() {
		$data = array();
		$data['region_list'] = $this->manage_model->get_region_list();
		$is_admin = $this->is_admin();
		$data['company_list'] = $this->manage_model->get_company_list($this->session->userdata('group_id') == 1 ? NULL : $this->session->userdata('company_id'));
		if(!empty($data['company_list'])) {
			$data['subsidiary_list'] = $this->manage_model->get_subsidiary_list_by_company($data['company_list'][0]->id, $is_admin ? NULL : $this->session->userdata('subsidiary_id'));
		}
		$data['is_admin'] = $is_admin;
		$this->load->view('manage/add_broker.php', $data);
	}
	
	public function save_broker() {
		
		if(!$this->input->post('id')){
			$tel = $this->input->post('tel');
			$broker = $this->manage_model->get_admin_by_tel($tel);
			if(!empty($broker)) {
				form_submit_json("300", "手机号已经注册过");
				return;
			}
		}
		
		if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
			@unlink('./././uploadfiles/profile/'.$this->input->post('old_img'));//del old img
		}else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
			form_submit_json("300", "请添加图片");exit;
		}
		
		if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
			$ret = $this->manage_model->save_broker();
		}else{
			$config['upload_path'] = './././uploadfiles/profile';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$img_info = $this->upload->data();
				$ret = $this->manage_model->save_broker($img_info['file_name']);
			}else{
				form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
				exit;
			}
		}
		
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_broker');
		} else if($ret == -3){
			form_submit_json("300", "已经超出业务员的数量，保存失败");
		} else if($ret == -2){
			form_submit_json("300", "已经超出可分配二手房的数量，保存失败");
		}else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_broker($id) {
		$data = $this->manage_model->get_broker($id);
		$data['region_list'] = $this->manage_model->get_region_list();
		$is_admin = $this->is_admin();
		$data['company_list'] = $this->manage_model->get_company_list($this->session->userdata('group_id') == 1 ? NULL : $this->session->userdata('company_id'));
		$data['subsidiary_list'] = $this->manage_model->get_subsidiary_list_by_company($data['company_id'], $is_admin ? NULL : $this->session->userdata('subsidiary_id'));
		$data['is_admin'] = $is_admin;
		$this->load->view('manage/add_broker.php', $data);
	}
	
	public function delete_broker($id) {
		$ret = $this->manage_model->delete_broker($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_broker', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	public function get_subsidiary_list($id) {
		$data = $this->manage_model->get_subsidiary_list_by_company($id);
		$subSidiary = array();
		foreach ($data as $s) {
			$subSidiary[] = array($s['id'], $s['name']);
		}
		echo json_encode($subSidiary);
		die;
	}
	
	/**
	 * 房源特色
	 */
	public function list_house_feature() {
		$data = $this->manage_model->list_house_feature();
		$this->load->view('manage/list_house_feature.php', $data);
	}
	
	public function add_house_feature() {
		$this->load->view('manage/add_house_feature.php');
	}
	
	public function save_house_feature() {
		$ret = $this->manage_model->save_house_feature();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house_feature');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house_feature($id) {
		$data = $this->manage_model->get_house_feature($id);
		$this->load->view('manage/add_house_feature.php', $data);
	}
	
	public function delete_house_feature($id) {
		$ret = $this->manage_model->delete_house_feature($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house_feature', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 楼盘类型
	 */
	public function list_house_style() {
		$data = $this->manage_model->list_house_style();
		$this->load->view('manage/list_house_style.php', $data);
	}
	
	public function add_house_style() {
		$this->load->view('manage/add_house_style.php');
	}
	
	public function save_house_style() {
		$ret = $this->manage_model->save_house_style();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house_style');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house_style($id) {
		$data = $this->manage_model->get_house_style($id);
		$this->load->view('manage/add_house_style.php', $data);
	}
	
	public function delete_house_style($id) {
		$ret = $this->manage_model->delete_house_style($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house_style', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 楼盘类型（二级）
	 */
	public function list_house_substyle() {
		$data = $this->manage_model->list_house_substyle();
		$this->load->view('manage/list_house_substyle.php', $data);
	}
	
	public function add_house_substyle() {
		$data = array();
		$data['style_list'] = $this->manage_model->get_style_list();
		$this->load->view('manage/add_house_substyle.php', $data);
	}
	
	public function save_house_substyle() {
		$ret = $this->manage_model->save_house_substyle();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house_substyle');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house_substyle($id) {
		$data = $this->manage_model->get_house_substyle($id);
		$data['style_list'] = $this->manage_model->get_style_list();
		$this->load->view('manage/add_house_substyle.php', $data);
	}
	
	public function delete_house_substyle($id) {
		$ret = $this->manage_model->delete_house_substyle($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house_substyle', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	public function get_substyle_list($id) {
		$data = $this->manage_model->get_substyle_list_by_parent($id);
		$subStyle = array();
		foreach ($data as $s) {
			$subStyle[] = array($s['id'], $s['name']);
		}
		echo json_encode($subStyle);
		die;
	}
	
	/**
	 * 所在区域
	 */
	public function list_house_region() {
		$data = $this->manage_model->list_house_region();
		$this->load->view('manage/list_house_region.php', $data);
	}
	
	public function add_house_region() {
		$this->load->view('manage/add_house_region.php');
	}
	
	public function save_house_region() {
		$ret = $this->manage_model->save_house_region();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house_region');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house_region($id) {
		$data = $this->manage_model->get_house_region($id);
		$this->load->view('manage/add_house_region.php', $data);
	}
	
	public function delete_house_region($id) {
		$ret = $this->manage_model->delete_house_region($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house_region', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 楼盘朝向
	 */
	public function list_house_orientation() {
		$data = $this->manage_model->list_house_orientation();
		$this->load->view('manage/list_house_orientation.php', $data);
	}
	
	public function add_house_orientation() {
		$this->load->view('manage/add_house_orientation.php');
	}
	
	public function save_house_orientation() {
		$ret = $this->manage_model->save_house_orientation();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house_orientation');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house_orientation($id) {
		$data = $this->manage_model->get_house_orientation($id);
		$this->load->view('manage/add_house_orientation.php', $data);
	}
	
	public function delete_house_orientation($id) {
		$ret = $this->manage_model->delete_house_orientation($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house_orientation', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 装修状况
	 */
	public function list_house_decoration() {
		$data = $this->manage_model->list_house_decoration();
		$this->load->view('manage/list_house_decoration.php', $data);
	}
	
	public function add_house_decoration() {
		$this->load->view('manage/add_house_decoration.php');
	}
	
	public function save_house_decoration() {
		$ret = $this->manage_model->save_house_decoration();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house_decoration');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house_decoration($id) {
		$data = $this->manage_model->get_house_decoration($id);
		$this->load->view('manage/add_house_decoration.php', $data);
	}
	
	public function delete_house_decoration($id) {
		$ret = $this->manage_model->delete_house_decoration($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house_decoration', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 小区信息
	 */
	public function list_xiaoqu() {
		$data = $this->manage_model->list_xiaoqu();
		$this->load->view('manage/list_xiaoqu.php', $data);
	}
	
	public function add_xiaoqu() {
		$this->load->view('manage/add_xiaoqu.php');
	}
	
	public function save_xiaoqu() {
		$ret = $this->manage_model->save_xiaoqu();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_xiaoqu');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_xiaoqu($id) {
		$data = $this->manage_model->get_xiaoqu($id);
		$this->load->view('manage/add_xiaoqu.php', $data);
	}
	
	public function delete_xiaoqu($id) {
		$ret = $this->manage_model->delete_xiaoqu($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_xiaoqu', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 公司信息
	 */
	public function list_company() {
		$data = $this->manage_model->list_company();
		$data['is_admin'] = $this->session->userdata('group_id') == 1;
		$this->load->view('manage/list_company.php', $data);
	}
	
	public function add_company() {
		$data['is_admin'] = $this->session->userdata('group_id') == 1;
		$this->load->view('manage/add_company.php', $data);
	}
	
	public function save_company() {
		$ret = $this->manage_model->save_company();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_company');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_company($id) {
		$data = $this->manage_model->get_company($id);
		$data['is_admin'] = $this->session->userdata('group_id') == 1;
		$this->load->view('manage/add_company.php', $data);
	}
	
	public function delete_company($id) {
		$ret = $this->manage_model->delete_company($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_company', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 分店信息
	 */
	public function list_subsidiary($flag=null) {
		$is_admin = $this->is_admin();
		$data = $this->manage_model->list_subsidiary($flag);
		$data['is_admin'] = $is_admin;
		if($flag){
			$data['select'] = $this->manage_model->list_all_company();
			$data['tid'] = $flag;
			$this->load->view('manage/list_subsidiary_dialog.php', $data);
		}else{
			$this->load->view('manage/list_subsidiary.php', $data);
		}
	}
	
	public function add_subsidiary() {
		$data = array();
		$is_admin = $this->is_admin();
		$data['is_admin'] = $is_admin;
		$data['company_list'] = $this->manage_model->get_company_list($this->session->userdata('group_id') == 1 ? NULL : $this->session->userdata('company_id'));
		$this->load->view('manage/add_subsidiary.php', $data);
	}
	
	public function save_subsidiary() {
		$ret = $this->manage_model->save_subsidiary();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_subsidiary');
		} else if($ret == -2){
			form_submit_json("300", "已经超出可添加分店的数量，保存失败");
		} else if($ret == -3){
			form_submit_json("300", "已经超出可分配二手房的数量，保存失败");
		} else if($ret == -4){
			form_submit_json("300", "已经超出可可分配业务员的数量，保存失败");
		}else{
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_subsidiary($id) {
		$data = $this->manage_model->get_subsidiary($id);
		$is_admin = $this->is_admin();
		$data['company_list'] = $this->manage_model->get_company_list($this->session->userdata('group_id') == 1 ? NULL : $this->session->userdata('company_id'));
		$data['is_admin'] = $is_admin;
		$this->load->view('manage/add_subsidiary.php', $data);
	}
	
	public function delete_subsidiary($id) {
		$ret = $this->manage_model->delete_subsidiary($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_subsidiary', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	
	public function list_term(){
		$data = $this->manage_model->list_term();
		$this->load->view('manage/list_term.php',$data);
	}
	
	public function add_term(){
		$this->load->view('manage/add_term.php');
	}
	
	public function delete_term($id){
		$rs = $this->manage_model->delete_term($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_term", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function edit_term($id){
		$data = $this->manage_model->get_term($id);
		$this->load->view('manage/edit_term.php',$data);
	}
	
	public function save_term(){
		if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
			@unlink('./././uploadfiles/term/'.$this->input->post('old_img'));//del old img
		}else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
			form_submit_json("300", "请添加图片");exit;
		}
	
		if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
			$data = $this->input->post();
			unset($data['ajax']);
			unset($data['old_img']);
			$rs = $this->manage_model->save_term($data);
		}else{
			$config['upload_path'] = './././uploadfiles/term';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$img_info = $this->upload->data();
				$data = $this->input->post();
				$data['pic'] = $img_info['file_name'];
				unset($data['ajax']);
				unset($data['old_img']);
				$rs = $this->manage_model->save_term($data);
			}else{
				form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
				exit;
			}
		}
	
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_term");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function add_term_house($term_id,$house_id){
		$rs = $this->manage_model->add_term_house($term_id,$house_id);
		if($rs)
			echo '1';
		else
			echo '-1';
	}

	public function add_cloud_house($house_id){
		$rs = $this->manage_model->add_cloud_house($house_id);
		if($rs)
			echo '1';
		else
			echo '-1';
	}
	
	public function del_cloud_house($house_id){
		$rs = $this->manage_model->del_cloud_house($house_id);
		if($rs)
			echo '1';
		else
			echo '-1';
	}

	public function del_term_house($term_id,$house_id){
		$rs = $this->manage_model->del_term_house($term_id,$house_id);
		if($rs)
			echo '1';
		else
			echo '-1';
	}
	
	public function list_binding(){
		$data = $this->manage_model->list_binding();
		$this->load->view('manage/list_binding.php',$data);
	}
	
	public function delete_binding($id) {
		$rs = $this->manage_model->delete_binding($id);
		if($rs)
			echo '1';
		else
			echo '-1';
	}
	
	public function list_tracking(){
		$data = $this->manage_model->list_tracking();
		$this->load->view('manage/list_tracking.php',$data);
	}
	
	public function delete_tracking($id) {
		$rs = $this->manage_model->delete_tracking($id);
		if($rs)
			echo '1';
		else
			echo '-1';
	}
	
	public function list_article(){
		$data = $this->manage_model->list_article();
		$this->load->view('manage/list_article.php',$data);
	}
	
	public function add_article() {
		$this->load->view('manage/add_article.php');
	}
	
	public function save_article() {
		$ret = $this->manage_model->save_article();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_article');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_article($id) {
		$data = $this->manage_model->get_article($id);
		$this->load->view('manage/add_article.php', $data);
	}
	
	public function delete_article($id) {
		$ret = $this->manage_model->delete_article($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_article', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}

	public function cloud_house(){
		$data['list'] = $this->manage_model->cloud_house();
		$this->load->view('manage/cloud_house.php',$data);
	}
	
	public function list_house_push() {
		$data = $this->manage_model->list_house_push();
		$data['wx_users_list'] = $this->manage_model->list_wx_user();
		$this->load->view('manage/list_house_push.php', $data);
	}
	
	public function list_house_push_dialog() {
		$data = $this->manage_model->list_house_push_dialog();
		$data['region_list'] = $this->house_model->get_m_house_region();
		$data['wx_users_list'] = $this->manage_model->list_wx_user();
		$this->load->view('manage/list_house_push_dialog.php', $data);
	}
	
	public function push_house_to_user() {
		$today = date('Y-m-d');
		$broker_id = $this->session->userdata('user_id');
		
		$open_id = $_POST['open_id'];
		if($open_id == -1) {
			$wx_users_list = $this->manage_model->list_wx_user();
			foreach ($wx_users_list as $wx_user) {
				$open_id = $wx_user['openid'];
				$articles = array();
				$data = $_POST['data'];
				foreach ($data as $h) {
					$articles[] = array(
							'title' => urlencode($h['title']),
							'url' => 'http://www.funmall.com.cn/b_house/view_detail/' . $h['id'],
							'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/' . $h['bg_pic']
					);
					$this->job_model->updateHousePush($open_id, $h['id'], $today, $broker_id);
				}
				$this->api_model->send_message($open_id, $articles);
			}
		} else {
			$articles = array();
			$data = $_POST['data'];
			foreach ($data as $h) {
				$articles[] = array(
						'title' => urlencode($h['title']),
						'url' => 'http://www.funmall.com.cn/b_house/view_detail/' . $h['id'],
						'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/' . $h['bg_pic']
				);
				$this->job_model->updateHousePush($open_id, $h['id'], $today, $broker_id);
			}
			$this->api_model->send_message($open_id, $articles);
		}
		form_submit_json("200", "操作成功", 'list_house_push');
	}
	
	public function list_client_chat() {
		$data = array();
		$data['wx_users_list'] = $this->manage_model->get_bind_wx_users();
		
// 		$user_id = $this->session->userdata('user_id');
// 		$user_info = $this->manage_model->get_user_info($user_id);
// 		if(empty($user_info['pic'])) {
// 			$data['brokerimgurl'] = '/chat/images/touxiang2.jpg';
// 		} else {
// 			$data['brokerimgurl'] = $user_info['pic'];
// 		}
		
		//$brokerimgurl = $this->session->userdata('user_pic');
		//$this->assign('brokerimgurl', $brokerimgurl);
		
		$this->load->view('manage/list_client_chat.php', $data);
	}
	
	public function list_house_tracks($open_id) {
		$house_tracks = $this->manage_model->list_house_tracks($open_id);
		echo json_encode($house_tracks);
	}
}
