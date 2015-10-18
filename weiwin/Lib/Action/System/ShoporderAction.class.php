<?php
class ShoporderAction extends BackAction
{
    public function index(){
        $model=M('Area'); 
        $map=array();
        if(isset($_REQUEST["areanameid"])&&$_REQUEST["areanameid"]!=0){
            $map["sk_area.id"]=$_REQUEST["areanameid"];
            $this->assign('aid',$_REQUEST['areanameid']);
        }     
        // 地区
        $areaname=M('area')->field('id,areaname')->select();
        $areacount=M('area')->count();//获取地区的总个数
        if($areaname){
            $this->assign('areaname',$areaname);
        }
        import('ORG.Util.Page');// 导入分页类
        $count=$model->where($map)->count();// 查询满足要求的总记录数
        $Page= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $lists=$model->field('id,areaname')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        $allbeauty=array();
        foreach ($lists as $k1 => $v1) {
            $lists[$k1]['bsidcount']=M('Business')->where('areaid='.$v1['id'])->count();
            $lists[$k1]['beautycount']=M('Beautician')->where('areaid='.$v1['id'])->count();
            $lists[$k1]['servicecount']=M('Service')->where('areaid='.$v1['id'])->count();
            // 查一个地区的所有的美容师的id, 遍历一个地区的所有的美容师的订单总数
            $allbeauty=M('Beautician')->where('areaid='.$v1['id'])->getField('id',true);
           if(!empty($allbeauty)){
              $where1['beautyid']=array('in',$allbeauty);
              $where1['status']=array('in','20,30');
              $lists[$k1]['ordercount']=M('Order')->where($where1)->count();
              $lists[$k1]['pricesum']=M('Order')->where($where1)->sum('orderprice');
           }else{
                $lists[$k1]['ordercount']=0;
                $lists[$k1]['pricesum']=0;
           }
        }
        // dump($lists);
        if($lists){
            $this->assign('lists',$lists);
            $this->assign('page',$show);// 赋值分页输出
        }else{
            $this->assign('lists','');
        }
        $this->display();
    }

      public function delete()
        {
            parent::foreverdelete("Business");
        } 

}