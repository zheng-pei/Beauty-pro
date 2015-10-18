<?php
// 会员的个人中心
class UsercenterAction extends WxuserAction{
	// 会员的个人中心的首页
	public function index(){
		// 根据会员的id关联order表查找订单信息
		$map['id']=$_SESSION["memberinfo"]["id"];
		$member=M('Member')->where($map)->find();
		$this->assign('member',$member);
		// 签到的次数，签到一次，积分+1,并且更新数据
		$sign['memberid']=$_SESSION["memberinfo"]["id"];
		$this->paysuccesscount();
		$this->daipingjiacount();
		$count=M('Signrecord')->where($sign)->count();
		$this->assign('count',$count);
		$this->assign('webtitle','会员中心首页');
		$this->display();
	}

// 会员签到的记录保存
	public function qiandao(){
		//若点击了签到按钮
		$memberid=$_SESSION["memberinfo"]["id"];
		$res=M('Signrecord')->field('createtime')->where('memberid='.$memberid)->select();
		if(empty($res)){
			// 记录到签到表中,并且记录到积分记录表中
			$this->signpoint($memberid);
			echo "2";
			exit;
		}else{
			$now_time=date("Y-m-d");
			$signtime=array();
			// 存放所有的时间y-m-d
			foreach ($res as $key => $value) {
				$signtime[]=date("Y-m-d",$value['createtime']);
			}
			if (in_array($now_time, $signtime)) {
				// 不会记录签到
				echo "0";
				exit;
			}else{
					// 记录签到
				$this->signpoint($memberid);
				echo "1";
				exit;
			}
		}	
	}

	// 记录到签到表中，并且记录到积分记录表中
	public function signpoint($memberid){
		// 记录到签到表中
		$point=M('Setting')->where('id=1')->getField('signinpoint');//后台设置的签到获取积分
		$data['point']=$point;//签到一次获得1个积分
		$data['memberid']=$memberid;
		$data['createtime']=time();
		M('Signrecord')->add($data);
		// 同时记录到积分记录表
		$record['mathtype']=1;
		$record['eventtype']=3;
		$record['memberid']=$memberid;
		$record['point']=$point;
		$record['comment']='签到获得积分';
		$record['createtime']=$data['createtime'];
		M('Pointrecord')->add($record);
		// 同时更新会员表
		$map['id']=$memberid;
		$mypoint=M('Member')->where($map)->getField('point');
		$res['point']=$mypoint+$point;
		M('Member')->where($map)->save($res);
	}

	// 会员个人的积分页面
	public function mypoint(){
		// 用户的积分应该是积分记录事件中的积分的总和，把这个数据存放会员表中
		$memberid['id']=$_SESSION["memberinfo"]["id"];
		$res=M('Member')->where($memberid)->find();
		$this->assign('point',$res['point']);
		$id=isset($_GET['id'])?$_GET['id']:1;
		//积分的消费情况
		if($id==1){
			$map['eventtype']=2;
			$map['memberid']=$_SESSION["memberinfo"]["id"];
			$map['point']=array('gt','0');
			$res=M('Pointrecord')->where($map)->order('createtime desc')->limit(0,6)->select();	
		 	if($res){
				$this->assign('res',$res);
			}else{
				$this->assign('res','');
			}
		}
		// 积分获取情况,有返回消费积分，有签到获取积分
		if($id==2){
			$map2['eventtype']=array('in','1,3');
			$map2['point']=array('gt','0');
			$map2['memberid']=$_SESSION["memberinfo"]["id"];
			$res=M('Pointrecord')->where($map2)->order('createtime desc')->limit(0,6)->select();	
			if($res){
				$this->assign('res',$res);
			}else{
				$this->assign('res','');
			}
		}		
		$this->assign('id',$id);
		$this->assign('webtitle','我的积分');
		$this->display();
	}

	// 更多积分的加载
	public function pointload(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$id=$_POST['id'];
		//积分的消费情况
		if($id==1){
			$map['eventtype']=2;
			$map['point']=array('gt','0');
			$map['memberid']=$_SESSION["memberinfo"]["id"];
			$data=M('Pointrecord')->where($map)->order('createtime desc')->limit(($p * 3).',3')->select();	
		}
		// 积分获取情况,有返回消费积分，有签到获取积分
		if($id==2){
			$map2['eventtype']=array('in','1,3');
			$map2['point']=array('gt','0');
			$map2['memberid']=$_SESSION["memberinfo"]["id"];
			$data=M('Pointrecord')->where($map2)->order('createtime desc')->limit(($p * 3).',3')->select();				
		}	
		echo json_encode($data);	
	}

