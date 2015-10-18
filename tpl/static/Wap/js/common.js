// JavaScript Document
$(function(){
	/*首页切换*/
	 $('.top_nav li').click(function(){
		 $(this).addClass('cur').siblings().removeClass('cur');
		 var index=$('.top_nav li').index($(this));
		 $(this).parents('.main').find('.m_service_list').hide();
		 $(this).parents('.main').find('.m_service_list').eq(index).removeClass('none').fadeIn();
		
		 })
/*选择时间*/
    $('#xztime').click(function(){
		$("body").append('<div class="bg_fix" id="ch_bgfix"></div>');
		$("#timelayer").removeClass("none");
		})
	$('#close').click(function(){
		$("#timelayer").addClass("none");
		$("#ch_bgfix").remove();
		})
	$(document).on("click","#ch_bgfix",function(){$("#timelayer").addClass("none");$(this).remove();})
    $(document).on("click","#rili a",function(){
		$("#stimelayer").removeClass("none");
		$("#stimelayer h4").text($(this).attr("data")+"("+$(this).attr("data-day")+")");
		reset_time($(this).attr("data"));
		})
	$('#close2').click(function(){
		$("#stimelayer").addClass("none");
		$("#ch_bgfix").remove();
		})
	$(document).on("click","#ch_bgfix",function(){$("#stimelayer").addClass("none");$(this).remove();})
	$(document).on("click","#stimelayer li",function(){
		if($(this).find(".yutime").length<1){
			$(this).addClass("cur").siblings().removeClass("cur");
		}
		})
	$(document).on("click",".queren",function(){
		$("#time_val").val($("#stimelayer .cur").text());
		$("#xztime").text($("#rili_val").val()+" "+$("#time_val").val());
		$("#stimelayer").addClass("none");
		$("#ch_bgfix").remove();
		})
	
/*选择美容师*/	
	$(document).on("click","#meilist .m_service_logo",function(){
		$(this).parents("li").addClass('cur').siblings().removeClass('cur');
		$("#xz_mei").val($("#meilist li.cur").attr("date-id"));
		})
		
/*选择星级*/	
     /*手法*/
   $('#m_star a').click(function(){
	   var i;
	   var sindex=$(this).parent().index();
	   $("#m_star a").removeClass("cur");
	   for(i=0;i<sindex;i++){
		   $("#m_star li").eq(i).find("a").addClass("cur");
		   }
		 $("#m_star .pj_star").val(sindex);	
	   })	
	   /*服务*/
	    $('#m_star1 a').click(function(){
	   var i;
	   var sindex=$(this).parent().index();
	   $("#m_star1 a").removeClass("cur");
	   for(i=0;i<sindex;i++){
		   $("#m_star1 li").eq(i).find("a").addClass("cur");
		   }
		 $("#m_star1 .pj_star1").val(sindex);	
	   })	
	   /*礼仪*/
	    $('#m_star2 a').click(function(){
	   var i;
	   var sindex=$(this).parent().index();
	   $("#m_star2 a").removeClass("cur");
	   for(i=0;i<sindex;i++){
		   $("#m_star2 li").eq(i).find("a").addClass("cur");
		   }
		 $("#m_star2 .pj_star2").val(sindex);	
	   })	
if($("#top_scroll").length>0){ myscroll();}	
window.addEventListener('load', function() {
  FastClick.attach(document.body);
}, false);
		
})
function getHeight(){
	var myscr1;
	var wheight=$(window).height();
	var boxHeight=$('#stimelayer .pr_nav').height();
	var pr_top=$("#stimelayer .pr_top").height();
	var pr_bottom=$("#stimelayer .queren").height()+40;
	if(boxHeight>(wheight*0.6)){
		$('#stimelayer').height(wheight*0.6+pr_top+pr_bottom).css({"margin-top":0,"top":"10%"});
		$("#timecon").height(wheight*0.6);
		myscr1 = new IScroll('#timecon', { eventPassthrough: false, scrollX: false, scrollY: true, preventDefault: false });
		$("#stimelayer").get(0).addEventListener('touchmove', function (e) { e.preventDefault(); }, false); //清除区域内默认滚动事件
		}
	else{
		$('#stimelayer .pr_nav').parent().height(boxHeight);
		$('#stimelayer').css("margin-top",-($('#stimelayer').height())*0.5+"px");
		}	
	
}
/*字数不超过50*/
function check_len(a,b){
	var b_len=parseInt(a.attr("maxlength"));
	if(a.val().length>=b_len){
		a.val(a.val().substring(0,b_len));
		}
	b.text(b_len-a.val().length);
	}
 /*水平滚动*/
function myscroll(){
	var my_scr;
	var navwidth=$(window).width();
	$("#top_scroll ul li").css('width',navwidth/4);
	$("#top_scroll .top_nav").width($("#top_scroll ul li").eq(0).width()*$("#top_scroll ul li").length);
	my_scr = new IScroll('#top_scroll', { eventPassthrough: true, scrollX: true, scrollY: false, preventDefault: false });
    my_scr.scrollToElement($("#top_scroll .cur").get(0));
}
/*提交订单抵扣积分*/
function reset_price(obj){
	var t_max=parseInt($(obj).attr("data-max"));
	var t_lv=$(obj).attr("data-lv");
	var s_price=$("#d_price").val();
	var dk_price;
	var t_val=$(obj).val().replace(/[^0-9]/g,'');
	if(t_val==""){$(obj).val('');t_val=0}
	else{
		if(t_val>t_max){
			t_val=t_max;
		}
		$(obj).val(t_val);
	}
	dk_price=parseFloat(t_val*t_lv).toFixed(2);
	$("#dkou").text(dk_price);
	$("#sfu").text(parseFloat(s_price-dk_price).toFixed(2));
	$("#u_jifen").val(dk_price);
	$("#e_price").val($("#sfu").text());
	}


/*表单验证*/
$(function(){
var $from = $("form.form-validate");
        if ($from.length > 0) {
            $from.each(function () {
                $(this).validate({
                    errorElement: "p",
                    errorClass: "help-block error",
                    errorPlacement: function (e, t) {

                        var p = t.parents(".controls");
                        if (p.length > 0) {
                            p.append(e)
                        } else {
                            t.addClass("error")
                        }
                    },
                    highlight: function (e) {
                        $(e).removeClass("error success").addClass("error");
                        //$(e).closest(".control-group").removeClass("error success").addClass("error");
                    },
                    success: function (e) {
                        e.addClass("valid").removeClass("error success")
                    },
                    submitHandler: function (form) {
                        var _sb = true;
												form.submit();
                       
                    }
                })
            })
        }
	
});