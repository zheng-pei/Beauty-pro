<?php

class MeirongshiAction extends WxuserAction{
	// 美容师列表页面显示
	public function meilists(){
		$m=M('Beautician');
		$map['sk_beautician.areaid']=$_SESSION['areaid'];
		$map['sk_beautician.status']=1;
		$res=$m->where($map)->field('sk_beautician.id,sk_beautician.name,sk_beautician.comment,pic,tech,att,lab,manner,isrecom,address')->order('isrecom desc')->join('sk_business on sk_business.id=sk_beautician.bsid')->limit(0,6)->select();
		// 获取美容师的服务的标签，用逗号分隔
		foreach ($res as $key => $value) {
			$value['labname']=explode(',',$value['lab']);
			$res[$key]=$value;
		}
		$this->assign('res',$res);
		$this->assign('webtitle','美容师列表');
		$this->display();
	}
	//加载更多
	public function loadmore(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$m=M('Beautician');
		$map['sk_beautician.areaid']=$_SESSION['areaid'];
		$map['sk_beautician.status']=1;
		$data=$m->where($map)->field('sk_beautician.id,sk_beautician.name,sk_beautician.comment,pic,tech,att,lab,manner,isrecom,address')->order('isrecom desc')->join('sk_business on sk_business.id=sk_beautician.bsid')->limit(($p * 3).',3')->select();
		foreach ($data as $key => $value) {
			$value['labname']=explode(',',$value['lab']);
			$data[$key]=$value;
		}
		echo json_encode($data);		
	}

	// 美容师的项目中心，先选美容师，再选项目，直接进入填写订单页面----------分页有问题
	public function meirongshixm(){
		$m=M('Beautician');
		if(!empty($_GET['id'])){
			$map['id']=$_GET['id'];
			$this->assign('beautyid',$_GET['id']);
			$res=$m->where($map)->find();
			if($res){
				$this->assign('res',$res);
				$where['sk_service.id']=array('in',$res['serviceid']);
				$lists=M('Service')->field('sk_service.id serviceid,classid,classname,smallpic,name,isrecom,appuser,servicetime,origprice,trueprice')->where($where)->join('sk_servicetype on sk_servicetype.id=sk_service.classid')->order('isrecom desc,classid desc')->limit(0,6)->select();
				if($lists){
					$this->assign('lists',$lists);
				}else{
					$this->assign('lists','');
				}
				$this->assign('webtitle','美容师中心');
				$this->display();		
			}
		}
	}
	// 美容师的项目中心的加载更多
	public function xmload(){
		$map['id']=$_POST['id'];
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$serviceid=M('Beautician')->where($map)->getField('serviceid');
		$where['sk_service.id']=array('in',$serviceid);
		$lists=M('Service')->field('sk_service.id serviceid,classid,classname,smallpic,name,isrecom,appuser,servicetime,origprice,trueprice')->where($where)->join('sk_servicetype on sk_servicetype.id=sk_service.classid')->order('isrecom desc,classid desc')->limit(($p * 3 ).',3')->select();	
		echo json_encode($lists);
																
	}
	

	// 点击对应美容师的服务列表进入服务项目
	Public function fuwuxq(){
		$m=M('Service');
		$map['status']=1;
		$id=$_GET['serviceid'];
		$beautyid=$_GET['beautyid'];
		$this->assign('beautyid',$_GET['beautyid']);
		parent::fuwuxqdetail($m,$id);
	}

//  美容师中心的公共导航
	public function meirongshinav(){
		$map['id']=$_GET['id'];
		$res=M('Beautician')->field('id,comment,pic,name,tech,att,manner')->where($map)->find();
		if($res){
			$this->assign('res',$res);
		}
	}
	// 显示美容师的简介
	public function meirongshijj(){
		$this->meirongshinav();
		$this->assign('webtitle','美容师简介');
		$this->display();
	}
	// 显示美容师的评价列表
	public function meirongshipj(){	
		//  美容师中心的公共导航
		$this->meirongshinav();
		// 美容师的评价列表
		$where['beautyid']=$_GET['id'];
		$commentlists=M('Beautyreview')->field('nickname,tech,att,manner,comment,sk_beautyreview.createtime')->where($where)->join('sk_member on sk_member.id=sk_beautyreview.memberid')->limit(0,6)->select();
		if($commentlists){
			$this->assign('commentlists',$commentlists);
		}else{
			$this->assign('commentlists','');
		}
		$this->assign('bid',$_GET['id']);
		$this->assign('webtitle','美容师评价');
		$this->display();
	}
	public function loadpjlists(){
		//  美容师中心的公共导航
		// $this->meirongshinav();
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		// 美容师的评价列表
		$where['beautyid']=$_POST['beautyid'];
		$lists=M('Beautyreview')->field('nickname,tech,att,manner,comment,sk_beautyreview.createtime')->where($where)->join('sk_member on sk_member.id=sk_beautyreview.memberid')->limit(($p * 3 ).',3')->select();
		echo json_encode($lists);	
	}

// 在填写订单页面选择美容师
	public function choosemrs(){
		$serviceid=$_GET['serviceid'];
		$beautyid=$this->choosemrscom($serviceid);
		if($beautyid){
			$map1['sk_beautician.id']=array('in',$beautyid);
			// 找到第一个元素的id分配给页面,用于给第一个元素添加选中样式
			$firstres= M('Beautician')->where($map1)->order('isrecom desc,sk_beautician.id desc')->limit(1)->find();
			$this->assign('firstid',$firstres['id']);
			$res=M('Beautician')->where($map1)->field('sk_beautician.id,sk_beautician.name,serviceid,sk_beautician.comment,pic,tech,att,lab,manner,isrecom,address')->order('isrecom desc,sk_beautician.id desc')->join('sk_business on sk_business.id=sk_beautician.bsid')->limit(0,6)->select();
			// 获取美容师的服务的标签，用逗号分隔
			foreach ($res as $key => $value) {
				$value['labname']=explode(',',$value['lab']);
				$res[$key]=$value;
			}
			$this->assign('res',$res);
		}
		
		$this->assign('serviceid',$_GET['serviceid']);
		$this->assign('classid',$_GET['classid']);
		$this->assign('webtitle','选择美容师页面');
		$this->display();
	}
	public function choosemrscom($serviceid){
		$m=M('Beautician');
		$map['sk_beautician.areaid']=$_SESSION['areaid'];
		$map['sk_beautician.status']=1;
		$beautyid=array();
		$new=array();
		$beauty=$m->where($map)->select();
		foreach ($beauty as $key => $value) {
			// dump($value['serviceid']);
			$new = explode(",",$value['serviceid']);
			if(in_array($serviceid,$new)){
				$beautyid[]=$value['id'];			
			}
		}
		return $beautyid;		
	}
	// 在填写订单页面选择美容师加载更多
	public function loadchoosemrs(){
		$serviceid=$_POST['serviceid'];
		$beautyid=$this->choosemrscom($serviceid);
		// dump($beautyid);
		$map2['sk_beautician.id']=array('in',$beautyid);
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$data=M('Beautician')->where($map2)->field('sk_beautician.id,sk_beautician.name,sk_beautician.comment,pic,tech,att,lab,manner,isrecom,address')->order('isrecom desc,sk_beautician.id desc')->join('sk_business on sk_business.id=sk_beautician.bsid')->limit(($p * 3 ).',3')->select();
		foreach ($data as $key => $value) {
			$value['labname']=explode(',',$value['lab']);
			$data[$key]=$value;
		}
		echo json_encode($data);		
	}
}