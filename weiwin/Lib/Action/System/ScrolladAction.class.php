<?php
class ScrolladAction extends BackAction
{


	 public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("scrollad")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Scrollad/index",$_GET);
                exit;
            }else{
                $this->redirect("Scrollad/index",$_GET);
                exit;
            }
        }
        public function insert(){
            $_POST['createtime']=time();
            parent::insert("scrollad",0);
        }
        public function update(){
            parent::update("scrollad",0);
        }
        
        public function add(){        
            parent::add();
        }
        public function edit(){        
           
            
            $model = D("scrollad");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("scrollad");
        }
}