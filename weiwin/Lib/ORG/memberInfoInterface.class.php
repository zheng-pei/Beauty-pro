<?php
/*
 * 酒店房间预订接口
 *
 */

interface memberInfoInterface 
{
	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	注册/修改会员信息      public string UserRegister(string editTyp, string htlcd, string memtyp, string icnum, string memnm, string pwd, string phone, string mail, string city, string crtftyp, string crtfnum, string birthday, string sex, refstring errstr)
	+-------------------------------------------------------------------------   

					参数		类型		描述
					editTyp	string	1-注册 2-修改
					htlcd	string	酒店代码
					Memtyp	String	卡种类（1-门户注册会员，3-酒店会员），修改时传入
					icnum	string	卡号
					memnm	string	姓名
					pwd		string	密码
					phone	string	手机号
					mail	string	电子邮件地址
					city	string	省市
					crtftyp	string	证件类型
					crtfnum	string	证件号码
					birthday string	生日
					sex		string	性别（01男，02女）
					errstr	ref string	如果出错，则传出错误信息
					返回值	string	"逗号分隔：
									卡号,卡种类（1-门户注册会员，3-酒店会员）,卡类（酒店会员需要）
										如果为空则判断为操作失败"
	
	*/
	function UserRegister();




	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询会员信息      public string GetMemberInfo(string htlcd, string memtyp, string icnum, string icref, string pwd, string phone, string crtfnum, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数	    类型	    描述
					htlcd	string	酒店代码
					icnum	string	卡号
					icref	string	参考号
					pwd		string	密码
					phone	string	手机号
					crtfnum	string	证件号码
					errstr	ref string	如果出错，则传出错误信息
							返回值	string	"以逗号分隔的会员信息，格式如下：
											卡类,卡类描述,参考号,密码,会员卡状态,姓名,消费总额,手机,邮件,
											国籍描述,证件类型,证件号,生日,性别,积分,会员余额,卡种类（1-门户注册会员，3-酒店会员）,卡号"

	*/
	function GetMemberInfo();


	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询积分消费明细      		public DataSet GetIcstatInfo (string htlcd, string memtyp, string icnum, DateTime bgDt, DateTime edDt, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数	    类型	    	描述
					htlcd	string		酒店代码
					memtyp	string		会员类别 1-门户注册会员，3-酒店会员
					icnum	string		卡号
					bgDt	DateTime	起始日期
					edDt	DateTime	终止日期
					errstr	ref string	如果出错，则传出错误信息
										返回值	DataSet	"返回结果集包含一张表，表中包含的列如下：
										卡号、交易日期、费用分类代码、费用分类描述、消费金额、积分、酒店代码、酒店名称"

	*/
	function GetIcstatInfo();


	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询储值交易明细      		publicDataSetGetIcpayInfo(string htlcd, string memtyp, string icnum, DateTime bgDt, DateTime edDt, string transflg, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数		类型			描述
					htlcd	string		酒店代码
					memtyp	string		会员类别 1-门户注册会员，3-酒店会员
					icnum	string		卡号
					bgDt	DateTime	起始日期
					edDt	DateTime	终止日期
					transflg	string	交易标志0 充值，1 消费空则为全部
					errstr	ref string	如果出错，则传出错误信息
										返回值	DataSet	"返回结果集包含一张表，表中包含的列如下：
										卡号、交易日期、交易代码、交易描述、交易金额、帐号、房号、帐单号、备注、酒店操作员、酒店代码、酒店名称、交易类型描述"

	*/
	function GetIcpayInfo();

	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询可兑换礼品      		publicDataSetGetIcApply (string htlcd, string memtyp, string icnum, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数		类型			描述
					htlcd	string		酒店代码
					memtyp	string		会员类别 1-门户注册会员，3-酒店会员
					icnum	string		卡号
					errstr	ref string	如果出错，则传出错误信息
					返回值	DataSet	"返回结果集包含一张表，表中包含的列如下：
										奖励代码、奖励描述、所需积分、奖品详细信息"

					

	*/
	function GetIcApply();



	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	积分兑换      		public bool IcApplyScore (string htlcd, string memtyp, string icnum, string pwd,string applycd, string applydrpt, DateTimeapplyDt, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数	    类型	    	描述
				htlcd		string	酒店代码
				memtyp		string	会员类别 1-门户注册会员，3-酒店会员
				icnum		string	卡号
				pwd			string	密码
				applycd		string	奖励代码
				applydrpt	string	奖励描述
				applyDt		DateTime	兑换日期
				errstr		ref string	如果出错，则传出错误信息
										返回值	bool	返回是否执行成功

					

	*/
	function IcApplyScore();



	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	查询会员的历史兑换列表      public   DataSet   GetIcApplyPoint(string htlcd, string memtyp, string icnum, refstring errstr)
	+-------------------------------------------------------------------------   
	

					参数	    类型	    	描述
					
					htlcd	string	酒店代码
					memtyp	string	会员类别 1-门户注册会员，3-酒店会员
					icnum	string	卡号
					返回值	DataSet	"返回结果集包含一张表，表中包含的列如下：
					奖励代码、奖励描述、所需积分、兑换日期、审核状态(0 未确认，1 已确认)、兑换数量"
					

	*/
	function GetIcApplyPoint();



	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	短信验证      		publicstring SendSMS(string htlcd, string tel, string code, refstring errstr)
	+-------------------------------------------------------------------------   
	
					参数		类型		描述
					htlcd	string	酒店代码
					tel		string	手机号
					code	string	验证码
					errstr	refstring	如果出错，则传出错误信息

	*/
	function SendSMS();
	



	/**
	+-------------------------------------------------------------------------
	+	功能	             |     方法
	+-------------------------------------------------------------------------
	+	重置密码     			publicvoid PwdReset(string htlcd, string tel, string pwd, outstring errstr)
	+-------------------------------------------------------------------------   
	

					参数		类型		描述
					htlcd	string	酒店代码
					tel		string	手机号
					pwd		string	密码
					errstr	refstring	如果出错，则传出错误信息
										

	*/
	function PwdReset();



}



?>