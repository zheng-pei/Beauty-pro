<?php
class ServicetypeAction extends BackAction
{

	 public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Servicetype")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Servicetype/index",$_GET);
                exit;
            }else{
                $this->redirect("Servicetype/index",$_GET);
                exit;
            }
        }
        public function insert(){
            parent::insert("Servicetype",0);
        }
        public function update(){
            parent::update("Servicetype",0);
        }
        
        public function add(){        
            parent::add();
        }
        public function edit(){        
           
            
            $model = D("Servicetype");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("Servicetype");
        }
}