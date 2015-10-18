 <?php
class BaseAction extends Action
{
    protected function _initialize() 
    {
//        define('STATICS', TMPL_PATH . 'static');
        define('STATICS', '/tpl/static');
//	define('RES', TMPL_PATH . 'static/'.GROUP_NAME);
        define('RES',  '/tpl/static/'.GROUP_NAME);
        $this->assign('action', $this->getActionName());
    }  
    public function index($name="") {
		if(empty($name)){
        	$name = MODULE_NAME;
		}
		
        //列表过滤器，生成查询Map对象
        $map = $this->_search($name);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }

        
        $model = D($name);
        if (!empty($model)) {
            $this->_list($model, $map);
        }
        $this->display();
        return;
    }

    public function relationindex($name=""){
        if(empty($name)){
        	$name = MODULE_NAME;
		}
		
        //列表过滤器，生成查询Map对象
        $map = $this->_search($name);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }


        $model = D($name);
        if (!empty($model)) { 
            $this->_relationlist($model, $map);
        }

        $this->display();
        return;
    }
    /**
      +----------------------------------------------------------
     * 取得操作成功后要返回的URL地址
     * 默认返回当前模块的默认操作
     * 可以在action控制器中重载
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    function getReturnUrl() {
        return __URL__ . '?' . C('VAR_MODULE') . '=' . MODULE_NAME . '&' . C('VAR_ACTION') . '=' . C('DEFAULT_ACTION');
    }

    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param string $name 数据对象名称
      +----------------------------------------------------------
     * @return HashMap
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _search($name = '') {
        //生成查询条件
        if (empty($name)) {
            $name =MODULE_NAME;
        }
       // $name = MODULE_NAME;
        $model = D($name);
        $map = array();
        foreach ($model->getDbFields() as $key => $val) {
            if (isset($_REQUEST [$val]) && !empty($_REQUEST [$val])) {
                $map [$val] = $_REQUEST [$val];
            }
        }
        return $map;
    }

    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _list($model, $map, $sortBy = '', $asc = false) {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? $_REQUEST ['_sort']  : 'asc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        //取得满足条件的记录数
        $count = $model->where($map)->count('id');
//        echo $model->getLastSql();
        $this->assign("totalcount", $count);
        if ($count > 0) {
           // import("@.ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = 10;
            }
	    import('ORG.Util.Page');
            $p = new Page($count, $listRows);
			
            //分页查询数据

            $voList = $model->where($map)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
//             echo $model->getLastSql();
            //分页跳转的时候保证查询条件
//            foreach ($map as $key => $val) {
//                if (!is_array($val)) {
//                    $p->parameter .= "$key=" . urlencode($val) . "&";
//                }
//            }

            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        cookie('_currentUrl_', __SELF__);
        return;
    }
     protected function _relationlist($model, $map, $sortBy = '', $asc = false) {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序

        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? $_REQUEST ['_sort'] : 'asc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
//        echo $sort;
        //取得满足条件的记录数
        $count = $model->relation(true)->where($map)->count('id');

         // echo $model->relation(true)->getLastSql();
        $this->assign("totalcount", $count);
        if ($count > 0) {
           // import("@.ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows =10;
            }
	    import('ORG.Util.Page');
            $p = new Page($count, $listRows);
			
            //分页查询数据
 
            $voList = $model->relation(true)->where($map)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
//            var_dump($voList);
          // echo $model->relation(true)->getLastSql();
            //分页跳转的时候保证查询条件
//            foreach ($map as $key => $val) {
//                if (!is_array($val)) {
//                    $p->parameter .= "$key=" . urlencode($val) . "&";
//                }
//            }

            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            //var_dump($voList);
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        cookie('_currentUrl_', __SELF__);
        return;
    }
    function insert($name="",$isrelation=0) {
		if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        if($isrelation==1){
            if (false === $model->relation(true)->create()) {
                $this->error($model->getError());
                exit;
             }
        }else{
            if (false === $model->create()) {
                $this->error($model->getError());
                exit;
            }
        }
        //保存当前数据对象
        $list = $model->add();
        if ($list !== false) { //保存成功
            $this->success('新增成功!',cookie('_currentUrl_'));
            exit;
        } else {
            //失败提示
            $this->error('新增失败!');
            exit;
        }
    }

    function read() {
        $this->edit();
    }
    function add() { 
        $this->display();
    }
    function edit($name="") {
       if (empty($name)) { 
            $name =MODULE_NAME;
        }
        $model = M($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getById($id);
        $this->assign('vo', $vo);
        $this->display();
    }

    function update($name="",$isrelation=0,$ismodal=0) {
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
         if($isrelation==1){
             if (false === $model->relation(true)->create()) {
                $this->error($model->getError());
                exit;
             }
         }else{
            if (false === $model->create()) {
                $this->error($model->getError());
                exit;
            }
         }
        
        // 更新数据
        $list = $model->save();
        //dump($_COOKIE);
         // echo $_COOKIE['_currentUrl_'];
         // exit;
        if (false !== $list) {
            //成功提示
            $this->success('编辑成功!',cookie('_currentUrl_'),0,$ismodal);
            exit;
        } else {
            //错误提示
            $this->error('编辑失败!');
            var_dump($list);
            exit;
        }
    }

    /**
      +----------------------------------------------------------
     * 默认删除操作
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    public function delete($name="") {
        //删除指定记录
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = M($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $list = $model->where($condition)->setField('status', - 1);
                if ($list !== false) {
//                    $this->_after_delete();
                    $this->redirect($name."/index");
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
    }

    public function foreverdelete($name = '') {
        //删除指定记录
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];

            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
             
                if (false !== $model->where($condition)->delete()) {
                    //$model->_after_foreverdelete();
                    unset($_REQUEST [$pk]);
                   $this->redirect(MODULE_NAME."/index",$_REQUEST);
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

    public function clear($name = '') {
        //删除指定记录
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        if (!empty($model)) {
            if (false !== $model->where('status=1')->delete()) {
                $this->success(L('_DELETE_SUCCESS_'),$this->getReturnUrl());
                exit;
            } else {
                $this->error(L('_DELETE_FAIL_'));
                exit;
            }
        }
        $this->forward();
    }

    /**
      +----------------------------------------------------------
     * 默认禁用操作
     *
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws FcsException
      +----------------------------------------------------------
     */
    public function forbid($name = '') {
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        $pk = $model->getPk();
        $id = $_REQUEST [$pk];
        $condition = array($pk => array('in', $id));
        $list = $model->where($condition)->setField("status",0);
        if ($list !== false) {
            //$this->success('状态禁用成功',$this->getReturnUrl());
            $this->redirect($name."/index");
            exit;
        } else {
            $this->error('状态禁用失败！');
            exit;
        }
    }

    public function checkPass($name = '') {
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->checkPass($condition)) {
            $this->success('状态批准成功！',$this->getReturnUrl());
            exit;
        } else {
            $this->error('状态批准失败！');
            exit;
        }
    }

    public function recycle($name = '') {
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->where($condition)->setField("status",1)) {
            $this->redirect($name."/index");
            exit;
        } else {
            $this->error('状态还原失败！');
            exit;
        }
    }

    public function recycleBin() {
        $map = $this->_search();
        $map ['status'] = - 1;
        $name = MODULE_NAME;
        $model = D($name);
        if (!empty($model)) {
            $this->_list($model, $map);
        }
        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 默认恢复操作
     *
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws FcsException
      +----------------------------------------------------------
     */
    function resume($name = '') {
        //恢复指定记录
        if (empty($name)) {
            $name =MODULE_NAME;
        }
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->resume($condition)) {
            $this->success('状态恢复成功！',$this->getReturnUrl());
            exit;
        } else {
            $this->error('状态恢复失败！');
            exit;
        }
    }

    function saveSort($name = '') {
        $seqNoList = $_POST ['seqNoList'];
        if (!empty($seqNoList)) {
            //更新数据对象
            if (empty($name)) {
            	 $name =MODULE_NAME;
        	  }
            $model = D($name);
            $col = explode(',', $seqNoList);

            try {
                // 开启事务
                $model->startTrans();
                foreach ($col as $val) {
                    $val = explode(':', $val);
                    $model->id   = $val [0];
                    $model->sort = $val [1];
                    $result = $model->save();
                    if (!$result) {
                        // 循环插入数据的过程中，一旦出现错误，立刻抛出异常 (在catch中去进行回滚操作)
                        throw new PDOException('save error');
                    }
                }
                // 提交事务
                $res = $model->commit();

                if ($res !== false) {
                    // 采用普通方式跳转刷新页面
                    $this->success('更新成功');
                    exit;
                } else {
                    // 当然 也可以使用自定义的错误提示
                    $this->error($model->getError());
                    exit;
                }

            } catch (PDOException $e) {
                // 事务回滚 撤销以上所有操作，保证数据的一致性
                $model->rollback();
                // 当然 也可以使用自定义的错误提示
                $this->error($model->getError());
            }
            
        }
    }
    public function _upload($typestr='jpg,gif,png,jpeg'){
		import("@.ORG.UploadFile");
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 3292200;
		//设置上传文件类型
		$upload->allowExts = explode(',',$typestr);
		//设置附件上传目录
		$upload->savePath = './data/attachments/';
		//设置需要生成缩略图，仅对图像文件有效
		$upload->thumb = true;
		// 设置引用图片类库包路径
		$upload->imageClassPath = '@.ORG.Image';
		//设置需要生成缩略图的文件后缀
		$upload->thumbPrefix = 'm_';
		//生产2张缩略图
		//设置缩略图最大宽度
		$upload->thumbMaxWidth = '720';
		//设置缩略图最大高度
		$upload->thumbMaxHeight = '400';
		//设置上传文件规则
		$upload->saveRule = uniqid;
		//删除原图
		//$upload->thumbRemoveOrigin = true;
		if (!$upload->upload()) {
			//捕获上传异常
			return $upload->getErrorMsg();
		}else{
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
			return $uploadList;
		}
	}
	public function showpage($Products,$map,$pagesize,$str,$order='id asc',$field=""){
		import('ORG.Util.Page');// 导入分页类
		$count = $Products->where($map)->count();// 查询满足要求的总记录数
		 $this->assign("count",$count);// 实例化分页类 传入总记录数
		// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取		
		$nowPage = isset($_GET['p'])?$_GET['p']:1;
               $this->assign("nowpage",$nowPage);
               $this->assign("pagesize",$pagesize);
		$Page = new Page($count,$pagesize);
		$Page->rollPage = 5;
		if(!empty($field)){
                 $list = $Products->field($field)->where($map)->order($order)->page($nowPage.','.$Page->listRows)->select();   
                }else{
		$list = $Products->where($map)->order($order)->page($nowPage.','.$Page->listRows)->select();
                }
		$show = $Page->show();						// 分页显示输出
		$this->assign($str,$list);
		$this->assign('page',$show);				// 赋值分页输出	
	}
	public function sendCardCheckCode(){
		$data=array();
		$data['errno']	=0;
		echo json_encode($data);
	}
	
        public function UploadHandler($typestr='jpg,gif,png,jpeg') {
           import("@.ORG.UploadFile");
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 3292200;
		//设置上传文件类型
		$upload->allowExts = explode(',',$typestr);
		//设置附件上传目录
		$upload->savePath = './data/attachments/';
		//设置需要生成缩略图，仅对图像文件有效
		$upload->thumb = false;
		// 设置引用图片类库包路径
		$upload->imageClassPath = '@.ORG.Image';
		//设置需要生成缩略图的文件后缀
		//设置上传文件规则
		$upload->saveRule = uniqid;
		if (!$upload->upload()) {
			//捕获上传异常
			echo $upload->getErrorMsg();
		}else{
			//取得成功上传的文件信息
                    
			$uploadList = $upload->getUploadFileInfo();
			echo $uploadList[0]['savepath'].$uploadList[0]['savename']."|".str_replace(".".$uploadList[0]['extension'], "", $uploadList[0]['savename']);
		}
        }
        
        public function export($elist,$label,$filename){
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Expires:0'); 
            header('Pragma:public');

            
            $astr=implode("\t",$label)." \r\n";
            foreach($elist as $k=>$v){
               $astr.= implode("\t",$v)." \r\n";
            }
            $astr=iconv("utf-8","gb2312",$astr);
//            $astr="\xEF\xBB\xBF".$astr;
            echo $astr;
            
        }
       
        public function import($filename,$model,$sign,$elist,$islabel,$where=array(),$guanlian=array()){//文件名 模型名 数据操作类型  字段对应列=>字段名 是否有标题行  where条件 关联表(字段名=>(对应表,对应表字段,对应表关联字段))
            include LIB_PATH . '/ORG/reader.php';
            $xls = new Spreadsheet_Excel_Reader(); 
            $xls->setOutputEncoding('utf-8');  //设置编码 
	        $xls->read($filename);  //解析文件 
	    for ($i=$islabel+1; $i<=$xls->sheets[0]['numRows']; $i++) {
                  $data=array();
                  foreach($elist as $k=>$v){
                      if(!empty($guanlian[$v])){
                          $data[$v]="select ".$guanlian[$v][1]." from ".$guanlian[$v][0]." where ".$guanlian[$v][2]."='".$xls->sheets[0]['cells'][$i][$k]."'";
                      }else{
                          $data[$v]=$xls->sheets[0]['cells'][$i][$k]; 
                      }
                  }
                  if($sign=='insert'){
                      $query = $model->add($data);
                  }else{
                      $query = $model->where($where)->save($data);
                  }
            }
            if($query!==false){ 
		$this->success('导入成功.!');
                exit;
	    }else{ 
		$this->error('导入失败.!');
                exit;
	    }
        }
     
        public function choose_select(){
            $provincelist=M("province")->order('sort asc')->select();
            $psstr="";
            foreach($provincelist as $k=>$v){
                $psstr.=$v["name"]."-".$v["id"]."$";
                $citylist=M("city")->where("provinceid=".$v["id"])->order('sort asc')->select();
                foreach($citylist as $ck=>$cv){
                    $psstr.=$cv["name"]."-".$cv["id"]."#";
                    $countylist=M("county")->where("provinceid=".$v["id"]." and cityid=".$cv["id"])->order('sort asc')->select();
                    foreach($countylist as $cok=>$cov){
                        $psstr.=$cov["name"]."-".$cov["id"].",";
                    }
                    $psstr=trim($psstr,",")."|";
                }
                $psstr=trim($psstr,"|")."@@";
            }
            echo "var CLIST='".trim($psstr,"@@")."'";
        }
        
        //获得商区数据
        public function get_district(){
            $district=M("district")->order("sort asc")->select();
            $Dlist=array();
            foreach($district as $k=>$v){
                $Dlist[$v["provinceid"]][$v["cityid"]][$v["countyid"]][]=$v["id"]."-".$v["name"];
            }
            echo "var DList='".json_encode($Dlist)."'";
        }
		
	public function json_area(){
	    $result=array();
	    $provincelist=M("province")->order('sort asc')->select();
            $psstr="";
            foreach($provincelist as $k=>$v){
				$result["data"][$k]["id"]=$v["id"];
				$result["data"][$k]["name"]=$v["name"];
                $citylist=M("city")->where("provinceid=".$v["id"])->order('sort asc')->select();
                foreach($citylist as $ck=>$cv){
					$result["data"][$k]["child"][$ck]["id"]=$cv["id"];
					$result["data"][$k]["child"][$ck]["name"]=$cv["name"];
                    $countylist=M("county")->where("provinceid=".$v["id"]." and cityid=".$cv["id"])->order('sort asc')->select();
                    foreach($countylist as $cok=>$cov){
						$result["data"][$k]["child"][$ck]["child"][$cok]["id"]=$cov["id"];
                        $result["data"][$k]["child"][$ck]["child"][$cok]["name"]=$cov["name"];
                    }
                }
            }
            echo json_encode($result);
	}

     public function verify() {
         import("@.ORG.Util.Image");
       
        $Verify = new \Image();
        $Verify::buildImageVerify();

       
       //$Verify->entry(1);
    }
      
}
?>