<?php
// 服务类别的选择
class ServiceAction extends WxuserAction{
	// 点击对应的项目下的服务列表后进入选择
	public function service(){
		$m=M('Service');
		$map['status']=1;
		$id=$_GET['id'];
		parent::fuwuxqdetail($m,$id);
	}
	
}