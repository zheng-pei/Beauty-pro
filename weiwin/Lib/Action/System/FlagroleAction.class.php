<?php
class FlagroleAction extends BackAction{
    public $nodelist=array();
    public function index(){
	   parent::index("Role");
    }
    public function add(){
        
        $this->getnodelist();
        $this->assign("nodelist",$this->nodelist);
//        var_dump($this->nodelist);
        parent::add();
    }
    public function insert(){
        $_POST["node"]=  implode(",", $_POST['node']);
        $_POST["operation"]=  implode(",", $_POST['operation']);
        parent::insert("Role");
    }
    public function edit(){
        $this->getnodelist();
        $this->assign("nodelist",$this->nodelist);
        $selnodes=$this->getselnodes($_GET["id"]);
        $this->assign("selnodes",$selnodes);
        parent::edit("Role");
    }
    public function update(){
        $_POST["node"]=  implode(",", $_POST['node']);
        $_POST["operation"]=  implode(",", $_POST['operation']);
        parent::update("Role");
    }
    public function delete() {
        parent::foreverdelete("Role");
    }

    public function getnodelist($level=1,$pid=0){
        if($level>2){
            return ;
        }
        $map=array();
        $map["level"]=$level;
        $map["pid"]=$pid;
        $nodelist=M("node")->where($map)->order('sort asc')->select();
        foreach($nodelist as $k=>$v){
            if($level==2){
                $childids=M("node")->where('pid='.$v['id'])->getField("id",true);
                $v['nodeids']=  implode(",", $childids);
            }
            $this->nodelist[]=$v;
            $this->getnodelist($level+1,$v["id"]);
        }
    }
    public function getselnodes($roleid){
        $nodes=M("role")->where("id=".$roleid)->getField("node");
        if($nodes=="all"){
             $selnodes=M("node")->where(1)->getField("pid",true);
        }elseif($nodes!=""){
            $selnodes=M("node")->where("id in (".$nodes.")")->getField("pid",true);
        }
        return $selnodes;
    }
}
?>