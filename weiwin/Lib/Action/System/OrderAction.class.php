<?php
class OrderAction extends BackAction{
    // 显示订单管理的订单列表
	public function index(){
        $model=M('Order');      
        if(isset($_REQUEST["num"])&&$_REQUEST["num"]!=''){
            $map["sk_order.num"]=array("like","%".$_REQUEST['num']."%");
            $this->assign('num',$_REQUEST['num']);
       }
        if(isset($_REQUEST["truename"])&&$_REQUEST["truename"]!=''){
            $map["sk_order.truename"]=array("like","%".$_REQUEST['truename']."%");
            $this->assign('truename',$_REQUEST['truename']);
        }          
         if(isset($_REQUEST["phone"])&&$_REQUEST["phone"]!=''){
            $map["sk_order.phone"]=$_REQUEST['phone'];
            $this->assign('phone',$_REQUEST['phone']);
        }   
         if(isset($_REQUEST["status"])&&$_REQUEST["status"]!='0'){
            $map["sk_order.status"]=$_REQUEST['status'];
            $this->assign('status',$_REQUEST['status']);
        }   
         if(isset($_REQUEST["isread"])&&$_REQUEST["isread"]!='2'){
            $map["sk_order.isread"]=$_REQUEST['isread'];
            $this->assign('isread',$_REQUEST['isread']);
        }  
        if ($_REQUEST['date'] != "时间段" && $_REQUEST['date'] != "") {
                $this->assign('date', $_REQUEST['date']);
                $arr = explode("-", $_REQUEST['date']);
                // dump($arr);
                $map['sk_order.createtime'] = array('between', strtotime(rtrim($arr[0])).','.strtotime(rtrim($arr[1])));
            }
 
        import('ORG.Util.Page');// 导入分页类
        $count=$model->where($map)->count();// 查询满足要求的总记录数
        $Page= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $lists=M('Order')->where($map)->field('sk_order.id,sk_order.num,sk_order.truename,sk_order.phone,sk_order.ordertime,sk_beautician.name beautyname,sk_service.name servicename,sk_order.trueprice,sk_order.orderprice,sk_order.createtime,sk_order.status,sk_order.isread')->order('sk_order.isread asc,sk_order.createtime desc')->join('sk_beautician on sk_order.beautyid=sk_beautician.id')->join('sk_service on sk_service.id=sk_order.serviceid')->limit($Page->firstRow.','.$Page->listRows)->select();
        // dump($lists);
        if($lists){
            $this->assign('lists',$lists);
            $this->assign('page',$show);// 赋值分页输出
        }else{
            $this->assign('lists','');
        }
        $this->display();
      
	}
	
        public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Order")->where($map)->setField("status", $_GET["status"]);
            
            if($result!==FALSE){
             $this->redirect("Order/index");
                exit;
            }else{
                $this->redirect("Order/index");
                exit;
            }
        }

        public function edit(){
            $id=intval($_GET['id']);
            $map1['id']=$id;
            $data['isread']=1;
            M('Order')->where($map1)->save($data);
            $map['id']=$id;
            $lists=M('Order')->where($map)->find();
            if($lists){
                $where['id']=$lists['beautyid'];
                $beautyname=M('Beautician')->where($where)->getField('name');
                $where1['id']=$lists['serviceid'];
                $servicename=M('Service')->where($where1)->getField('name');
                $this->assign('beautyname',$beautyname);
                $this->assign('servicename',$servicename);
            }
           
            $this->assign('lists',$lists);
            $this->display();
        }

        public function update(){
            // 之前的订单的状态
            $nowstatus=$_POST['nowstatus'];
            $data['id']=$_POST['id'];
            $data['beautyid']=$_POST['beautyid'];
            $data['serviceid']=$_POST['serviceid'];
            $data['num']=$_POST['num'];
            $data['truename']=$_POST['truename'];
            $data['phone']=$_POST['phone'];
            $data['ordertime']=$_POST['ordertime'];
            $data['trueprice']=$_POST['trueprice'];
            $data['orderprice']=$_POST['orderprice'];
            $data['remark']=$_POST['remark'];
            $data['status']=$_POST['newstatus'];//修改后的订单的状态
            $map['id']=intval($_POST['id']);
            $id=M('Order')->where($map)->save($data);

            // dump($_POST);
            // exit;
            if($id){
                // 如果是已支付的状态
                if($nowstatus==20){
                    // 如果订单是取消状态，则收回消费的返利的积分，并且返回给用户的抵扣的积分,
                    // 同时将积分事件里面的记录删除
                    if($data['status']==2){
                        $returnpoint=M("Setting")->where('id=1')->getField('returnpoint');
                        // 调用积分函数,消费返利,并且返回用户的抵扣的积分
                        $flpoint=round($returnpoint*$orderprice);
                        $member=M('Order')->where('id='.$data['id'])->field('memberid,usepoint,createtime')->find();
                        // 将用户的积分更新
                        $points=M('Member')->where('id='.$member['memberid'])->getField('point');
                        $res['point']= $points+$member['usepoint']-$flpoint;//扣除返利的积分
                        M('Member')->where('id='.$member['memberid'])->save($res);  
                        $map1['createtime']=$member['createtime'];
                        $map1['memberid']=$member['memberid'];
                        $pointid=M('Pointrecord')->where($map1)->getField('id');
                        if($pointid){
                            M('Pointrecord')->where('id='.$pointid)->delete();  
                        }
                                 
                    }
                }
                // 若是没有支付的订单进行取消
                if($nowstatus==10){
                    $usepoint=M('Order')->where('id='.$data['id'])->getField('usepoint');
                    $memberid=M('Order')->where('id='.$data['id'])->getField('memberid');
                        // 将用户的积分更新
                    $point=M('Member')->where('id='.$memberid)->getField('point');
                    $res1['point']= $point+$usepoint;//扣除返利的积分
                    M('Member')->where('id='.$memberid)->save($res1);  
                    // echo M('Member')->getLastSql();
                    // exit;     
                }
            }
                 
            $this->success('保存成功',U('Order/index'));                   
        }
          public function delete(){
             parent::foreverdelete("Order");
        }

}
?>