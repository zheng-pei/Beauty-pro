<?php
// +----------------------------------------------------------------------
// | G3weixin [ ALL WHERE,ALL TIME ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://lietouzhe.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 微信账号控制器类库
 */
class WxuserAction extends BaseAction{
	protected $wxuserinfo;
	//该构造函数继承父类的当前登陆用户信息、用户组信息及当前微信用户的全信息、 并实现SESSION的微信用户信息
	protected function _initialize(){
            
	    parent::_initialize();
            if(!empty($_GET['areaid'])){
              $_SESSION['areaid']=$_GET['areaid'];
            }
            $this->footer();
         
            //以下程序为微信鉴权程序，暂时屏蔽，对接微信的时候将打开
	    	require_once "jssdk.php";
            $this->appID=C('appid');
            $this->appSecret=C('appkey');
            $jssdk = new JSSDK($this->appID, $this->appSecret);
            $signPackage = $jssdk->GetSignPackage();
            $this->assign("signPackage",$signPackage);
         //当没有授权code的时候

            if($_GET["code"]==""){
                if($_SESSION['openid']==""){//如果session丢失
                    $param=array();
                    foreach($_GET as $k=>$v){
                        if($k!="_URL_"&&$k!="code"&&!is_array($v)){
                            $param[$k]=$v;
                        }
                    }
                    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appID."&redirect_uri=".C('site_url').U(MODULE_NAME."/".ACTION_NAME,$param)."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
                     header("location:".$url);
                     exit;
                }
            }else{
                $weixin=$this->wxApi("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appID."&secret=".$this->appSecret."&code=".$_GET["code"]."&grant_type=authorization_code");

                if($weixin["errcode"]!=""){
                    $this->error($weixin["errcode"].":".$weixin["errmsg"], '');
                    exit;
                }
                $openid=$weixin["openid"];
                $_SESSION['openid']=$openid;                
            }
            //微信鉴权结束
//            $_SESSION['openid']="abcdefg";//默认给一个初始化openid
            //以下为初始注册用户
            $iszc=M("Member")->where(array('openid'=>$_SESSION['openid']))->count();

            if($iszc>0){
                //表示已经注册
                $_SESSION["memberinfo"]=M("member")->where(array('openid'=>$_SESSION['openid']))->find();
                //查看是否已关注用户
                if($_SESSION["memberinfo"]["nickname"]==""){
                      $memberinfo=$this->getBaseInfo($_SESSION['openid']);
                      if($memberinfo["subscribe"]!=0){
                          $data=array();
                          $data["id"]=$_SESSION["memberinfo"]["id"];
                          $data["nickname"]=$memberinfo["nickname"];
                          $data["pic"]=$memberinfo["headimgurl"];
                          $id=M("member")->save($data);
                          $_SESSION["memberinfo"]=$data;
                      }
                }
            }else{
                //代表未注册
                if($_GET["state"]==1){
                    $memberinfo=$this->getBaseInfo($_SESSION['openid']);
               
                    if($memberinfo["subscribe"]==0){
                        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appID."&redirect_uri=".C('site_url').$_SERVER['REQUEST_URI']."&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect";
                         header("location:".$url);
                         exit;
                    }  
               
                }elseif($_GET["state"]==2){
                    $memberinfo=$this->getBaseInfo2($_SESSION['openid'],$weixin["access_token"]);
                }
                  $data=array();
                  if($memberinfo["subscribe"]!=0){
                      $data["nickname"]=$memberinfo["nickname"];
                      $data["pic"]=$memberinfo["headimgurl"];
                  }
                  $data["openid"]=$_SESSION['openid'];
                  $data["createtime"]=time();
//                  $carno=M("cardhistory")->count();
//                  $data["num"]=sprintf("%08s", $carno+1);
                  $id=D("Member")->add($data);
                  $data["id"]=$id;
                  $_SESSION["memberinfo"]=$data;
            }
          
	}

        function wxApi($url){  
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1 );
            $output=curl_exec($ch);
            curl_close($ch);

            //$output='{"access_token":"125bd9bfc74b808b","appsecret":"3d90da73abe125bd9bfc74b808b93948"}';
            $jsoninfo=json_decode($output,true);
            //$access_token=$jsoninfo['access_token'];
            return $jsoninfo;
        }
	 //通过Access_Token 和Openid获取用户的基本信息
        public function getBaseInfo($openid){
            if(isset($openid)){
                $status=1;
                do{
                    if($status>1){
                        $this->readAccessToken(0);
                    }
                    $token=$this->readAccessToken(1);
                    $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$openid}&lang=zh_CN";

                    $jsonArr=$this->wxApi($url);//获得基本信息

                   $status++;
                }while($jsonArr['errcode']!="");

                return $jsonArr;
            }else{
                return -1;
            }
        }
        private function readAccessToken($status=1){
          $xml_array=simplexml_load_file('access_token.xml'); //将XML中的数据,读取到数组对象中 
          if(!empty($xml_array)&&!empty($status)){
              $access_token=$xml_array->access_token;
              if(!empty($access_token)){//if exist ,return the right 
                 return $access_token;
                  
              }else{
                  $errcode=$xml_array->errcode;
                  $errormgs=(!empty($errcode)) ? $errcode:0;
                  //echo $errormgs;
                  return $errormgs;
              }
          }else{//if not exist ,creat a xml file;
              $this->getAccessToken();
              $this->readAccessToken();
          }
          
      }
    //生成ACCESS_TOKEN
    private function getAccessToken(){
        
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appSecret}";

        $jsoninfo=$this->wxApi($url);
        //write　in  access_token.xml
        $path="access_token.xml";
        $dom=new DOMDocument('1.0','utf-8');
        //creat root node
        $root=$dom->createElement('root');
        $dom->appendChild($root);
        foreach($jsoninfo as $k=>$v){
            $element=$dom->createElement($k,$v);
            $root->appendChild($element);
        }
        $dom->save($path);
        
        //更新到数据库
    }
    public function saveAccessToken($jsoninfo){
        $path="access_token.xml";
        $dom=new DOMDocument('1.0','utf-8');
        //creat root node
        $root=$dom->createElement('root');
        $dom->appendChild($root);
        foreach($jsoninfo as $k=>$v){
            $element=$dom->createElement($k,$v);
            $root->appendChild($element);
        }
        $dom->save($path);
    }
    
    public function getBaseInfo2($openid,$access_token){
            if(isset($openid)){
                $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

                $jsonArr=$this->wxApi($url);//获得基本信息
               
                return $jsonArr;
         }
    }
    public function downloadfile($url){
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_NOBODY, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$package = curl_exec($curl);
		$httpinfo=curl_getinfo($curl);
		curl_close($curl);
		$imageall=array_merge(array("header"=>$httpinfo),array("body"=>$package));
		return $imageall;
	}
	
	public function savefile($filename,$filecontent){
		$localfile=fopen($filename,'w');
			if(false!==$localfile){
				if(false!==fwrite($localfile,$filecontent)){
					fclose($localfile);
					echo trim($filename,".");
				}else{
					echo "b";	
				}
			}else{
				echo $filecontent;	
			}
			
		}
	
	public function getimage(){
		$mediaid=$_GET['mediaid'];
		$access_token=M("access_token")->where('id=1')->find();
        $now=time();

         if(!empty($access_token)&&($now-$access_token['addtime'])<7200){
                    $atoken=$access_token['access_token'];
         }else{
             $tokenarr=$this->wxApi("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appID."&secret=".$this->appSecret."");
              if($tokenarr['errcode']!=0){
                        echo $tokenarr['errmsg'];
                        exit;
               }
               $atoken=$tokenarr["access_token"];
               M("access_token")->where('id=1')->save(array("access_token"=>$atoken,"addtime"=>$now));
          }
		 $url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$atoken."&media_id=".$mediaid; 
		 $filecontent=$this->downloadfile($url);

  
     	 $src=$this->savefile("./Uploads/image/".$mediaid.".jpg",$filecontent['body']) ;
  
	}
	
	public function success($message,$jumpUrl='',$type=0){
		if($type==1){
			parent::success($message,$jumpUrl);
		}else{
             echo "<script>alert('".$message."');location.href='".$jumpUrl."';</script>";
			 exit;
		}
	}
	public function error($message,$jumpUrl='',$type=0){
		if($type==1){
			parent::error($message,$jumpUrl);
		}else{
			if($jumpUrl==''){
				echo "<script>alert('".$message."');history.back();</script>";
			 exit;
			}else{
			 echo "<script>alert('".$message."');location.href='".$jumpUrl."';</script>";
			 exit;
			}
		}
	}


// 用于输出服务项目详情，通用从美容师和项目之间的选择
  public function fuwuxqdetail($m,$id){
      if($id){
        $map1['id']=$id;
        $res=$m->where($map1)->field('id,classid,name,lab,coverpic,comment,summary,servicetime,origprice,trueprice,appuser,product,attention,isrecom')->find();
        // 标签的集合,获取服务标签的名称和图片
        $lab=$res['lab'];
        $map2['id']=array('in',$lab);
        $map2['status']=1;
        $labname=M('Servicelab')->field('labname,pic')->where($map2)->limit(3)->order('id desc,sort desc')->select();
        // echo M('Servicelab')->getLastSql();
        $this->assign('res',$res);
        // 将配备产品和注意事项用逗号分隔读取
        $product=array();
        $product=explode(',',$res['product']);
        $this->assign('product',$product);
        $attention=array();
        $attention=explode(',',$res['attention']);
        $this->assign('attention',$attention);
        $this->assign('labname',$labname);
          // 美容步骤
        $map3['sk_servicestep.serviceid']=$id;
        $servicestep=M('Servicestep')->where($map3)->field('sk_servicestep.summary,sname')->order('sk_servicestep.id desc,sk_servicestep.sort desc')->join('sk_service on sk_servicestep.serviceid=sk_service.id')->select();
        // echo M('Servicestep')->getLastSql();
        foreach ($servicestep as $key => $value) {
          // 给美容步骤添加编号
          $value['code']=$key+1;
          $servicestep[$key]=$value;
        }
        $this->assign('webtitle','服务详情');
        $this->assign('servicestep',$servicestep);
        $this->display('fuwuxq');
      }else{
        $this->assign('webtitle','错误页面');
        $this->display('Public:error');
      }    
  }

//公共的美容师的占用时间存放在表中
public function beautyTime($orderid,$beautyid,$serviceid){
    $timearr=array("09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30");
      //当支付成功，我要将时间占用存放到美容师占用表
        $map['id']=$serviceid;
        $map['status']=1;
        $servicetime=M('Service')->where($map)->getField('servicetime');
        $ordertime=M('Order')->where('orderid='.$orderid)->getField('ordertime');
        $yushu=$servicetime%30;
        $count=ceil($servicetime/30);
        $shijing=date('H:i',strtotime($ordertime));
        //数据要存放在表中
        $data['beautyid']=$beautyid;
        $data['ordertime']= $ordertime;
        $data['orderid']=$orderid;
        $data['serviceid']=$serviceid;
        $data['orderymd']=(int)date("Y",strtotime($ordertime))."-".(int)date("m",strtotime($ordertime))."-".(int)date("d",strtotime($ordertime)); //这个的输出是 2011-1-9
        $data['date']=$shijing;
        $data['memberid']=$_SESSION["memberinfo"]["id"];
        // 如果余数为0,存放的时间个数是count-1
        foreach ($timearr as $key => $value) {
            if($shijing==$value){
              $j=$key;//查找的元素的下标    
            }
        }
        if($yushu==0){ 
            $xiabiao=$j+$count;//最后的下标
              for($i=$j;$i<$xiabiao;$i++){ 
                if($i<26){
                  $data['date']=$timearr[$i];
                  // 数据要存放在表中
                  M('Beautytime')->add($data);  
                  echo M('Beautytime')->getLastSql();
                }   
              } 
        }else{
            $xiabia=$j+$count;//最后的下标
            for($k=$j;$k<$xiabia;$k++){ 
              if($k<26){ 
                $data['date']=$timearr[$k];
                // 数据要存放在表中
                M('Beautytime')->add($data); 
                // echo M('Beautytime')->getLastSql(); 
              }   
            } 
        }    
    }
// 公共的积分记录函数
public function jifengscore($memberid,$status,$orderid){
  // 支付订单成功，要将用户抵扣的积分存放到对应的积分事件中,同时更新用户的积分----    
  if($status=="xiaofei"){
    $data1['mathtype']=0;
    $data1['eventtype']=2;
    $where['status']=20;
    $where['orderid']=$orderid;
    $res=M('Order')->where($where)->field('usepoint,num,createtime')->find();
    // 保存数据到积分记录表中
    $data1['point']=$res['usepoint'];
    $data1['comment']='订单编号：'.$res['num'].'使用积分';
    $data1['createtime']=$res['createtime'];
    $data1['memberid']=$memberid;
    M('Pointrecord')->add($data1);
    // echo M('Pointrecord')->getLastSql();
    //同时会员的积分要更新
    $map1['memberid']=$_SESSION["memberinfo"]["id"];
    $map1['eventtype']=array('in','1,3');
    $map2['memberid']=$_SESSION["memberinfo"]["id"];
    $map2['eventtype']=2;
    $xiaofeipoint=M('Pointrecord')->where($map2)->sum('point');
    $qdflpoint=M('Pointrecord')->where($map1)->sum('point');
    $totalpoint= $qdflpoint-$xiaofeipoint;
    $data['point']=$totalpoint;//总的积分
    $map3['id']=$memberid;
    // 保存登录的用户的积分
    M('Member')->where($map3)->save($data);//测试已经执行
     // echo M('Member')->getLastSql();
  }
}

// 支付成功页面
public function paysuccess($orderid){
    // 更新订单的状态
    // $orderid=$_GET['orderid'];
    if(!empty($orderid)){
      $orderpay=M('Order')->where('orderid='.$orderid)->find();
      if($orderpay){
        // 更新订单状态-----------------------对接微信
        $data['status']=20;
        $id=M('Order')->where('orderid='.$orderid)->save($data);
        $memberid=$_SESSION["memberinfo"]["id"];
        // 支付订单成功，要将用户抵扣的积分存放到对应的积分事件中,同时更新用户的积分----测试没有执行
        $this->jifengscore($memberid,'xiaofei',$orderid);        
        // 要给客户发消息，存放message表中,这里要判断你提交的订单是否支付，才好发送消息---------
        $message['memberid']=$_SESSION["memberinfo"]["id"];
        $message['comment']='支付成功';
        $message['createtime']=time();
        $message['orderid']=$orderid;
        $message['status']=0;
        M('Message')->add($message);
        // echo M('Message')->getLastSql();
        $data=M('Order')->where('orderid='.$orderid)->field('beautyid,serviceid')->find();
        $beautyid=$data['beautyid'];
        $serviceid=$data['serviceid'];
        //当支付成功，我要将时间占用存放到美容师占用表------------------
        $this->beautyTime($orderid,$beautyid,$serviceid);

        // $this->assign('webtitle','支付成功页面');
        // $this->assign('id','1');//支付成功的标志      
      }
    }
    //   else{
    //     $this->assign('id','0');//支付失败的标志
    //   } 
    
    // }else{
    //   $this->assign('id','0');//支付失败的标志
    // }
    // $this->display('Public:paystatus');
}

  // 页面底部的内容的输出
  public function footer(){
    $map['id']=$_SESSION['areaid'];
    $areaname=M('Area')->where($map)->field('areaname')->find();
    $_SESSION['areaname']=$areaname['areaname'];
    $this->assign('areaid',$_SESSION['areaid']);
    $this->assign('areaname',$_SESSION['areaname']);
  }
  /**
     * 当用户访问控制器中不存在的方法时，进行处理 避免出现不友好的错误页面
     */
    public function _empty(){
        header("HTTP/1.0 404 Not Found"); 
        $this->display("Public:error");
    }
	
	 public function weipay($ordernum,$orderprice){
        require_once "weipay/lib/WxPay.Api.php";
        require_once "weipay/WxPay.JsApiPay.php";


        //①、获取用户openid
        $tools = new JsApiPay();
        $openId = $_SESSION['openid'];

        //②、统一下单
        $input = new WxPayUnifiedOrder();

        $input->SetBody("小美平台");
        $input->SetAttach("小美平台");

        $input->SetOut_trade_no($ordernum);
        $input->SetTotal_fee($orderprice*100);
		//$input->SetTotal_fee(1);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://xiaomei.gouaixin.com/weipay/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
  
        $jsApiParameters = $tools->GetJsApiParameters($order);
//		var_dump($jsApiParameters);
        $this->assign("jsApiParameters",$jsApiParameters);
	 }
}
?>