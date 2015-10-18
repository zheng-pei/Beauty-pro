<?php
    class RoomModel extends RelationModel{
        
       	protected $modelName ;//定义全局模型

       	protected $_link=array(
       		//图集
       		/*'ablum'=>array(
       			'mapping_type'=>HAS_MANY,
       			'class_name'=>'ablum',
       			'mapping_name'=>'ablum_paronama',
       			'foreign_key'=>'relatid',
       			'condition'=>'imgtype = 2',//关联条件
       			),*/
       		);


    	//获得房间列表的信息
    	public function getRoomList($start,$end){
    		if(!isset($start)) $start = 0;
    		if(!isset($end)) $end = 1;

    		$result=D('room')->relation(true)->where('is_show=1')->order('sort asc')->limit($start,$end)->select();


    		return $result;
    	}

    	//根据房间id,查询房间详细信息
    	public function getRoomDetail($id=''){
    		if(empty($id)){
    			return  '';
    		}else{
    			return $this->modelName->where('is_show=1 and id='.$id)->find();
    		} 
    	}


    	//删除相关资料
        protected function _after_delete($data) {
            $model=M('ablum');
            $result=$model->where("imgtype=2 and relatid not in (select id from sk_room)")->delete();
        }
        
}
?>