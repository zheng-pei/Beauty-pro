<?php
//转化为数组对象
function object_to_array($obj){
	$_arr = is_object($obj)? get_object_vars($obj) :$obj;
	foreach ($_arr as $key => $val){
		$val=(is_array($val)) || is_object($val) ? object_to_array($val) :$val;
		$arr[$key] = $val;
	}
	return $arr;
}



//生成soap文件
function array_to_soapxml($func,$data,$xmlNameSpace){
		
	$head='<?xml version="1.0" encoding="utf-8"?>'
	   	   .'<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">'
		   .'<soap12:Body>';

	$head.='<'.$func.' xmlns="'.$xmlNameSpace.'">';
		  	
	$foot='</'.$func.'></soap12:Body></soap12:Envelope>';	


	foreach ($data as $k => $v) {
		 $head.='<'.$k.'>';
		 $head.=$v;
		 $head.='</'.$k.'>';
	}

	return $head.$foot;
}



// 接口调用基础方法
class BaseOrder
{

	//命名空间
	private $xmlNameSpace="http://tempuri.org/";

	private $url = "http://htcloud.csshotel.com.cn/MiniCRSService/WechatService.asmx?WSDL";


	/*基础接口调用 ,请求数据格式化*/
	public function  soapDataFormat($func,$requestData){
		$setting=array(
				'encoding'=>'UTF-8',
				'soap_version' => SOAP_1_2,
			);
	    $client = new SoapClient($this->url,$setting);

	    $result=$client->$func($requestData);

	    return $result= object_to_array($result);
	    
	    return $data;
	}
















}
?>