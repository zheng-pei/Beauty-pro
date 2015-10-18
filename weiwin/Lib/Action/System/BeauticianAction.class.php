<?php
class BeauticianAction extends BackAction
{
    public function index(){
        $model=M('Beautician'); 
        $map=array();
        if(isset($_REQUEST["areanameid"])&&$_REQUEST["areanameid"]!=0){
            $map["sk_beautician.areaid"]=$_REQUEST["areanameid"];
            $this->assign('aid',$_REQUEST['areanameid']);
        }     
        if(isset($_REQUEST["business"])&&$_REQUEST["business"]!=0){
            $map["sk_beautician.bsid"]=$_REQUEST["business"];
            $this->assign('business',$_REQUEST['business']);
        }
        if(isset($_REQUEST["beautyname"])&&$_REQUEST["beautyname"]!=''){
            $map["sk_beautician.name"]=array("like","%".$_REQUEST['beautyname']."%");
            $this->assign('beautyname',$_REQUEST['beautyname']);
        }
        if(isset($_REQUEST["isrecom"])&&$_REQUEST["isrecom"]!=2){
            $map["sk_beautician.isrecom"]=$_REQUEST["isrecom"];
            $this->assign('isrecom',$_REQUEST['isrecom']);
        }
        if(isset($_REQUEST["status"])&&$_REQUEST["status"]!=2){
            $map["sk_beautician.status"]=$_REQUEST["status"];
            $this->assign('status',$_REQUEST['status']);
        }
        // 地区
        $areaname=M('area')->field('id,areaname')->select();
        if($areaname){
            $this->assign('areaname',$areaname);
        }
        // 商家
        $bsid=M('Business')->field('id,name')->select();
        if($bsid){
            $this->assign('bsid',$bsid);
        }
        import('ORG.Util.Page');// 导入分页类
        $count=$model->where($map)->count();// 查询满足要求的总记录数
        $Page= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $lists=$model->field('sk_beautician.id,sk_business.name bsname,sk_area.areaname,sk_beautician.name beautyname,sk_beautician.isrecom,sk_beautician.createtime,sk_beautician.status')->where($map)->join('sk_area on sk_beautician.areaid=sk_area.id')->join('sk_business on sk_business.id=sk_beautician.bsid')->order('sk_beautician.bsid asc,sk_beautician.createtime desc,sk_beautician.status desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        // dump($lists);
        if($lists){
            $this->assign('lists',$lists);
            $this->assign('page',$show);// 赋值分页输出
        }else{
            $this->assign('lists','');
        }
        $this->display();
    }

    // 会员的评价页面
    public function reviewindex(){
        $id=$_GET['beautyid'];
        $this->assign('beautyid',$id);
        $model=M('beautyreview');      
        if(isset($_REQUEST["att"])&&$_REQUEST["att"]!=0){
            $map["sk_beautyreview.att"]=$_REQUEST["att"];
            $this->assign('att',$_REQUEST['att']);
       }
        if(isset($_REQUEST["manner"])&&$_REQUEST["manner"]!=0){
            $map["sk_beautyreview.manner"]=$_REQUEST["manner"];
            $this->assign('manner',$_REQUEST['manner']);
       }
        if(isset($_REQUEST["tech"])&&$_REQUEST["tech"]!=0){
            $map["sk_beautyreview.tech"]=$_REQUEST["tech"];
            $this->assign('tech',$_REQUEST['tech']);
        }
        if(isset($_REQUEST["servicename"])&&$_REQUEST["servicename"]!=''){
            $map["sk_service.name"]=array('like','%'.$_REQUEST["servicename"].'%');
            $this->assign('servicename',$_REQUEST['servicename']);
        }
         if(isset($_REQUEST["beautyid"])&&$_REQUEST["beautyid"]!=0){
            $map['sk_beautyreview.beautyid']=$_REQUEST["beautyid"];
        }
        import('ORG.Util.Page');// 导入分页类
        $count=$model->where($map)->count();// 查询满足要求的总记录数
        $Page= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $lists=M('beautyreview')->field('sk_beautyreview.id,sk_beautyreview.beautyid,sk_beautician.name beautyname,sk_service.name servicename,nickname,sk_beautyreview.att,sk_beautyreview.tech,sk_beautyreview.manner,sk_beautyreview.createtime')->where($map)->join('sk_beautician on sk_beautician.id=sk_beautyreview.beautyid')->join('sk_service on sk_service.id=sk_beautyreview.serviceid')->join('sk_member on sk_member.id=sk_beautyreview.memberid')->order('sk_beautyreview.createtime')->limit($Page->firstRow.','.$Page->listRows)->select();
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
            $result=M("Beautician")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Beautician/index",$_GET);
                exit;
            }else{
                $this->redirect("Beautician/index",$_GET);
                exit;
            }
        }
        public function insert(){
            if(empty($_POST['createtime'])){
                $_POST['createtime']=time();
            }
            if(!empty($_POST['lab'])){
                $_POST['lab']=implode($_POST['lab'], ",");
            }
            parent::insert("Beautician",0);
        }
        public function update(){
            $model=M('Beautician');
            $map['id'] = $_POST['id'];
            if($model->create()){
                $bid=$model->where($map)->save();
                if($bid){
                    $this->success('编辑成功',U('Beautician/index'));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error('非法操作');
            }
            // parent::update("Beautician",0,1);
        }
        // 美容师评价查看
        public function review(){
            $map['sk_beautyreview.id']=$_GET['id'];
            $lists=M('Beautyreview')->field('sk_beautyreview.id,sk_beautyreview.beautyid,sk_beautician.name beautyname,sk_service.name servicename,nickname,sk_beautyreview.att,sk_beautyreview.tech,sk_beautyreview.manner,sk_beautyreview.createtime,sk_beautyreview.comment')->where($map)->join('sk_beautician on sk_beautician.id=sk_beautyreview.beautyid')->join('sk_service on sk_service.id=sk_beautyreview.serviceid')->join('sk_member on sk_member.id=sk_beautyreview.memberid')->order('sk_beautyreview.createtime')->find();
            // dump($lists);
            $this->assign('lists',$lists);
            $this->display();
        }
        // 美容师评价删除
        public function reviewdelete(){
            $map['id']=$_GET['id'];
            $beautyid=$_GET['beautyid'];
            $map['beautyid']=$beautyid;
            $id=M('beautyreview')->where($map)->delete();
            if($id){
                echo "<script>alert('删除成功');history.back();</script>";
            }else{
                echo "<script>alert('删除失败');history.back();</script>";
            }
        
        }
        public function add(){    
            $this->getbranklist();
            $this->gettype();
            $_POST['createtime']=time();
            parent::add();
        }
        public function edit(){
            //获取美容师ID
            $id=$_GET['id'];
            $model=D("Beautician");
            //获取美容师信息
            $beauty = $model->find($id);
            $areaid = $beauty['areaid'];
            $bsid = $beauty['bsid'];
            $selareas = D("area")->find($areaid);
            $business = D("business")->find($bsid);
            $this->assign("selarea",$selareas);
            $this->assign("selbusiness",$business);
            // 分配服务id
            $labarray = explode(",", $beauty['serviceid']);
            $this->assign("membs", $beauty['serviceid']);
          
            $this->assign("beautyinfo",$beauty);
            $this->getbranklist();
            //取出serviceid,查询服务相关信息
            $serviceinfo = D("service")->where("sk_service.id in(".$beauty['serviceid'].")")->field("sk_service.name,classid,sk_servicetype.classname")->join('sk_servicetype on sk_service.classid=sk_servicetype.id')->select();
           // dump($serviceinfo);
           //  分配服务内容
            $servs1="";
           foreach ($serviceinfo as $key => $value) {
               $servs1.=$value['classname']." ".$value['name'].",";
           }
            $servs=rtrim($servs1, ',');
            $this->assign('servs',$servs);

            $this->assign("serviceinfo",$serviceinfo);
            $this->display() ;         
        }
        //获取服务分类
        public function gettype(){
            $types = D("servicetype")->field("id,classname")->select();
            $this->assign("stype",$types);   
        }
        public function delete(){
            parent::foreverdelete("Beautician");
        }
        //区域商家联动请求处理
        public function getbranklist(){
            $brandlist=M("area")->where("status=1")->order("sort asc")->select();
            $csstr='请选择区域--0$请选择商家--0';
            foreach($brandlist as $k=>$v){
                $csstr.="#".$v['areaname'].'--'.$v['id'];
                $where["areaid"]=$v["id"];
                $slist=M("business")->where($where)->select();
                $csstr.='$';
                foreach($slist as $vs){
                    $csstr.=$vs['name'].'--'.$vs['id'].',';
                }
                $csstr=rtrim($csstr,',');
            }
            $this->assign("csstr",$csstr);
        }
        //处理计算分数ajax请求
        public function searchin() {
            if(!empty($_POST['beautyid'])){
                $id = $_POST['beautyid'];
            }
            $model = D("beautyreview");
            $searchin = $model->where("beautyid=".$id)->getField("beautyid,ifnull(avg(tech),0) v_tech,ifnull(avg(att),0) v_att,ifnull(avg(manner),0) v_manner");
            $data["searchin"]=$searchin;
            echo json_encode($data);
            //return $searchin;
        }
        //获得服务选择弹出页面ajax请求并处理
        public function checkservice() {
            $map=array();
            $map['classname']=$_REQUEST['typename'];
            $map['name']=$_REQUEST['servicename'];
            if(!empty($map)){
                $data['checkservice']=D("service")->relation(true)->
                where($map)->field("classname,name,origprice,comment")
                ->select();
            }
            $data['checkservice']=D("service")->relation(true)->
            field("classname,name,origprice,comment")
            ->select();
            echo json_encode($data);
        }
        public function servicesearch(){
            $map=array();
            //$map['memtype']=array("in","1,2");
            if(isset($_POST["nick_key"])&&$_POST['nick_key']!=''){
                $map["name"]=array("like","%".$_POST['nick_key']."%");
            }
            if(isset($_POST["sex_key"])&&!empty($_POST['sex_key'])){
                $map["classid"]=$_POST['sex_key'];
            }
            $map["status"]=1;
            $page=($_POST["page"]<1)?1:$_POST["page"];
            $size=10;
            $brandlist=D("Service")->relation(TRUE)->where($map)->page($page,$size)->select();
            $data["total"]=M("service")->where($map)->count();
            $data["page"]=$page;
            $data["size"]=$size;
            $data["rows"]=$brandlist;
            echo json_encode($data);
        }
}