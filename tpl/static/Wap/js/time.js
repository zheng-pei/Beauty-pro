// JavaScript Document
$(function(){
	var n_time=new Date();
	var r_year=n_time.getFullYear();
	var r_month=n_time.getMonth()+1;
	var r_date=n_time.getDate();
	var r_day=n_time.getDay();
	var n_time_s=new Date(r_year+"/"+r_month+"/"+r_date+" 0:00:00").getTime();
	// alert(n_time);获取当前的时间，年月日时分秒
	var r_html="";
	//可预约未来的天数
	var ymd_now=n_time;
	// 可以通过后台的数据来确定值是否约满
	// var r_man=[0,1,1,1,0,1,0,1,1,1,1,0,1,0,1,0,1]; //预约16天，今天和未来r_fount天的预约情况,0为已满，1为未满
	// $.post("{weiwin::U('Order/ymdstatus')}",{ymd_now:ymd_now},function(data){
	
	r_html+='<tr>';
	for(var i=1;i<=r_day;i++){
		if(i==r_day && r_man[0]==1){
			r_html+='<td><a data="'+get_day(n_time_s-86400000*(r_day-i))+'" data-day="'+get_day(n_time_s-86400000*(r_day-i),2)+'">'+get_day(n_time_s-86400000*(r_day-i),1)+'</a></td>';
			}
		else if(i==r_day && r_man[0]==0){
			// 通过后台查询今天天的返回的结果可以将约满变成空
			r_html+='<td><div class="td_yue color_fe">今天<p>约满</p></div></td>';
			}
		else{
			r_html+='<td>'+get_day(n_time_s-86400000*(r_day-i),1)+'</td>';
			}
	}
	for(var j=0;j<=((parseInt(r_fount/7)+1)*7-r_day-1);j++){
		if(j<r_fount && r_man[j+1]==0){
			// 通过后台查询某天的返回的结果可以将约满变成空
			r_html+='<td><div class="td_yue">'+get_day(n_time_s+86400000*(j+1),1)+'<p>约满</p></div></td>';
			}
		else if(j<r_fount && r_man[j+1]==1){
			r_html+='<td><a data="'+get_day(n_time_s+86400000*(j+1))+'" data-day="'+get_day(n_time_s+86400000*(j+1),2)+'">'+get_day(n_time_s+86400000*(j+1),1)+'</a></td>';
		}
		else{
			r_html+='<td>'+get_day(n_time_s+86400000*(j+1),1)+'</td>';
			}
		if((r_day+j)%7==6){
			r_html+='</tr><tr>';
			}
		
		}
	r_html+='</tr>';
	$("#rili table").append(r_html);
	$("#rili table a").eq(0).addClass("cur");
	$("#rili_val").val($("#rili table .cur").attr("data"));
	$(document).on("click","#rili table a",function(){
		$("#rili table .cur").removeClass("cur");
		$(this).addClass("cur");
		$("#rili_val").val($("#rili table .cur").attr("data"));
		$("#rili_val_day").val($("#rili table .cur").attr("data-day"));
		})
	// })
})
function get_day(time,x){
	var t_time=new Date(time);
	var t_year=t_time.getFullYear();
	var t_month=t_time.getMonth()+1;
	var t_date=t_time.getDate();
	var t_day_arr=['周日','周一','周二','周三','周四','周五','周六'];
	var t_day=t_day_arr[t_time.getDay()-0];
	if(x==1){
		return t_date;
		}
	else if(x==2)
	{
		return t_day;
	}
	else{
		return t_year+"-"+t_month+"-"+t_date;
		}
	}

	/*重新渲染时间选择*/
function reset_time(date_now){
	var data_now=$('#rili_val').val();
	$("#stimelayer .cur").removeClass("cur");
	// 获取你选择的时间
	 $.post("index.php?m=Order&a=choosedate",{"date_now":date_now,"serviceid":serviceid,"beautyid":beautyid},function(data){
		 var obj=eval("("+data+")");
		 var data_n=[];
		 $.each(obj,function(index,value){
				data_n.push(value); 
		 });
		
		var is_time=true;
		for(var j=0;j<$("#stimelayer li").length;j++){
			var this_now=$("#stimelayer li").eq(j);
			if(data_n[j]==0){
				this_now.html('<div class="yutime">'+this_now.attr("data")+'<p>约满</p></div>');
			}
			else{
				this_now.html(this_now.attr("data"));
			}	
			if(is_time && data_n[j]==1){
				this_now.addClass("cur");
				is_time=false;
			}
		}
		$("#timelayer").addClass("none");
		getHeight();
	})
}