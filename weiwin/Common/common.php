<?php
// 字符串的截取函数
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
      $str=String::msubstr($str, $start, $length, $charset, $suffix);
      return $str;
   }
   
 //获得积分及抵消积分,eventtype=1是消费返回积分，2是使用积分，3是签到获得积分，mathtype=1表示增加积分，0代表减少积分
 //当订单提交，但没有支付，则$orderprice=0,$isrecord=0,$iskouchu=1//不扣除积分
 //当订单支付成功了，则$isrecord=1,$iskouchu=1，扣除积分成功
    function getscore($memberid,$ordernum='',$code,$orderprice=0,$isrecord=0,$iskouchu=1){//当为支付成功获得积分时  orderprice为订单金额，是积分扣减时，orderprice为抵消积分数量，当为邀请获得积分时，orderprice为0

		$event=M("setting")->find();
        if(!empty($event)&&$orderprice!=0){
            $data=array();
            $data["memberid"]=$memberid;
            $data["createtime"]=  time();
            if($code=="xiaofei"){
        				$data["mathtype"]=1;
        				$data["eventtype"]=1;
                $data["comment"]="订单(".$ordernum.")返还积分";
                $data["point"]=round($event["returnpoint"]*$orderprice);
            }elseif($code=="dixiao"){
        				$data["mathtype"]=0;
        				$data["eventtype"]=2;
                $data["comment"]="订单(".$ordernum.")使用积分";
                $data["point"]=$orderprice;
            }elseif($code=="qiandao"){
        				$data["mathtype"]=1;
        				$data["eventtype"]=3;
                $data["comment"]="签到获得积分";
                $data["point"]=$event["signinpoint"];
            }

            if($isrecord==1){
              // 存入积分记录表
                $result=M("pointrecord")->add($data);
            }
            if($iskouchu==1){
                if($data["mathtype"]==0){
                   M("member")->where(array("id"=>$memberid))->setDec("point",$data["point"]);
                }else{
                   M("member")->where(array("id"=>$memberid))->setInc("point",$data["point"]);  
                }

           }
        }
        return $data["point"];
    }

   // 获取订单编号
function genordernum(){
    $ordernum="C".date("mdHis").rand(1000,9999);
    do{
        $iscz=M("Order")->where("num='".$ordernum."'")->count();
        if($iscz==0){
            break;
        }else{
           $ordernum="C".date("mdHis").rand(1000,9999); 
        }
    }while(1);
    return $ordernum;
}

function ceil_phone($str){
    //手机号码：^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$
    //匹配手机号  ^(13[4-9]|15[0189]|188)\d{8}$ 
    $ceil_phone="!^(13[4-9]|15[0189]|188)\d{8}$!";

    if(preg_match($ceil_phone, $str)){
      return true;
    }else{
      return fasle;
    }
  }

function isAndroid(){
	if(strstr($_SERVER['HTTP_USER_AGENT'],'Android')) {
		return 1;
	}
	return 0;
}
function object_array($array){
     if(is_object($array)){
         $array = (array)$array;
     }
      if(is_array($array)){
           foreach($array as $key=>$value){
               $array[$key] = object_array($value);
           }
      }
      return $array;
}
function getWeek($riqi){
    $weekarray=array("日","一","二","三","四","五","六");
    $w=date("w",strtotime($riqi));
    return $weekarray[$w];
}

function leavedays($ntime){
	$leavesecond=$ntime-time();
	$leaveday=floor($leavesecond/86400);
	echo $leaveday;
}

//正整数显示＋
function iszheng($scores){
	if($scores>0){
		return '+'.$scores;	
	}else{
		return $scores;	
	}
}

//随机字符串
function generate_password( $length = 6 ,$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
// 密码字符集，可任意添加你需要的字符
//$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

$password = '';
for ( $i = 0; $i < $length; $i++ ) 
{
$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
}

return $password;
}
function strinarray($id,$str){
    $arr=  explode(",", $str);
    if(in_array($id, $arr)){
        return 1;
    }else{
        return 0;
    }
}

//获得商家名称
function getbsidname($bsid){
  return M("business")->where("id=".$bsid)->getField("name");

}

//获得卡券名称
function getcardtype($type){
  if($type==1){
    return "代金券";
  }elseif($type==2){
    return "折扣券";
  }elseif($type==3){
    return "礼品券";
  }else{
    return "平台代金券";
  }
}

//获得后台管理员名称
function getusername($user){
  return M("user")->where("id='".$user."'")->getField("username");
}

//获得状态名称
function getstatus($status){
  if($status==1){
    return "启用";
  }else{
    return "禁用";
  }
}

function getcityname($city){
  return M("city")->where("id='".$city."'")->getField("name");
}

function getprovincename($province){
  return M("province")->where("id='".$province."'")->getField("name");
}

function getcountyname($county){
  return M("county")->where("id='".$county."'")->getField("name");
}

function getdistrictname($district){
  return M("district")->where("id='".$district."'")->getField("name");
}

