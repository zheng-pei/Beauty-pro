<?php

/*房间预订接口类*/

class roomOrder extends BaseOrder implements roomOrderInterface  
{ 

 
	private $htlcd='test';    //酒店代码

	/**
	*
	*	查询酒店房间函数  return  RoomTypInfo[]
	*/
	public  function GetRmTypList($data=array())
	{	
		//房间查询参数
		$roomArray=array(
			'htlcd'           => $this->htlcd,		//酒店代码
			'memtyp'		  => 0,				//会员类别 0-非会员 1-门户注册会员，3-酒店会员
			'icnum' 		  => '',    		//卡号（非会员可传入空）
			'icpwd' 		  => '',    		//卡密码
			'arrDt' 		  => '',    		//来期
			'dptDt'		      => '',			//离期
			'cardTyp'         => '',  			//卡类
			'errstr'	      => ''				//如果出错，则传出错误信息
			);

		foreach ($data as $k => $v) {
			if(!empty($v))
				$roomArray[$k]=$v;
		}

		return $this->soapDataFormat("GetRmTypList",$roomArray);
				
	}




	/**
	*	查询房间价格      public  RoomPriceInfo[]
	*	返回值	RoomPriceInfo[]	房价对象数组
	*/
	public  function  GetPriceInfo($data=array())
	{
					
		//房间价格查询参数
		$roomPrice=array(
			'htlcd'           => $this->htlcd,		//酒店代码
			'memtyp'		  => 0,				//会员类别 0-非会员 1-门户注册会员，3-酒店会员
			'icnum' 		  => '',    		//卡号（非会员可传入空）
			'icpwd' 		  => '',    		//卡密码
			'arrDt' 		  => '',    		//来期
			'dptDt'		      => '',			//离期
			'cardTyp'         => '',  			//卡类
			'roomCd'		  => '137704',            //房类
			'errstr'	      => ''				//如果出错，则传出错误信息
			);

		foreach ($data as $k => $v) {
			if(!empty($v))
				$roomPrice[$k]=$v;
		}

		return $this->soapDataFormat("GetPriceInfo",$roomPrice);
	}


	/**
	*	新建订单   public string 
	*/
	public  function MakeOrder($data=array())
	{	
		
		$roomOrder=array(
			'htlcd'           	 => $this->htlcd,		//酒店代码
			'memtyp'		 	 => 0,			//会员类别 0-非会员 1-门户注册会员，3-酒店会员
			'icnum' 		 	 => '',    		//卡号（非会员可传入空）
			'mempwd' 		 	 => '',    		//密码
			'wechatId' 		 	 => '',    		//微信号
			'guestNm' 		   	 => '',    		//订房人
			'guestPhone' 		 => '',    		//订房人电话
			'guestMail' 		 => '',    		//订房人邮箱
			'notice' 		  	 => '',    		//订单备注

			'arrDt' 		  	 => '',    		//来期
			'dptDt'		      	 => '',			//离期
			'fast_arr_tm'        => '',  		//最早来店时间（HH:mm）
			'last_arr_tm'		 => '',   		//最晚来店时间（HH:mm）
			'orderDetails'		 => '',   		//OrderDetail[]	订单明细数组
			'errstr'	     	 => ''			//订单号（如果为空则判断为操作失败）
			);

		foreach ($data as $k => $v) {
			if(!empty($v))
				$roomOrder[$k]=$v;
		}

		return $this->soapDataFormat("MakeOrder",$roomOrder);
	
	}


	/**
	*	获取订单列表     public OrderInfo[]    GetOrderList(string htlcd, string memtyp, string icnum, string bookstus, DateTime bgDt, DateTime edDt, refstring errstr)
	*/
	public  function GetOrderList()
	{
		$orderList=array(
			'htlcd'           => $this->htlcd,		//酒店代码
			'memtyp'		  => 0,				//会员类别 0-非会员 1-门户注册会员，3-酒店会员
			'icnum' 		  => '',    		//卡号（非会员可传入空）
			'bookstus' 		  => 0,    			//订单状态 0 待确认 1 已确认 * 取消
			'bgDt' 		  	  => '2015-8-21',    		//建立日期起始
			'edDt'		      => '2015-8-22',			//建立日期终止
			'errstr'	      => ''				//如果出错，则传出错误信息
			);


		foreach ($data as $k => $v) {
			if(!empty($v))
				$orderList[$k]=$v;
		}

		return $this->soapDataFormat("GetOrderList",$orderList);
	}

	/**
	*	取消订单        public string     CancelOrder(string htlcd, string memtyp, string icnum,string bookNum, refstring errstr)
	*/
	public  function CancelOrder()
	{
		$orderList=array(
			'htlcd'           => $this->htlcd,		//酒店代码
			'memtyp'		  => 0,				//会员类别 0-非会员 1-门户注册会员，3-酒店会员
			'icnum' 		  => '',    		//卡号（非会员可传入空）
			'bookNum' 		  => 0,    			//订单号
			'errstr'	      => ''				//如果出错，则传出错误信息 ,订单号（如果为空则判断为操作失败）
			);


		foreach ($data as $k => $v) {
			if(!empty($v))
				$orderList[$k]=$v;
		}

		return $this->soapDataFormat("CancelOrder",$orderList);
	}



	/**
	*	修改订单备注    public void ChgNotice(string htlcd, string memtyp, string icnum, string mempwd, string booknum, string notice, refstring errstr)
	*/
	public  function ChangeNotice()
	{
			$orderList=array(
			'htlcd'           => 'test',		//酒店代码
			'memtyp'		  => 0,				//会员类别 0-非会员 1-门户注册会员，3-酒店会员
			'icnum' 		  => '',    		//卡号（非会员可传入空）
			'mempwd' 		  => '',    		//密码
			'bookNum' 		  => 0,    			//订单号
			'notice'		  =>'',				//订单备注
			'errstr'	      => ''				//如果出错，则传出错误信息 ,订单号（如果为空则判断为操作失败）
			);


		foreach ($data as $k => $v) {
			if(!empty($v))
				$orderList[$k]=$v;
		}

		return $this->soapDataFormat("ChangeNotice",$orderList);

	}



	/**
	*	修改订单备注    wechat.ChgNotice(htlcd, memtyp, icnum, mempwd, booknum,  "票据号：" + notice , "1", ref errstr); ）
	*/
	public  function ChangeOrderStatus()
	{

	}

}
?>