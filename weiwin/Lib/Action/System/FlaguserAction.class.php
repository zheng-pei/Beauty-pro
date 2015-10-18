<?php
class FlaguserAction extends BackAction{
	public function index(){

            parent::relationindex("User");
	}
        public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("user")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Flaguser/index",$_GET);
                exit;
            }else{
                $this->redirect("Flaguser/index",$_GET);
                exit;
            }
        }
        
        public function add(){        
            $this->getrolelist();
            parent::add();
        }
        public function edit(){        
            $this->getrolelist();
            
            $model = D("User");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->relation(true)->getById($id);
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }
        public function insert(){
            $_POST["password"]= md5(md5($_POST['password']));
            parent::insert("User",1);
        }
        public function update(){
           
            parent::update("User",1);
        }
        public function getrolelist(){
            $rolelist=M("role")->select();
            $this->assign("rolelist", $rolelist);
        }
        public function delete(){
            parent::foreverdelete("user");
        }
        //修改密码
        public function changepwd(){
            $oldpwd=M("user")->find($_SESSION[C('USER_AUTH_KEY')]);
            $oldpassword=md5(md5($_POST['oldpassword']));
            if($oldpassword!=$oldpwd["password"]){
                $this->error("您的原始密码填写不正确");
                exit;
            }else{
                if($_POST['newpassword']!=$_POST['newpassword2']){
                    $this->error("密码及确认密码填写不一致");
                    exit;
                }else{
                    $result=M("user")->where(array("id"=>$_SESSION[C('USER_AUTH_KEY')]))->setField("password", md5(md5($_POST['newpassword'])));
                    $this->success("密码修改成功");
                    exit;
                }
            }
        }
        //重置密码
        
        
        public function glmember(){
            if($_POST["id"]!=""&&$_POST["memberid"]!=""){
                if($_POST["oldmemberid"]!=$_POST["memberid"]){
                    M("member")->where("id=".$_POST["oldmemberid"])->setField("memtype", 1);
                    $result=D("User")->where("id=".$_POST["id"])->setField("memberid", $_POST["memberid"]);
                    
                }
                
            }else{
                echo "fail";
                exit;
            }
            
        }
        
}
?>