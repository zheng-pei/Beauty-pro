<?php
class MemberAction extends BackAction{
        protected function _initialize(){
            parent::_initialize();
        }
        public function _filter(&$map){
            //查询条件获取
            
            if(isset($_REQUEST['nickname'])&&$_REQUEST['nickname']!=''){
                $map['nickname']=array("like","%".$_REQUEST['nickname']."%");
            }
            if(isset($_REQUEST['truename'])&&$_REQUEST['truename']!=''){
                $map['truename']=array("like","%".$_REQUEST['truename']."%");
            }
            if(isset($_REQUEST['phone'])&&$_REQUEST['phone']!=''){
                $map['phone']=array("like","%".$_REQUEST['phone']."%");
            }
            if(isset($_REQUEST['openid'])&&$_REQUEST['openid']!=''){
                $map['openid']=array("like","%".$_REQUEST['openid']."%");
            }
        }
    public function index(){
            $_REQUEST['_order']='createtime';
            $_REQUEST['_sort']='desc';
            parent::relationindex();
    }
    // 签到记录
    public function signlist(){
            $_REQUEST['_order']='createtime';
            $_REQUEST['_sort']='desc'; 
            $memberid=$_GET['memberid'];
            $name=D("Member")->where("id=".$memberid)->getField("nickname");
            $this->assign("voname",$name);
            parent::index("Signrecord");
            //parent::relationindex("Signrecord");
        }

        public function add(){    
            
            parent::add();
        }
        public function edit(){
            
            parent::edit();
        }
        
        public function update(){
            $ismodal=empty($_POST["ismodal"])?0:1;
            parent::update("",1,$ismodal);
        }
}
?>