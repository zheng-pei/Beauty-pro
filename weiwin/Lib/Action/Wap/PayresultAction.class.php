<?php
// +----------------------------------------------------------------------
// | G3weixin [ ALL WHERE,ALL TIME ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://lietouzhe.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 微信信息推送、事件推送程序
 */
class PayresultAction extends Action{
   
   function payresult(){
	 $ordernum = $_GET['ordernum'];
     $res = M('Order')->where(array('num'=>$ordernum))->find();
	 
	   if($_GET['status']==20&&$res['status']<20){
		 $_SESSION["memberinfo"]["id"]=$res["memberid"];
		 $this->paysuccess($res["id"]);
		 //$data["status"]=$_GET['status'];
		// $payresult=M('Order')->where(array('num'=>$ordernum))->save($data);
		// if($payresult!==false){
		//	   $getscore=getscore($res["memberid"],$res['num'], 'xiaofei', $res['orderprice'],1);
		//	   getscore($res["memberid"],$res['num'], 'dixiao', $res['usepoint'],1,0);
		// }
	        $this->assign('webtitle','支付成功页面');
            $this->assign('flag',1);//支付成功的标志 
        }else{
            $this->assign('webtitle','支付失败页面');
            $this->assign('flag',0);//支付失败的标志 
        }
        $this->display('Public:paystatus');
	}
	
	//美容师的占用时间存放在表中
public function beautyTime($orderid,$beautyid,$serviceid){
    $timearr=array("09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30");
      //当支付成功，我要将时间占用存放到美容师占用表
        $map['id']=$serviceid;
        $map['status']=1;
        $servicetime=M('Service')->where($map)->getField('servicetime');
        $ordertime=M('Order')->where('orderid='.$orderid)->getField('ordertime');
        $yushu=$servicetime%30;
        $count=ceil($servicetime/30);
        $shijing=date('H:i',strtotime($ordertime));
        //数据要存放在表中
        $data['beautyid']=$beautyid;
        $data['ordertime']= $ordertime;
        $data['orderid']=$orderid;
        $data['serviceid']=$serviceid;
        $data['orderymd']=(int)date("Y",strtotime($ordertime))."-".(int)date("m",strtotime($ordertime))."-".(int)date("d",strtotime($ordertime)); //这个的输出是 2011-1-9
        $data['date']=$shijing;
        $data['memberid']=$_SESSION["memberinfo"]["id"];
        // 如果余数为0,存放的时间个数是count-1
        foreach ($timearr as $key => $value) {
            if($shijing==$value){
              $j=$key;//查找的元素的下标    
            }
        }
        if($yushu==0){ 
            $xiabiao=$j+$count;//最后的下标
              for($i=$j;$i<$xiabiao;$i++){ 
                if($i<26){
                  $data['date']=$timearr[$i];
                  // 数据要存放在表中
                  M('Beautytime')->add($data);  
                  echo M('Beautytime')->getLastSql();
                }   
              } 
        }else{
            $xiabia=$j+$count;//最后的下标
            for($k=$j;$k<$xiabia;$k++){ 
              if($k<26){ 
                $data['date']=$timearr[$k];
                // 数据要存放在表中
                M('Beautytime')->add($data); 
                // echo M('Beautytime')->getLastSql(); 
              }   
            } 
        }    
    }
// 积分记录函数
public function jifengscore($memberid,$status,$orderid){
  // 支付订单成功，要将用户抵扣的积分存放到对应的积分事件中,同时更新用户的积分----    
  if($status=="xiaofei"){
    $data1['mathtype']=0;
    $data1['eventtype']=2;
    $where['status']=20;
    $where['orderid']=$orderid;
    $res=M('Order')->where($where)->field('usepoint,num,createtime,orderprice')->find();
    // 保存数据到积分记录表中
    $data1['point']=$res['usepoint'];
    $data1['comment']='订单编号：'.$res['num'].'使用积分';
    $data1['createtime']=$res['createtime'];
    $data1['memberid']=$memberid;
    M('Pointrecord')->add($data1);
    // 同时要返还消费的积分存入积分事件表
    $getscore=getscore($memberid,$res['num'],"xiaofei",$res['orderprice'],1,0);
    // echo M('Pointrecord')->getLastSql();
    //同时会员的积分要更新
    $map1['memberid']=$_SESSION["memberinfo"]["id"];
    $map1['eventtype']=array('in','1,3');
    $map2['memberid']=$_SESSION["memberinfo"]["id"];
    $map2['eventtype']=2;
    $xiaofeipoint=M('Pointrecord')->where($map2)->sum('point');
    $qdflpoint=M('Pointrecord')->where($map1)->sum('point');
    $totalpoint= $qdflpoint-$xiaofeipoint;
    $data['point']=$totalpoint;//总的积分
    $map3['id']=$memberid;
    // 保存登录的用户的积分
    M('Member')->where($map3)->save($data);//测试已经执行
     // echo M('Member')->getLastSql();
  }
}

// 支付成功页面
    public function paysuccess($orderid){
        // 更新订单的状态
        if(!empty($orderid)){
          $orderpay=M('Order')->where('orderid='.$orderid)->find();
          if($orderpay){
            // 更新订单状态---------
            $data['status']=20;
            $id=M('Order')->where('orderid='.$orderid)->save($data);
            $memberid=$_SESSION["memberinfo"]["id"];
            // 支付订单成功，要将用户抵扣的积分存放到对应的积分事件中,同时更新用户的积分----测试没有执行
            $this->jifengscore($memberid,'xiaofei',$orderid);        
            // 要给客户发消息，存放message表中,这里要判断你提交的订单是否支付，才好发送消息---------
            $message['memberid']=$_SESSION["memberinfo"]["id"];
            $message['comment']='支付成功';
            $message['createtime']=time();
            $message['orderid']=$orderid;
            $message['status']=0;
            M('Message')->add($message);
            // echo M('Message')->getLastSql();
            $data=M('Order')->where('orderid='.$orderid)->field('beautyid,serviceid')->find();
            $beautyid=$data['beautyid'];
            $serviceid=$data['serviceid'];
            //当支付成功，我要将时间占用存放到美容师占用表------------------
            $this->beautyTime($orderid,$beautyid,$serviceid); 
          }
        }
    }

}

?>