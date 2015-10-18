<?php
class BusinessAction extends BackAction
{
    public function index(){
        $model=M('Business'); 
        $map=array();
        if(isset($_REQUEST["area"])&&$_REQUEST["area"]!=0){
            $map["sk_business.areaid"]=$_REQUEST["area"];
            $this->assign('areaid',$_REQUEST['area']);
        }     
        if(isset($_REQUEST["name"])&&$_REQUEST["name"]!=''){
            $map["sk_business.name"]=array("like","%".$_REQUEST['name']."%");
            $this->assign('name',$_REQUEST['name']);
        }
        if(isset($_REQUEST["address"])&&$_REQUEST["address"]!=''){
            $map["sk_business.address"]=array("like","%".$_REQUEST['address']."%");
            $this->assign('address',$_REQUEST['address']);
        }
        if(isset($_REQUEST["status"])&&$_REQUEST["status"]!=2){
            $map["sk_business.status"]=$_REQUEST["status"];
            $this->assign('status',$_REQUEST['status']);
        }
        $areaname=M('area')->field('id,areaname')->select();
        // dump($areaname);
        if($areaname){
            $this->assign('areaname',$areaname);
        }
        import('ORG.Util.Page');// 导入分页类
        $count=$model->where($map)->count();// 查询满足要求的总记录数
        $Page= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $lists=$model->field('sk_business.id,sk_area.areaname,sk_business.address,sk_business.name,sk_business.comment,sk_business.createtime,sk_business.status')->where($map)->join('sk_area on sk_business.areaid=sk_area.id')->order('sk_business.areaid asc,sk_business.createtime desc,sk_business.status desc')->limit($Page->firstRow.','.$Page->listRows)->select();
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
            $result=M("Business")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Business/index",$_GET);
                exit;
            }else{
                $this->redirect("Business/index",$_GET);
                exit;
            }
        }
        public function insert(){
            if(!empty($_POST['createtime'])){
                $_POST['createtime']=strtotime($_POST['createtime']);
            }
            parent::insert("Business",0);
        }
        public function update(){
            if(!empty($_POST['createtime'])){
                $_POST['createtime']=strtotime($_POST['createtime']);
            }
            parent::update("Business",0);
        }
        
        public function add(){  
            $area = D("Area")->select(); 
            $this->assign("area",$area);      
            parent::add();
        }
        public function edit(){        
            $model = D("Business")->relation(true);
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            $areamodel = D("area");
            $area = $areamodel->where("id<>".$vo['areaid'])->select();
            $this->assign('vo', $vo);
            $this->assign("area",$area);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("Business");
        }
}