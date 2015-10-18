<?php

class OrderAction extends WxuserAction{
// 点击预约项目，跳转到填写订单页面
	public $timearr=array("09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30");
	Public function tijingdan(){
		$r_fount=7;
		$this->assign("r_fount",$r_fount);
		//从选择美容师页面到订单页面
		if(isset($_POST['beautyid'])){
			$beautyid['id']=$_POST['beautyid'];
			$beautyname=M('Beautician')->where($beautyid)->getField('name');
			$this->assign('mrsname',$beautyname);
			$this->assign("beautyid",$_POST['beautyid']);
			$this->assign('bid',$_POST['beautyid']);
		}
		// 从美容师列表到项目到订单页面
		if(isset($_GET['beautyid'])){
			$beautyid['id']=$_GET['beautyid'];
			$beautyname=M('Beautician')->where($beautyid)->getField('name');
			$this->assign('mrsname',$beautyname);
			$this->assign("beautyid",$_GET['beautyid']);
			$this->assign('bid',$_GET['beautyid']);
		}

		if(isset($_GET['serviceid'])&&isset($_GET['classid'])){
			$this->assign("serviceid",$_GET['serviceid']);
			$map1['id']=$_GET['serviceid'];
			$map2['id']=$_GET['classid'];
			$classname=M('Servicetype')->where($map2)->getField('classname');
			$servicename=M('Service')->where($map1)->field('name,trueprice')->find();
			if(!empty($servicename)){
				$this->assign('servicename',$servicename);
			}
			if(!empty($classname)){
				$this->assign('classname',$classname);
			}
			//查询用户表，将用户的信息分配给该页面
			$memberid['id']=$_SESSION["memberinfo"]["id"];
			$member=M('Member')->where($memberid)->find();
			$this->assign('member',$member);
			// 返回抵扣的钱,1个积分是1分钱------------------------------------待做---------
			$conpoint=M('Setting')->where('id=1')->getField('conpoint');
			$trueprice=$servicename['trueprice'];
			// 最大的积分数量抵扣的钱=价格*抵扣的比例
			// 同时将用户的积分和最大的积分比较，小的话，返回用户的积分
			$maxjifeng=$trueprice*$conpoint*100;
			// 大的话，返回最大的积分
			if($member['point']>$maxjifeng){
				$jifeng=$maxjifeng;
			}else{
				$jifeng=$member['point'];
			}				
			$this->assign('conpoint',$conpoint);
			$this->assign('maxjifeng',$jifeng);
			//查询数据库中美容师的占用时间
			//首先查询每一天的数据，遍历7天的情况
			$r_man=array();
			for($i=0;$i<$r_fount;$i++){
				$ndate=get_bdate($i);//获取当前一天的y-m-d
				$mapdate=array();
				$mapdate["beautyid"]=$beautyid['id'];
				$mapdate["serviceid"]=$_GET['serviceid'];
				$mapdate["orderymd"]=$ndate;
				$where['status']=20;
				$orderid=M('Order')->where($where)->getField("id",true);
				// dump($orderid);
			    if(!empty($orderid)){
			    	$mapdate['orderid']=array("in",$orderid);
			    }
			    // 查找一个美容师的约的情况
				$yynum=M("Beautytime")->where($mapdate)->getField("date",true);
				// 存放每一天的状态
				for($j=0;$j<count($this->timearr);$j++){
					if(!in_array($this->timearr[$j],$yynum)){
							$r_man[$i]=1;
							break;
					}
				}
				if($j==count($this->timearr)&&count($this->timearr)>0){
					$r_man[$i]=0;
				}
			}	
			$this->assign("r_man",implode(",",$r_man));

			$this->assign('serviceid',$_GET['serviceid']);
			$this->assign('classid',$_GET['classid']);			
			$this->assign('webtitle','订单提交');
			$this->display();
		}else{
			$this->display('Public:error');
		}		
	}
	
