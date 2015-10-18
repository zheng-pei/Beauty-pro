<?php
class AreaAction extends BackAction
{

	 public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Area")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Area/index",$_GET);
                exit;
            }else{
                $this->redirect("Area/index",$_GET);
                exit;
            }
        }
        public function insert(){
            $_POST['createtime']=time();
            parent::insert("Area",0);
        }
        public function update(){
            parent::update("Area",0);
        }
        
        public function add(){        
            parent::add();
        }
        public function edit(){        
           
            
            $model = D("Area");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("Area");
        }
}