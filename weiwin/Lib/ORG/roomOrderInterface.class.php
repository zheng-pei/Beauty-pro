<?php
/*
 * 酒店房间预订接口
 *
 */

interface roomOrderInterface 
{
	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询酒店房间函数      return  RoomTypInfo[]
	+			            GetRmTypList(string htlcd, string memtyp, string icnum, 
	+									string icpwd, string arrDt, string dptDt, 
	+										string cardTyp, refstring errstr)
	+-------------------------------------------------------------------------   
	+                       public RoomTypInfo[]  
	+					    GetRmTypList(string htlcd, string memtyp, string icnum, 
	+                                    string arrDt, string dptDt, string cardTyp,
	+                                         refstring errstr)
	+--------------------------------------------------------------------------
					参数	    类型	    描述
					htlcd	string		  酒店代码
					memtyp	string		  会员类别0-非会员1-门户注册会员，3-酒店会员
					icnum	string		  卡号（非会员可传入空）
					icpwd	string		  卡密码
					arrDt	string		  来期
					dptDt	string	      离期
					cardTyp	string	      卡类
					errstr	ref string	  如果出错，则传出错误信息
					返回值	RoomTypInfo[] 房类对象数组

				    @return RoomTypInfo[]
					RoomCd					String	房类代码
					RoomNm					String	房类名称
					RoomDrpt				String	房类描述
					RoomRate				Decimal	最低房价（均价）
					RoomRate_PriceCd		String	最低房价对应的价格代码
					RoomRate_Breakfast		String	最低房价对应的含早个数
					RoomRate_PriceDetail	String	最低房价对应的价格详情（每日房价用逗号隔开）
					NormalRate_PriceDetail	String	非会员价详情
					GstNums					intval	可住人数
					RoomsAva				Int		可用房量
					RoomsPic				Byte[]	房间图片

