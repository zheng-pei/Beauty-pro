<?php
class UserAction extends BaseAction{
	protected function _initialize(){
		parent::_initialize();
		
	}
	public function success($message,$jumpUrl=''){
		$data['errno']=0;
		//$data['tip']=$message;
		$data['error']=$message;
		$data['url']=$jumpUrl;
		echo json_encode($data);
	}
	public function error($message,$jumpUrl=''){
		$data['errno']=1;
		//$data['tip']=$message;
		$data['error']=$message;
		$data['url']=$jumpUrl;
		echo json_encode($data);
	}
	
}
?>