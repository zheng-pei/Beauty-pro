<?php
class ServiceAction extends BackAction
{
    protected function _initialize(){
        parent::_initialize();
    }
    public function _filter(&$map){

        if(isset($_REQUEST['areaid'])&&$_REQUEST['areaid']!=''){
            $map['areaid']=array("eq",$_REQUEST['areaid']);
        }
        if(isset($_REQUEST['classid'])&&$_REQUEST['classid']!=''){
            $map['classid']=array("eq",$_REQUEST['classid']);
        }
        if(isset($_REQUEST['name'])&&$_REQUEST['name']!=''){
            $map['name']=array("like","%".$_REQUEST['name']."%");
        } 
    }
    public function index(){
        $_REQUEST['_order']='createtime';
        $_REQUEST['_sort']='desc';
        $areas = D("Area")->field("id,areaname")->select();
        $types = D("Servicetype")->field("id,classname")->select();
        $this->assign("areas",$areas);
        $this->assign("types",$types);
        parent::relationindex();
    }
    
    
	 public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Service")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
             if($result!==FALSE){
                $this->redirect("Service/index",$_GET);
                exit;
            }else{
                $this->redirect("Service/index",$_GET);
                exit;
            } 
        }
        public function insert(){
            $_POST['createtime']=time();
            if(!empty($_POST['lab'])){
                $_POST['lab']=implode($_POST['lab'], ",");
            }
            parent::insert();
        }
        public function update(){
            //var_dump($_POST);
            if(!empty($_POST['lab'])){
                $_POST['lab']=implode($_POST['lab'], ",");
            }
            parent::update("service",0);
        }
        
        public function add(){    
             $area = D("Area")->select(); 
             $type = D("servicetype")->select();
            $this->assign("area",$area);
            $this->assign("type",$type);
            $this->getservicelab();
            parent::add();
        }
        public function edit(){
            $id=$_GET['id'];
            $model=D("service");
            $services = $model->find($id);
            $areaid = $services['areaid'];
            $classid = $services['classid'];
            $selareas = D("area")->find($areaid);
            $selclass = D("servicetype")->find($classid);
            $this->assign("selarea",$selareas);
            $this->assign("seltype",$selclass);
            $area = D("Area")->where("id<>".$areaid)->select();
            $type = D("servicetype")->where("id<>".$classid)->select();
            $this->assign("area",$area);
            $this->assign("type",$type);
            $this->getservicelab();
            $labarray = explode(",", $services['lab']);
            $this->assign("labarray",$labarray);
            $this->assign("serviceinfo",$services);
            $this->display() ;    
        }
        public function delete(){
            parent::foreverdelete("Service");
        }
        //获得服务标签列表数据
        public function getservicelab(){
            $servicelab = D("servicelab")->field("id,labname")->select();
            $this->assign("servicelab",$servicelab);
        }
        
        //步骤管理主页
        public function stepindex(){
            //查找该项目对应的步骤列表
            $serviceid=$_GET['serviceid'];
            $_REQUEST['_order']='sort';
            $_REQUEST['_sort']='asc';
            $servicename = D("Service")->find($serviceid);
            $this->assign("servicename",$servicename);
            parent::index("servicestep");
        
        }
        
        //展示新增步骤页面
        public function addstep(){
            $this->assign("serviceid",$_GET['serviceid']);
            parent::add();
        }
        //插入新步骤
        public function insertstep(){
            $_POST['serviceid']=$_GET['serviceid'];
            parent::insert("servicestep");
        }
        //更新步骤数据
        public function updatestep($id){
            parent::update("servicestep");
        }
        
        public function editstep(){
            parent::edit("servicestep");
        }
        public function deletestep(){
            $serviceid = $_REQUEST['serviceid'];
            $result = D("servicestep")->delete($_REQUEST['id']);
            if($result!=false){
                $this->redirect(U("stepindex","serviceid=$serviceid"));
            }else{
                $this->error("删除失败！");
            }
            //parent::delete("servicestep");
        }
        
}