	// 会员的消息页面,0表示未读，1表示已读
	public function message(){
		$id=isset($_GET['id'])?$_GET['id']:1;
		//首先所有的消息是未读消息列表，当你点击查看，消息变成已经读
		if($id==1){
			// 查找支付成功，没有支付的订单
			$where1['sk_message.status']=0;
			$where1['sk_message.memberid']=$_SESSION["memberinfo"]["id"];
			$res=M('Message')->field('sk_message.id,sk_order.orderid,beautyid,serviceid,truename,phone,num,sk_order.createtime,sk_order.status messagestatus,sk_order.status orderstatus')->where($where1)->join('sk_order on sk_message.orderid=sk_order.id')->order('sk_message.createtime desc')->limit(0,6)->select();
		}
	
		if($id==2){
			$where['sk_message.status']=1;
			$where['sk_message.memberid']=$_SESSION["memberinfo"]["id"];
			$res=M('Message')->field('sk_message.id,sk_order.orderid,beautyid,serviceid,truename,phone,num,sk_order.createtime,sk_order.status messagestatus,sk_order.status orderstatus')->where($where)->join('sk_order on sk_message.orderid=sk_order.id')->order('sk_message.createtime desc')->limit(0,6)->select();
		}
		$this->assign('i',$id);
		if($res){
			$this->assign('res',$res);
		}else{
			$this->assign('res','');
		}		
		// 已读消息列表
		$this->assign('webtitle','消息中心');
		$this->display();
	}
	// 加载更多消息
	public function messageload(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$id=$_POST['id'];
		if($id==1){
			// 查找支付成功，没有支付的订单
			$where1['sk_message.status']=0;
			$where1['sk_message.memberid']=$_SESSION["memberinfo"]["id"];
			$data=M('Message')->field('sk_message.id,sk_order.orderid,beautyid,serviceid,truename,phone,num,sk_order.createtime,sk_order.status messagestatus,sk_order.status orderstatus')->where($where1)->join('sk_order on sk_message.orderid=sk_order.id')->order('sk_message.createtime desc')->limit(($p * 3).',3')->select();
		}
	
		if($id==2){
			$where['sk_message.status']=1;
			$where['sk_message.memberid']=$_SESSION["memberinfo"]["id"];
			$data=M('Message')->field('sk_message.id,sk_order.orderid,beautyid,serviceid,truename,phone,num,sk_order.createtime,sk_order.status messagestatus,sk_order.status orderstatus')->where($where)->join('sk_order on sk_message.orderid=sk_order.id')->order('sk_message.createtime desc')->limit(($p * 3).',3')->select();
		}
		echo json_encode($data);
	}	

	// 点击查看订单消息
	public function orderstatus(){
		// 若点击查看，则消息变成已读
		if(!empty($_GET['orderid'])){
			$data['status']=1;
			$map['orderid']=$_GET['orderid'];
			$map['memberid']=$_SESSION["memberinfo"]["id"];
			M('Message')->where($map)->save($data);
		}
		//将数据显示
		$orderid=$_GET['orderid'];
		if(!empty($orderid)){
			$res=M('Order')->where('orderid='.$orderid)->find();
			$beautyid=$res['beautyid'];
			$serviceid=$res['serviceid'];
			$servicename=M('Service')->where('id='.$serviceid)->getField('name');
			$this->assign('servicename',$servicename);
			$mrsname=M('Beautician')->where('id='.$beautyid)->getField('name');
			$this->assign('mrsname',$mrsname);
			$this->assign('res',$res);
			// $this->weipay($res['num'],$res['orderprice']);
		}		
		$this->assign('webtitle','订单详情');
		$this->display();
	}
	public function orders(){
		$orderid=$_GET['orderid'];
		if(!empty($orderid)){
			$res=M('Order')->where('orderid='.$orderid)->find();
			$beautyid=$res['beautyid'];
			$serviceid=$res['serviceid'];
			$servicename=M('Service')->where('id='.$serviceid)->getField('name');
			$this->assign('servicename',$servicename);
			$mrsname=M('Beautician')->where('id='.$beautyid)->getField('name');
			$this->assign('mrsname',$mrsname);
			$this->assign('res',$res);
		}		
		$this->display('orderstatus');
	}

	// 预约信息管理,会员信息管理
	public function memberxinxi(){
		$map['id']=$_SESSION["memberinfo"]["id"];
		$member=M('Member')->where($map)->find();
		$this->assign('member',$member);
		$this->assign('webtitle','预约信息管理');
		$this->display();
	}

// 用户信息的保存
	public function save(){
		$data['truename']=$_POST['truename'];
		$data['phone']=$_POST['phone'];
		$map['id']=$_SESSION["memberinfo"]["id"];
		$id=M('Member')->where($map)->save($data);
		if($id){
			$this->success('修改成功',U('Usercenter/index'));
		}else{
			$this->error('修改失败',U('Usercenter/index'));
		}
		
	}

	// 获取待评价的订单的数量
	public function daipingjiacount(){
			$map['status']=20;
			$map['memberid']=$_SESSION["memberinfo"]["id"];
			$dpj=M('Order')->where($map)->count();
			$this->assign('dpj',$dpj);
	}
	// 获取支付消息的数量
	public function paysuccesscount(){
			$map['status']=0;
			$map['memberid']=$_SESSION["memberinfo"]["id"];
			$xiaoxi=M('Message')->where($map)->count();
			$this->assign('xiaoxi',$xiaoxi);
	}

