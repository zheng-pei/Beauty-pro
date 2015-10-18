<?php
class BackAction extends BaseAction{
    protected $pid;
    protected function _initialize(){ 
            parent::_initialize();
             if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //判断是否登录，然后跳转到登录页面
                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                    exit;
            }
            $modulename=MODULE_NAME;
            $actionname=ACTION_NAME;

            if($this->isauth($_SESSION [C('USER_AUTH_KEY')],$modulename,$actionname)||($modulename=='Index')||($modulename=='Comment')){
              
                if($this->isauth($_SESSION [C('USER_AUTH_KEY')],"Order","index")){
                    $this->assign("showorder",1);
                }else{
                    $this->assign("showorder",0);
                }
                $this->show_menu();
            }else{
                  $this->error("对不起，您没有操作权限",'',1);
                exit;
            }
            //获取操作权限
            $operations=M("role")->where("id=(select roleid from sk_user where sk_user.id=".$_SESSION [C('USER_AUTH_KEY')].")")->getField("operation");
            $this->operationarr=array_filter(explode(",",$operations));
            $this->assign("operationarr", $this->operationarr);
            foreach ($_POST as $key => $value) {
                $this->assign($key, $value);
                $_GET[$key]=$value;
            }
            foreach ($_GET as $key => $value) {
                $this->assign($key, $value);
            }
             
    }
    
    private function show_menu(){
            //正式上线的时候注释语句将会取消
//            if(empty($_SESSION ['menuarr'])){
                $unodeids=M("role")->where("id=(select roleid from sk_user where sk_user.id=".$_SESSION [C('USER_AUTH_KEY')].")")->getField("node");
                if($unodeids=='all'){
                    $unodearr=M("node")->order('sort asc')->select();
                }else{
                    $unodearr=M("node")->where("id in (".$unodeids.")")->order('sort asc')->select();
                }
                //dump($unodearr);


                for($i=3;$i>=1;$i--){
                    $parr=array();    

                    foreach($unodearr as $k=>$v){
                        if($i==3){
                            $v['url']=U($v['module']."/".$v['action'],$v["params"]);
                        }
                        $menuarr[$i][$v['pid']][]=$v;
                        if(!in_array($v['pid'], $parr)){
                            $parr[]=$v["pid"];
                        }
                    }
                    
                    $unodearr=M("node")->where(array("id"=>array("in",$parr)))->order('sort asc')->select();
        
                }
            $this->assign("menus1", $menuarr[1][0]);
            $this->assign("menus2", $menuarr[2]);
            $this->assign("menus3", $menuarr[3]);
    }
        //判断是否有权限
        public function isauth($ukey,$modulename,$actionname){
            $map=array();
            $map["module"]=$modulename;
           // $map["action"]=$actionname;
            $map["level"]=array('gt',1);
            $map["pid"]=array('neq',0);
            $nodeids=M("node")->where($map)->getField("id");
            $unodeids=M("role")->where("id=(select roleid from sk_user where sk_user.id=".$ukey.")")->getField("node");
            if($unodeids=='all'){
                return true;    
            }else{
            $unodeids=",".trim($unodeids,",").",";
                if(strpos($unodeids, ",".$nodeids.",")===FALSE){
                    return false;
                }else{
                    return true;
                }
            }
        }

        public function success($message,$jumpUrl='',$type=0,$ismodal=0){
        if($type==1){
            parent::success($message,$jumpUrl);
        }else{
                    $data['errno']=0;
                    //$data['tip']=$message;
                    $data['error']=$message;
                    $data['url']=$jumpUrl;
                    if($ismodal==1){
                        $data['modal']=1;
                    }
                    echo json_encode($data);
        }
    }
    public function error($message,$jumpUrl='',$type=0){
        if($type==1){
            parent::error($message,$jumpUrl);
        }else{
                    $data['errno']=1;
                    //$data['tip']=$message;
                    $data['error']=$message;
                    $data['url']=$jumpUrl;
                    echo json_encode($data);
        }
    }

    //更新
     protected function updateService($name='',$imagetype=2){
            if($name==''){
                $this->error("模型错误");
                exit;
            }
            $model = D($name);
            
            $map=array();
            foreach ($model->getDbFields() as $key => $val) {
                if (isset($_REQUEST [$val]) && $_REQUEST [$val] != ''&&!empty($_REQUEST [$val])) {
                    $map[$val] = $_REQUEST [$val];
                }
            }
       
            $map['updatetime']=time();

           if (false === $model->create()) {
                $this->error($model->getError());
                exit;
            }
            $list = $model->save($map);
           // dump($_POST["phout_url"]);exit;
            if ($list !== false) { //保存成功
                
                $model=M('ablum');
                //更新图集
                if(isset($_POST["phout_url"])){
                    $data=array();
                    foreach($_POST["phout_url"] as $k=>$v){
                            $data[$k]['id']      = $_POST["phout_list"][$k];
                            $data[$k]['picurl']  = $v;
                            $data[$k]['picname'] = $_POST["imagestexts"][$k];
                            $data[$k]['imgtype'] = $imagetype;//$_POST['imgtype'];房间类型
                            $data[$k]['imgkind'] = 'ablum';
                            $data[$k]['relatid'] = $map['id'];
                            $data[$k]['sort']    = $_POST["photosort"][$k];                       
                    }
                   
                    if (false === $model->create()) {
                        $this->error($model->getError());
                        exit;
                    }
                    foreach ($data as $value) {
                        if(isset($value['id'])){
                            $model->save($value);
                        }else{
                            $model->add($value);
                        }  
                    }
                   
                } 

                //更新360全景
                if(isset($_POST["phout_url_overall"])&&count($_POST["phout_url_overall"])==6){
                    $data=array();
                    foreach($_POST["phout_url_overall"] as $k=>$v){
                            $data[$k]['id']      = $_POST["phout_list_overall"][$k];
                            $data[$k]['picurl']  = $v;
                            $data[$k]['picname'] = $_POST["imagestexts_overall"][$k];
                            $data[$k]['imgtype'] = $imagetype;//$_POST['imgtype'];房间类型
                            $data[$k]['imgkind'] = 'overall';
                            $data[$k]['relatid'] = $map['id'];
                            $data[$k]['sort']    = $_POST["photosort_overall"][$k];                       
                    }
                    if (false === $model->create()) {
                        $this->error($model->getError());
                        exit;
                    }
                    foreach ($data as $value) {
                        if(isset($value['id'])){
                            $model->save($value);
                        }else{
                             $model->add($value);
                        }  
                    }
                }
                $this->success('新增成功!',cookie('_currentUrl_'));
                exit;
            } else {
                //失败提示
                $this->error('新增失败!');
                exit;
            }
        }

    //全景
     public function item(){
            $map=array();
            $map["relatid"]=intval($_GET['id']);
            $map["imgtype"]=intval($_GET['imgtype']);
            $map["imgkind"]='overall';
            $itemlist=M('ablum')->where($map)->select();

            $item['frontpic']=$itemlist[0]['picurl'];//前 
            $item['rightpic']=$itemlist[1]['picurl'];//右
            $item['backpic']=$itemlist[2]['picurl'];//后
            $item['leftpic']=$itemlist[3]['picurl'];//左
            $item['toppic']=$itemlist[4]['picurl'];//上
            $item['bottompic']=$itemlist[5]['picurl'];//下

            $this->assign('item',$item);
            if (isset($_GET['o'])){
                header("Content-type: text/xml");

$titleurl_str = '';
$key=0;
foreach($item as $k=>$value){
    $titleurl_str .= ' tile'.$key.'url="'.$value.'" ';
    $key++;
}
echo<<<str
    
    <panorama id="" hideabout="1"> <view fovmode="0" pannorth="0"> <start
        pan="5.5" fov="80" tilt="1.5" /> <min pan="0" fov="80" tilt="-90" /> <max
        pan="360" fov="80" tilt="90" /> </view> <userdata title=""
        datetime="2013:05:23 21:01:02" description="" copyright="" tags=""
        author="" source="" comment="" info="" longitude="" latitude="" /> <hotspots
        width="180" height="20" wordwrap="1"> <label width="180"
        backgroundalpha="1" enabled="1" height="20" backgroundcolor="0xffffff"
        bordercolor="0x000000" border="1" textcolor="0x000000" background="1"
        borderalpha="1" borderradius="1" wordwrap="1" textalpha="1" /> <polystyle
        mode="0" backgroundalpha="0.2509803921568627"
        backgroundcolor="0x0000ff" bordercolor="0x0000ff" borderalpha="1" /> </hotspots>
    <media /> <input tilesize="700" tilescale="1.014285714285714"
        $titleurl_str />
    <autorotate speed="0.200" nodedelay="0.00" startloaded="1"
        returntohorizon="0.000" delay="5.00" /> <control simulatemass="1"
        lockedmouse="0" lockedkeyboard="0" dblclickfullscreen="0"
        invertwheel="0" lockedwheel="0" invertcontrol="1" speedwheel="1"
        sensitivity="8" /> </panorama>
str;
                //$this->display('itemXML');
            }else {
                $this->display();
            }
        }

    //上传图像文件
    public function uploads(){
        if (!empty($_FILES)) {
        import('ORG.Util.UploadFile');
        $upload = new UploadFile();
       
        //设置上传文件大小
        $upload->maxSize = 3292200;
        //设置上传文件类型
        $upload->exts = explode(',','jpg,gif,png,jpeg');
        //设置附件上传目录
        $upload->rootPath="./";

        $upload->savePath = './Uploads/ablum/';
        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;
        //设置上传文件规则
        $upload->saveName = array('uniqid','');
        $info=$upload->upload();
        if (!$info) {
            //捕获上传异常
            echo $upload->getErrorMsg();
        }else{
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            
            $result['result']="SUCCESS";
            preg_match('/.*\/(.*)/',str_replace('.'.$uploadList[0]['extension'],'',$uploadList[0]['savename']),$result['image']['picname']);
            $result['image']['picname']=$result['image']['picname'][1];
            $result['image']['picurl']=$uploadList[0]['savepath'].$uploadList[0]['savename'];
            echo json_encode($result);
        }

        }

    }
    //删除文件
    public function delimg(){
        if($_POST['imgurl']!=""){
            $url=$_POST['imgurl'];
            if($_POST['imgid']!=""){
                M("ablum")->where("id=".$_POST['imgid'])->delete();
            }
        
            if(unlink($url)){
                $result['result']="SUCCESS";
            }
            else{
                $result['result']="Fail";
            }
        }else{
            $result['result']="Fail";
        }
        echo json_encode($result);
    }
      

        
}