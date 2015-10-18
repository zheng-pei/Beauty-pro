<?php
class WeixinAction extends BackAction
{
    //微信基本设置
     public function index(){
       
        $this->assign('vo',M('setting')->find());
       
        $this->display();

     }

     //微信菜单设置
     public function menu(){
        $this->display();
     }

   
      //更新微信菜单
     public function updateMenu(){
         echo "更新成功";
     }

     //微信关键词
     public function addMenu(){
        $this->display();
     }

     //微信关键词
     public function keyword(){
        parent::index('keyword');
     }


     //添加关键词
     public function addKeyWord(){
        $this->display();
     }

     public function insertKeyWord(){

          $model = D("keyword");
            $map=array();
            foreach ($model->getDbFields() as $key => $val) {
                if (isset($_REQUEST [$val]) && $_REQUEST [$val] != ''&&!empty($_REQUEST [$val])) {
                    $map[$val] = $_REQUEST [$val];
                }
            }
           
            if (false === $model->create()) {
                $this->error($model->getError());
                exit;
            } 
            $list = $model->add($map);

             if ($list !== false) { //保存成功
                $this->success('新增成功!',cookie('_currentUrl_'));
                exit;
            } else {
                //失败提示
                $this->error('新增失败!');
                exit;
            }
       
     }



     public function changestatusKW(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("keyword")->where($map)->setField("is_show", $_GET["is_show"]);
            unset($_GET["id"]);
            unset($_GET["is_show"]);
            if($result!==FALSE){
                $this->redirect("Weixin/keyword",$_GET);
                exit;
            }else{
                $this->redirect("Weixin/keyword",$_GET);
                exit;
            }
        }
        public function insert(){
            parent::insert("setting",0);
        }
        public function update(){

            parent::update("setting",0);
        }
        
        public function add(){        
            parent::add();
        }
        public function edit(){        
            //$this->getrolelist();
            
            $model = D("setting");
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
           
            $this->assign('vo', $vo);
            $this->display();
//            parent::edit("User");
        }


        public function deleteKW(){
             //删除指定记录
      
        $model = D('keyword');
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];

            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
             
                if (false !== $model->where($condition)->delete()) {
                    //$model->_after_foreverdelete();
                    unset($_REQUEST [$pk]);
                   $this->redirect(MODULE_NAME."/keyword",$_REQUEST);
                   exit;
                } else {
                    $this->error('删除失败！');
                    exit;
                }
            } else {
                $this->error('非法操作');
                exit;
            }
        }
        $this->forward();
        }
}