	*/
	function GetRmTypList();




	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询房间价格      publicRoomPriceInfo[]
	+				     GetPriceInfo(string htlcd, string memtyp, string icnum,
	+							 string icpwd, string arrDt, string dptDt, 
	+							 string cardTyp, string roomCd, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数	    类型	    描述
					htlcd	string		  酒店代码
					memtyp	string		  会员类别0-非会员1-门户注册会员，3-酒店会员
					icnum	string		  卡号（非会员可传入空）
					icpwd	string		  卡密码
					arrDt	string		  来期
					dptDt	string	      离期
					cardTyp	string	      卡类
					roomCd	string	 	  房类
					errstr	ref string	  如果出错，则传出错误信息
					返回值	RoomPriceInfo[]	房价对象数组

				    @return RoomPriceInfo[]
					 
					PriceCd			String	价格代码
					PriceName		String	价格名称
					PriceDrpt		String	价格描述
					EarlyBirdFlg	Bool	必须提前预订
					LastMinuteFlg	Bool	必须在入住日期前几日内
					MultiDaysFlg	Bool	连续入住优惠
					Days			Int		必须提前预订天数/必须在入住日期前的天数/最少连续入住天数
					BreakfastCount	Int		含早个数
					PriceDetail		String	价格详情。多日价格用逗号隔开
					PriceFlg		String	"价格标志，1-会员价，2-协议价，3-非会员价，4-持卡会员价
												协议价只有协议客户登录可以显示其指定的协议价
												持卡会员价只有持卡会员可以享受"
					TotAmt			Long	总价
					AvgAmt			Int	 	平均价
					PayFlg			String	"0-无需支付，1-需预付，2-需预授权；空等同于0,3-可预付"
					
					PayTyp			String	支付类型，1-首日房费，2-总房费比例
					PayAmt			Decimal	支付比例，0-1之间，1代表全额支付，必须>0
					PayRmnums		Int		预付价格启用房数，即如果是预付价，几间同时预订才要求比需预付，0则不论几间都必须预付（0为默认值）
					FirstDayAmt		Int		首日房价

	*/
	function GetPriceInfo();


	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	新建订单      		public string 
	+						MakeOrder(string htlcd, string memtyp, string icnum, 
	+									string mempwd, string wechatId, string guestNm, 
	+									string guestPhone, string guestMail, string notice, 
	+									string arrDt, string dptDt, 
	+									OrderDetail[] orderDetails, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数	    		类型	    		描述
										
					htlcd			string			酒店代码
					memtyp			string			会员类别0-非会员1-门户注册会员，3-酒店会员
					icnum			string			卡号（非会员可传入空）
					mempwd			string			密码
					wechatId		string			微信号
					guestNm			String			订房人
					guestPhone		String			订房人电话
					guestMail		String			订房人邮箱
					notice			String			订单备注
					arrDt			String			来期
					dptDt			String			离期
					fast_arr_tm		String			最早来店时间（HH:mm）
					last_arr_tm		String			最晚来店时间（HH:mm）
					orderDetails	OrderDetail[]	订单明细数组
					errstr			ref string		如果出错，则传出错误信息
					返回值			String			订单号（如果为空则判断为操作失败）

					@post OrderDetail[]
										 
					RoomCd			String	房类代码
					RoomNm			String	房类名称
					PriceCd			String	价格代码
					PriceNm			String	价格名称
					RoomsNums		Int		房数
					GuestNums		Int		人数
					PriceDetail		String	来离期之间的每日房价，逗号隔开
					Breakfast		Int		含早个数

	*/
	function MakeOrder();


	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	获取订单列表      		public OrderInfo[]    GetOrderList(string htlcd, string memtyp, string icnum, string bookstus, DateTime bgDt, DateTime edDt, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数				类型					描述
					htlcd			string				酒店代码
					memtyp			string				会员类别0-非会员1-门户注册会员，3-酒店会员
					icnum			string				卡号（非会员传微信号）
					bookstus		string				订单状态 0 待确认 1 已确认 * 取消
					bgDt			DateTime			建立日期起始
					edDt			DateTime			建立日期终止
					errstr			ref string			如果出错，则传出错误信息
					返回值			OrderInfo[]			OrderInfo对象数组

					@return OrderInfo[]					
					ArrDt			String				入住日期
					DptDt			String				离店日期
					BookNum			String				订单号
					BookStus		String				订单状态 0-已生成，1-待确认，2-已确认，3-已拒绝，4-取消，5-提交Switch失败
					Notice			String				订单备注
					BookDt			String				预订日期时间
					OrderDetailList	List<OrderDetail>	订单详情
					GstInfo			String				客人信息描述
					CancelRs		String				订单拒绝原因
					Pay_amt			decimal				待支付金额
					Pay_typ			String				1-预付，2-预授权
					Member_nm		String				订房人姓名
					Member_phone	String				订房人电话
					Member_email	String				订房人邮箱
					Fat_arr_tm		String				最早到店时间
					Lst_arr_tm		String				最晚到店时间

	*/
	function GetOrderList();

	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	取消订单      		public string     CancelOrder(string htlcd, string memtyp, string icnum,string bookNum, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数		类型			描述
					htlcd	string		酒店代码
					memtyp	string		会员类别0-非会员1-门户注册会员，3-酒店会员
					icnum	string		卡号（非会员传微信号）
					bookNum	String		订单号
					errstr	ref string	如果出错，则传出错误信息
					返回值	String		订单号（如果为空则判断为操作失败）

					

	*/
	function CancelOrder();



	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	修改订单备注      		public void ChgNotice(string htlcd, string memtyp, string icnum, string mempwd, string booknum, string notice, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数	    类型	    	描述
					htlcd	string		酒店代码
					memtyp	string		会员类别 0-非会员1-门户注册会员，3-酒店会员
					icnum	string		卡号
					mempwd	string		密码
					booknum	String		订单号
					notice	String 		订单备注
					errstr	ref string	如果出错，则传出错误信息

					

	*/
	function ChangeNotice();



	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	修改订单支付状态接口      Wechat.ChgNotice(htlcd, memtyp, icnum, mempwd, booknum,  "票据号：" + notice , "1", ref errstr); ）
	+-------------------------------------------------------------------------   
	

					参数	    类型	    	描述
					htlcd	string		酒店代码
					memtyp	string		会员类别 0-非会员1-门户注册会员，3-酒店会员
					icnum	string		卡号
					mempwd	string		密码
					booknum	String		订单号
					notice	String 		订单备注
					errstr	ref string	如果出错，则传出错误信息

					

	*/
	function ChangeOrderStatus();



}



?>