<?php
// 首页类别的选择
class IndexAction extends WxuserAction{
	// 地区列表的选择的首页
	public function index(){
		$m=M('Area');
		$map['status'] = 1;
		$res=$m->field('id,areaname')->where($map)->limit(0,6)->select(); 
		$this->assign('res',$res);
		$this->assign('webtitle','小美首页');
		$this->display();
		
	}
	public function loadmore(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$m=M('Area');
		$map['status'] = 1;
		$data=$m->field('id,areaname')->where($map)->limit(($p * 3 ).',3')->select();
		echo json_encode($data);		
	}

// 平台的首页
	public function beauty(){
		if(!empty($_GET['areaid'])){
			//banner图片
			$map1['areaid']=$_GET['areaid'];
			$map1['status']=1;
			$bannerlists=M('Scrollad')->field('url,pic')->where($map1)->order('sort desc')->limit(6)->select();
			// 项目服务的列表
			$id=intval(isset($_GET['id'])?$_GET['id']:0);
			// dump($id);
			if($id==0){
				$where['sk_service.isrecom']=1;
				$where['sk_service.status']=1;
				$where['areaid']=$_SESSION['areaid'];
				// 推荐服务列表
				$itemlists=M('Service')->field('sk_service.id,classid,name,classname,smallpic,appuser,trueprice,origprice,isrecom,servicetime')->where($where)->order('classid asc,sk_service.sort desc')->join('sk_servicetype on sk_servicetype.id=sk_service.classid')->limit(0,6)->select();
			}else{
				$map['classid']=$id;
				$map['sk_service.status']=1;
				$map['areaid']=$_SESSION['areaid'];
				// 项目服务列表
				$itemlists=M('Service')->field('sk_service.id,classid,name,classname,smallpic,appuser,trueprice,origprice,isrecom,servicetime')->where($map)->order('isrecom desc,sk_service.sort desc')->join('sk_servicetype on sk_servicetype.id=sk_service.classid')->limit(0,6)->select();
				// echo M('Service')->getLastSql();
			}
		
		// 查找服务项目的列表
		$servicename=M('Servicetype')->field('id,classname,pic,selpic')->where($map1)->select();
		if(!empty($servicename)){
			$this->assign('servicelists',$servicename);
		}
		$this->assign('bannerlists',$bannerlists);
		$this->assign('lists',$itemlists);
		$this->assign('id',$id);
		$this->assign('webtitle','首页');
		$this->assign('areaid',$_SESSION['areaid']);
		$this->display();
		}
	}
	//服务项目的列表的分页加载
	public function loadservice(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$id=$_POST['id'];
		if($id==0){
				$where['sk_service.isrecom']=1;
				$where['sk_service.status']=1;
				$where['areaid']=$_SESSION['areaid'];
				// 推荐服务列表
				$itemlists=M('Service')->field('sk_service.id,classid,name,classname,smallpic,appuser,trueprice,origprice,isrecom,servicetime')->where($where)->order('classid asc,sk_service.sort desc')->join('sk_servicetype on sk_servicetype.id=sk_service.classid')->limit(($p * 3 ).',3')->select();
		}else{
				$map['classid']=$id;
				$map['sk_service.status']=1;
				$map['areaid']=$_SESSION['areaid'];
				// 项目服务列表
				$itemlists=M('Service')->field('sk_service.id,classid,name,classname,smallpic,appuser,trueprice,origprice,isrecom,servicetime')->where($map)->order('isrecom desc,sk_service.sort desc')->join('sk_servicetype on sk_servicetype.id=sk_service.classid')->limit(($p * 3 ).',3')->select();
				// echo M('Service')->getLastSql();
		}
		echo json_encode($itemlists);
	}
}