//获得渠道商名字
function getchidname($chid){
  return M("channel")->where("id='".$chid."'")->getField("chname");
}

//获得卡券状态
function getcardsiglestatus($status){
  if($status==2||$status==1){
    return "未核销";
  }elseif($status==3){
    return "核销";
  }elseif($status==4){
    return "过期";
  }else{
    return "退费";
  }
}
//获得会员名字
function getmembername($member){
  return M("member")->where("id='".$member."'")->getField("username");
}
//获得会员号
function getmembernum($member){
  return M("member")->where("id='".$member."'")->getField("num");
}
//获得会员等级名称
function getlevelname($level){
  return M("memberlevel")->where("level='".$level."'")->getField("name");
}

//获得会员积分事件名称
function geteventname($event){
  return M("pointevent")->where("id='".$event."'")->getField("name");
}
//获取服务名称
function getservename($serviceid){
    $services=M("service")->where("id in (".$serviceid.")")->getField("sname", true);
    return implode(",", $services);
}
//获得订单号
function getordernum($orid){
    return M("order")->where("id='".$orid."'")->getField("ordernum");
}
//获得资金事件名称
function getzijineventname($event){
  switch ($event) {
    case '1':
      return "充值";
      break;
    case '2':
      return "钱包支付";
      break;
    case '3':
      return "获得佣金";
      break;
    case '4':
      return "提现";
      break;
    default:
      # code...
      break;
  }
}

function getbankname($bank){
  return M("bank")->where("id='".$bank."'")->getField("bankname");
}

function getbslevel($level){
    if($level<=1&&0<=$level){
      return "1级";
    }elseif ($level<=2&&1<$level) {
      return "2级";
    }elseif ($level<=3&&2<$level) {
      return "3级";
    }elseif ($level<=4&&3<$level) {
      return "4级";
    }else{
      return "5级";
    }
}
function getnum($mname,$fieldname,$value,$fuhao){
    $model=M($mname);
    foreach($fieldname as $k=>$v){
        $map[$v]=array($fuhao[$k],$value[$k]);
    }
    return $model->where($map)->count();
}

function getshxia($time){
    if(!empty($time)){
      $res = date('Y-m-d H', $time);
      return $res.":00";
      // $H=date("H",$time);
      // if($H>0&&$H<12){
      //     $s="上午";
      // }elseif($H>12&&$H<23){
      //     $s="下午";
      // }
      // $nyr=date("Y-m-d",$time);
      // return $nyr." ".$s;
    }else{
        return "";
    }
}

//获取服务名称
function getsingleservename($serviceid){
    $services=M("service")->where("id=".$serviceid)->getField("sname");
    return $services;
}