	public function choosedate(){
		// 查询某天时间是否被约满
		//查询数据库中美容师的占用时间
		$where['beautyid']=$_POST["beautyid"];
		$where['serviceid']=$_POST['serviceid'];
	    $where['orderymd']=$_POST['date_now'];
	    $map['memberid']=$_SESSION["memberinfo"]["id"];
	    $map['status']=20;
	    $orderid=M('Order')->where($map)->getField("id",true);//一维索引数组
	    if(!empty($orderid)){
	    	$where['orderid']=array("in",$orderid);
	    }
		foreach($this->timearr as $k=>$v){
			$where['date']=$v;
			$isorder=M('Beautytime')->where($where)->count();
			if($isorder>0){
				$data[$k]=0;
			}else{
				$data[$k]=1;
			}
		}
		echo json_encode($data);				
	}
	// 点击提交订单,跳转到订单详情
	public function orderdetail(){
		if(!empty($_POST)&&empty($_POST["isu"])){
			// 点击提交订单，提交订单数据,将提交的数据保存到order表中
			$data['usepoint']=$_POST['jifeng'];
			$data['ordertime']=$_POST['ymd'].' '.$_POST['shijing'];//订单时间
			$data['truename']=$_POST['username'];
			$data['phone']=$_POST['phone'];
			$data['trueprice']=$_POST['trueprice'];
			$data['orderprice']=$_POST['orderprice'];
			$data['beautyid']=$_POST['beautyid'];
			$data['serviceid']=$_POST['serviceid'];
			$data['status']=10;
			$data['memberid']=$_SESSION["memberinfo"]["id"];
			$data['createtime']=time();
			// 随机生成订单编号,订单orderid
			$data['num']=genordernum();
			$id=M('Order')->add($data);
			$orderid=$id;
			// 订单id
			M('Order')->where('id='.$id)->setField("orderid",$id);
				//将订单的信息存放订单表中		
			if(!empty($_POST['beautyid'])){
				$beautyid['id']=$_POST['beautyid'];
				$beautyname=M('Beautician')->where($beautyid)->getField('name');
				$this->assign('mrsname',$beautyname);
			}
			if(!empty($_POST['servicename'])){
				$this->assign('servicename',$_POST['servicename']);
			}					
			//根据你存的订单的id来查找订单信息
			$res=M('Order')->where('id='.$id)->field('num,orderprice,memberid,truename,phone,ordertime,usepoint')->find();
			// 将用户提交的用户信息存放到会员表中
				$memberid['id']=$_SESSION["memberinfo"]["id"];
				$member['yuyuename']=$res['truename'];
				$member['yuyuephone']=$res['phone'];
				M('Member')->where($memberid)->save($member);	
			$this->assign('res',$res);
		}

		// 用户中心的订单		
		if(!empty($_POST)&&!empty($_POST["isu"])){
			$orderid=intval($_POST['orderid']);
			$res=M('Order')->where('orderid='.$orderid)->field('num,orderprice,memberid,serviceid,beautyid,truename,phone,ordertime,usepoint')->find();
			$beautyid=intval($res['beautyid']);
			$serviceid=intval($res['serviceid']);
			$data['num']=$res['num'];
			$servicename=M('Service')->where('id='.$serviceid)->field('name')->find();
			$this->assign('servicename',$servicename['name']);
			$mrsname=M('Beautician')->where('id='.$beautyid)->field('name')->find();
			$this->assign('mrsname',$mrsname['name']);
			$this->assign('res',$res);
		}
		// 调用积分函数,抵消的积分
		$usepoint=$res['usepoint'];
		// 将用户的积分更新
	    $map3['id']=$res['memberid'];
	    $points=M('Member')->where($map3)->getField('point');//测试已经执行
	    $datam['point']= $points-$usepoint;//暂时冻结
	    // 保存登录的用户的积分
	    M('Member')->where($map3)->save($datam);//测试已经执行

		$this->assign('webtitle','订单详情');
		$this->weipay($data['num'],$res['orderprice']);
		$this->display();
	}
	// 点击确认支付，跳转到订单支付页面成功页面
	public function paysuccess(){
		// 订单成功
		// 更新订单的状态
		parent::paysuccess();
	}
}