	// 会员的订单页面
	public function myorder(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$id=$_POST['id'];
		//  模拟一个用户
		$id=isset($_GET['id'])?$_GET['id']:1;
		// 返回全部订单列表
		if($id==1){
			$where['sk_order.status']=array('in','2,10,20,30');
			$where['memberid']=$_SESSION["memberinfo"]["id"];
			$res=M('Order')->field('sk_order.id,beautyid,sk_order.serviceid,orderprice,num,sk_beautician.name mrsname,sk_service.name servicename,ordertime,smallpic,sk_order.status status')->where($where)->order('status desc,sk_order.id desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->order('sk_order.status desc,sk_order.id desc')->limit(0,6)->select();		
		}
		// 返回待支付订单
		if($id==2){
			$where['memberid']=$_SESSION["memberinfo"]["id"];
			$where['sk_order.status']=10;
			$res=M('Order')->field('sk_order.id,beautyid,sk_order.serviceid,orderprice,num,sk_beautician.name mrsname,sk_service.name servicename,ordertime,smallpic,sk_order.status status')->where($where)->order('status desc,sk_order.id desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->order('sk_order.status desc,sk_order.id desc')->limit(0,6)->select();
		}
		// 返回已支付待评价订单
		if($id==3){
			$where['memberid']=$_SESSION["memberinfo"]["id"];
			$where['sk_order.status']=20;
			$res=M('Order')->field('sk_order.id,beautyid,sk_order.serviceid,orderprice,num,sk_beautician.name mrsname,sk_service.name  servicename,ordertime,smallpic,sk_order.status status')->where($where)->order('status desc,sk_order.id desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->order('sk_order.status desc,sk_order.id desc')->limit(0,6)->select();
		}
		if($res){
			$this->assign('res',$res);
		}else{
			$this->assign('res','');
		}
		$this->assign('id',$id);	
		$this->assign('webtitle','我的订单-全部');
		$this->display();
	}

// 订单的加载更多
	public function orderload(){
		$p = isset($_POST['nowpage'])? $_POST['nowpage'] : 1;
		$id=$_POST['id'];
		if($id==1){
			$where['sk_order.status']=array('in','2,10,20,30');
			$where['memberid']=$_SESSION["memberinfo"]["id"];
			$data=M('Order')->field('sk_order.id,beautyid,sk_order.serviceid,orderprice,num,sk_beautician.name mrsname,sk_service.name servicename,ordertime,smallpic,sk_order.status status')->where($where)->order('status desc,sk_order.id desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->order('sk_order.status desc,sk_order.id desc')->limit(($p * 3).',3')->select();		
		}
		// 返回待支付订单
		if($id==2){
			$where['memberid']=$_SESSION["memberinfo"]["id"];
			$where['sk_order.status']=10;
			$data=M('Order')->field('sk_order.id,beautyid,sk_order.serviceid,orderprice,num,sk_beautician.name mrsname,sk_service.name servicename,ordertime,smallpic,sk_order.status status')->where($where)->order('status desc,sk_order.id desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->order('sk_order.status desc,sk_order.id desc')->limit(($p * 3).',3')->select();
		}
		// 返回已支付待评价订单
		if($id==3){
			$where['memberid']=$_SESSION["memberinfo"]["id"];
			$where['sk_order.status']=20;
			$data=M('Order')->field('sk_order.id,beautyid,sk_order.serviceid,orderprice,num,sk_beautician.name mrsname,sk_service.name  servicename,ordertime,smallpic,sk_order.status status')->where($where)->order('status desc,sk_order.id desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->order('sk_order.status desc,sk_order.id desc')->limit(($p * 3).',3')->select();
		}
		echo json_encode($data);
	}
	// 会员的待评价页面
	public function pingjia(){
		$serviceid=$_GET['serviceid'];
		if(!empty($serviceid)){
			$servicename=M('Service')->where('id='.$serviceid)->getField('name');
			$this->assign('serviceid',$serviceid);
			$this->assign('servicename',$servicename);
		}
		$beautyid=$_GET['beautyid'];
		if(!empty($beautyid)){
			$mrsname=M('Beautician')->where('id='.$beautyid)->getField('name');
			$this->assign('mrsname',$mrsname);
			$this->assign('beautyid',$beautyid);
		}
		$orderid=$_GET['orderid'];
		if(!empty($orderid)){
			$this->assign('orderid',$orderid);
		}
		$this->assign('webtitle','我要评价');
		$this->display();
	}

	// 评价完成
	public function pingjiawc(){
		// 将用户的填写的信息存入到用户评价表中
		$data['beautyid']=$_POST['beautyid'];
		$data['memberid']=$_SESSION["memberinfo"]["id"];
		$data['orderid']=$_POST['orderid'];
		$data['comment']=$_POST['comment'];
		$data['att']=$_POST['att'];
		$data['manner']=$_POST['manner'];
		$data['tech']=$_POST['tech'];
		$data['createtime']=time();
		$data['serviceid']=$_POST['serviceid'];
		$id=M('Beautyreview')->add($data);
		$this->assign('id',$id);
		// 评价完成，将订单的状态设置为已评价
		$status['status']=30;
		M('Order')->where('orderid='.$data['orderid'])->save($status);
		$this->display();
		
	}
}