//获取配件类型
function getparttypename($parttypeid){
    $typename=M("parttype")->where("id=".$parttypeid)->getField("typename");
    return $typename;
}
//获取配件名称
function getpartname($partid){
    $typename=M("part")->where("id=".$partid)->getField("partname");
    return $typename;
}
//获取技师姓名
function getenname($partid){
    $typename=M("engineer")->where("id=".$partid)->getField("truename");
    return $typename;
}
//获取品牌名称
function getbrandname($modelid){
    $typename=M("brand")->where("id=".$modelid)->getField("brandname");
    return $typename;
}
//获取车系名称
function getcarname($modelid){
    $typename=M("car")->where("id=".$modelid)->getField("carname");
    return $typename;
}
//获取车型名称
function getmodelname($modelid){
    $typename=M("modelyear")->where("id=".$modelid)->getField("modelname");
    return $typename;
}
//获取车型显示名称
function getshowname($modelid){
    $typename=M("modelyear")->where("id=".$modelid)->getField("showname");
    return $typename;
}
//生成邀请码
function geninvitecode(){
    $code=  generate_password(5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    do{
        $iscz=M("member")->where("invitecode='".$code."'")->count();
        if($iscz==0){
            break;
        }else{
           $code=  generate_password(5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        }
    }while(1);
    return $code;
}
//获得优惠券
function getcoupon($openid,$couponid){
    $map=array();
    $map["openid"]=$openid;
    $memberinfo=M("member")->where($map)->find();
    if($memberinfo["memtype"]>2){
        return 4;
        exit;
    }
    $memberid=$memberinfo["id"];
    $couponinfo=M("coupon")->where("id=".$couponid)->find();
    $hasnum=M("couponsingle")->where(array("memberid"=>$memberid,"cpid"=>$couponid))->count();
   
    if($hasnum>$couponinfo["renum"]){
        return 1;//超过领取次数
    }else{
        $leavenum=M("couponsingle")->where(array("memberid"=>0,"cpid"=>$couponid))->count();
        if($leavenum==0){
            return 2;//优惠券已经领完
        }else{
           $dlqid=M("couponsingle")->where(array("memberid"=>0,"cpid"=>$couponid))->getField("id");
           $data["id"]=$dlqid;
           $data["memberid"]=$memberid;
           $data["createtime"]=time();
           $result=M("couponsingle")->save($data);
           if($result!==false){
               return 0;//领取成功
           }else{
               return 3;//领取完
           }
        }
    }
 }

 // 获取$orderprice为订单原始金额，即没有任何优惠时的金额
    function getorderprice($memberid,$orderprice,$serviceids="",$couponids="",$usepoint=0){//$orderprice为订单原始金额，即没有任何优惠时的金额
        $mianfei=array();
        $dikou=array();
        if($couponids!=""&&$serviceids!=""){
            $couponarr=array_filter(explode(",",$couponids));
            $servicearr=array_filter(explode(",",$serviceids));
            
            foreach($couponarr as $k=>$v){
                $couponsingle=M("Couponsingle")->find($v);
                if(!empty($couponsingle)&&$couponsingle["status"]==1){
                    $cinfo=M("Coupon")->where(array("id"=>$couponsingle["cpid"]))->find();       
                    if($cinfo["isfree"]==1){
                        $sprice=M("Service")->where(array("id"=>$cinfo["serviceid"]))->getField("price");
                        $dikouprice[$cinfo["serviceid"]]=$sprice;
                        if(!in_array($cinfo["serviceid"],$mianfei)){
                            $mianfei[]=$cinfo["serviceid"];
                        }
                    }else{
                        $selinfo=array_filter(explode(",",$cinfo["serviceid"]));
                        foreach($selinfo as $sk=>$sv){
                            if(in_array($sv, $servicearr)&&!in_array($sv, $mianfei)){
                               $dikouprice[$sv]=$couponsingle["price"];
                            }
                        }
                    //    $orderprice=$orderprice-$couponsingle["price"];
                    }
                }
            }
        }
        $couponprice=0;
        foreach($dikouprice as $dv){
            $couponprice+=$dv;
            $orderprice=$orderprice-$dv;
        }
        if($orderprice<0){
            $orderprice=0;
        }
        if($usepoint!=0){
            $dikoubl=M("pointevent")->where("code='dixiao'")->getField("point");
            $pointprice=$dikoubl*$usepoint;
            if($pointprice>$orderprice){
                $pointprice=$orderprice;
                $usepoint=ceil($pointprice/$dikoubl);
            }
            $orderprice=$orderprice-$pointprice;
            getscore($memberid, "dixiao",$usepoint);
        }
        
        return array("orderprice"=>$orderprice,"couponprice"=>$couponprice,"pointprice"=>$pointprice,"usepoint"=>$usepoint);
    }
//根据服务列表自动计算价格 
function autoprice($servicelist,$orderprice=0,$brandid,$carid,$yearid,$orderid=0){
    foreach($servicelist as $k=>$v){
                $orderprice+=$v["price"];
                if(!empty($v["parttypeid"])){
                    $partarr=array_filter(explode(",",$v["parttypeid"]));
                    foreach($partarr as $pv){
                        $pw=array();
                        $pw["orderid"]=$orderid;
                        $pw["orderserviceid"]=$v["id"];
                        $pw["serviceid"]=$v["serviceid"];
                        $pw["parttypeid"]=$pv;
                        $pinfo=M("Part")->where(array("typeid"=>$pv,"brandid"=>$brandid,"carid"=>$carid,"yearid"=>$yearid))->order("sort desc,id asc")->find();
                        if(!empty($pinfo)){
                            $pw["partyid"]=$pinfo["id"];
                            $pw["price"]=$pinfo["price"];
                            $pw["memberid"]=$_SESSION["memberinfo"]["id"];
                            $pw["createtime"]=time();
                            if($pinfo["price"]>0){
                                M("Orderpart")->add($pw);
                                $orderprice+=$pinfo["price"];
                            }
                            
                        }
                    }
                }
    }
    return $orderprice;
}
//获取操作说明
function  getcomment($orderid){
     $comment="";
     $servicelist=M("orderservice")->where("orderid=".$orderid)->select();
     foreach($servicelist as $k=>$v){
        $servename=getsingleservename($v["serviceid"]);
        $comment.="服务名称:".$servename;
        $parttype=M("orderpart")->where("orderid=".$orderid." and serviceid=".$v["serviceid"]." and orderserviceid=".$v["id"])->select();
        if(count($parttype)>0){
            $comment.="[选择配件有：";
        }
        foreach($parttype as $vp){
            if($vp!=0){
                $typename=getparttypename($vp["parttypeid"]);
                $partname=getpartname($vp["partyid"]);
                $comment.=$typename."(".$partname.")";
            }
        }
        if(count($parttype)>0){
            $comment.="]";
        }
        $comment.="<br/>";
    }
    return $comment;
}




//获得餐厅名称
function getDinnerName($dinnerid){
  return M("dinner")->where("id='".$dinnerid."'")->getField("name");
}
//获取日期字符串
function get_bdate($i){
  if($i==0){
    return date("Y")."-".(int)date("m")."-".(int)date("d"); 
  }else{
    $tstr=strtotime("+".$i." days");
    return date("Y",$tstr)."-".(int)date("m",$tstr)."-".(int)date("d",$tstr);   
  }
}
?>