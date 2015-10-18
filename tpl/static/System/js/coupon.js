
function deletecdata(sdic,svalue)
{
	for(var i=0;i<sdic.length;i++)
	{
		if(sdic[i]==svalue)
		{
		sdic.splice(i, 1);
		}
	}
	return sdic;
}

function  removeuncard (oserviceid,cid,cisfree,cserviceid)
{
	
	//适用服务字典
	 var serviceiddic=new Array();

	 //测试字典
	 	   var fundic=new Array();
		//保留下的卡券 
		var remainidlist=cid.slice(0); 
		//除了免费服务剩余列表 
	var klremainidlist=remainidlist.slice(0);
		
	//	alert(1);
	 for(var i=0;i<cid.length;i++)
    {
	   serviceiddic[cid[i]]=cserviceid[i];
    }
     
	// alert(2);
     var removeidlist=new Array();
	  var freeidlist=new Array();
	  
	  var fundic=new Array();
	//  alert(3);
	  //去除多余的免费券 找出剩余的免费券
     for(var i=0;i<cid.length;i++)
    {
        if(cisfree[i]=="1")
        {
			if(typeof(fundic[cserviceid[i]])=="undefined")
			{
			fundic[cserviceid[i]]=cid[i];
			freeidlist.push(cid[i]);
			}
			else
			{
		    removeidlist.push(cid[i]);
			remainidlist=deletecdata(remainidlist,cid[i]);
			}
		klremainidlist=deletecdata(klremainidlist,cid[i]);
        }
    }

	
	//清除与免费券在同服务下但不包含其他服务的

	      for(var i=0;i<klremainidlist.length;i++)
              {
				
				  var  strreserviceid=serviceiddic[klremainidlist[i]]+','; 
				  var iscontant=false; 
				  //卡券去除免费服务
				  //服务里面在去除免费服务
                    for(var j=0;j<freeidlist.length;j++)
                   {
					   strreserviceid=strreserviceid.replace(new RegExp(serviceiddic[freeidlist[j]]+",","g"),"");
					   oserviceid=deletecdata(oserviceid,serviceiddic[freeidlist[j]]);
				   }
				
				//    alert(6);
				   
                //是否包含其他非免费的服务      
				for(var k=0;k<oserviceid.length;k++)
				{
				   if(strreserviceid.indexOf(oserviceid[k]+",")!=-1)
				  {
					iscontant=true;
				     break;
				  }
			    }
				
					//		    alert(7);
				//没有包含就去掉
				//alert(iscontant);
				  if(!iscontant)
				{
				 removeidlist.push(klremainidlist[i]);	   
				 remainidlist=deletecdata(remainidlist,klremainidlist[i]);
				}		   
				//	alert(8);	 
					   
              }
			  
			
				 
           return remainidlist;   

}