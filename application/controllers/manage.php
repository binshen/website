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

	/**
	 *
	 * ***************************************yaobin*******************************************************************
	 */
	public function list_new_house(){
		$this->load->view('manage/list_new_house.php');
	}
	
	public function add_new_house(){
		$data['feature'] = $this->manage_model->get_feature();
		$this->load->view('manage/add_new_house.php',$data);
	}
	
	public function add_pics($time,$type_id){
		$data['time'] = $time;
		$data['type_id'] = $type_id;
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
		$config_small['width'] = 801;
		$config_small['height'] = 470;
	
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
	

	/**
	 *
	 * ***************************************shenbin*******************************************************************
	 */
	public function list_sd_house() {
		$this->load->view('manage/list_sd_house.php');
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
		$ret = $this->manage_model->save_broker();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_broker');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_broker($id) {
		$data = $this->manage_model->get_broker($id);
		$data['region_list'] = $this->manage_model->get_region_list();
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
}
