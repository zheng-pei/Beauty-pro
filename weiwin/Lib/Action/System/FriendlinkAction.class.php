<?php
class FriendlinkAction extends BackAction
{


     public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("friendlink")->where($map)->setField("is_show", $_GET["is_show"]);
            unset($_GET["id"]);
            unset($_GET["is_show"]);
            if($result!==FALSE){
                $this->redirect("Friendlink/index",$_GET);
                exit;
            }else{
                $this->redirect("Friendlink/index",$_GET);
                exit;
            }
        }
        public function insert(){

            parent::insert("friendlink",0);
        }
        public function update(){
           //  dump($_COOKIE);
           // echo cookie('_currentUrl_');
            parent::update("friendlink",0);
        }
        
        public function add(){        
            parent::add();
        }
        public function edit(){  

            //$this->getrolelist();
            
            $model = D("friendlink");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
           
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("friendlink");
        }
}