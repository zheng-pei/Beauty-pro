<?php
class SettingAction extends BackAction
{

     public function index(){
        $this->assign('vo',M('setting')->find());
        cookie('_currentUrl_', __SELF__);
        $this->display();

     }
     /* public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("setting")->where($map)->setField("is_show", $_GET["is_show"]);
            unset($_GET["id"]);
            unset($_GET["is_show"]);
            if($result!==FALSE){
                $this->redirect("Setting/index",$_GET);
                exit;
            }else{
                $this->redirect("Setting/index",$_GET);
                exit;
            }
        } */
         public function insert(){
            parent::insert("setting",0);
        } 
        public function update(){
            $id=M('setting')->getField("id");
            if(!empty($id)){
              parent::update("setting",0);
            }
            parent::insert("setting",0);
        }
        
        /* public function add(){        
            parent::add();
        } */
        /* public function edit(){        
            //$this->getrolelist();
            
            $model = D("setting");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
           
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function delete(){
            parent::foreverdelete("user");
        } */
}