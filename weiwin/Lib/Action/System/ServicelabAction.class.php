<?php
class ServicelabAction extends BackAction
{

	 public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Servicelab")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Servicelab/index",$_GET);
                exit;
            }else{
                $this->redirect("Servicelab/index",$_GET);
                exit;
            }
        }
        public function insert(){
            parent::insert("Servicelab",0);
        }
        public function update(){
            parent::update("Servicelab",0);
        }
        
        public function add(){        
            parent::add();
        }
        public function edit(){        
           
            
            $model = D("Servicelab");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("Servicelab");
        }
}