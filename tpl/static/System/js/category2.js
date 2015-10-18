var CFD = "不限";
var CSD = "不限";
var CMD = "不限";
var ShowT = 0;


var CFData = [];
var CSData = [];
var CMData = [];
var CAData ='';
var CBData ='';
function CS() {
    var CLIST = arguments[6];
    CAData = CLIST.split("#");

    for (var i = 0; i < CAData.length; i++) {
		console.log(i+"----开始");
		var sdata=[];
		var mdata=[];		
        parts = CAData[i].split("$"); 
        CFData[i] = parts[0];
		if(parts[1]==''||typeof(parts[1])=='undefined'){ sdata=['无'];mdata[0]=['无-0'];
		CSData[i] =sdata;
	   CMData[i] = mdata;continue;}
		CBData=parts[1].split("|");  
		console.log(CBData.length+"----CBData"+i+"长度"); 
		for (var j = 0; j < CBData.length; j++) {
			parts2=CBData[j].split("@@");
			sdata[j]=  parts2[0];
			if(parts2[1]==''||typeof(parts2[1])=='undefined'){mdata[j]=['无-0'];continue;}
			mdata[j]=parts2[1].split(",");
				
		} 
			
		if(CBData.length==0){
                sdata=['无'];
         }
 
       CSData[i] =sdata;
	   CMData[i] = mdata;
	  console.log(i+"----结束"); 	
    }
	
    var self = this;
	if(arguments[0]!=""){
    	this.SelF = document.getElementById(arguments[0]);
	}
	if(arguments[1]!=""){
    	this.SelS = document.getElementById(arguments[1]);
	}
	if(arguments[2]!=""){
		this.SelM = document.getElementById(arguments[2]);
	}

    this.DefF = arguments[3]; 
    this.DefS = arguments[4];
	this.DefM = arguments[5];
    if(arguments[0]!=""){
    	this.SelF.CS = this;
	}
	if(arguments[1]!=""){
    	this.SelS.CS = this;
	}
	if(arguments[2]!=""){
		this.SelM.CS = this;
	}
    this.SelF.onchange = function () {
        CS.SetS(self)
    };
	this.SelS.onchange = function () {
        CS.SetM(self)
    };
     CS.SetF(this)
};
CS.SetF = function (self) {
    for (var i = 0; i < CFData.length; i++) {
        var title, value;
        title = CFData[i].split("-")[0];
        value = CFData[i].split("-")[1];
        if (title == CFD) { value = "" }
        self.SelF.options.add(new Option(title, value));
        if (self.DefF == value) { self.SelF[i].selected = true }
    }
    CS.SetS(self)
};
CS.SetS = function (self) {
    var fi = self.SelF.selectedIndex;
    var slist = CSData[fi];
    self.SelS.length = 0;
    for (var i = 0; i < slist.length; i++) {
        var title, value;
        title = slist[i].split("-")[0];
        value = slist[i].split("-")[1];
        if (title == CSD) { value = "" }
        self.SelS.options.add(new Option(title, value));
        if (self.DefS == value) {
            self.SelS[self.SelF.value == "" ? i + 1 : i].selected = true
        }
    }
	CS.SetM(self);
};
CS.SetM = function (self) {
    var fi = self.SelF.selectedIndex;
	var si = self.SelS.selectedIndex;
	var slist=[];

    self.SelM.length = 0;
    if (self.SelF.value != "" && ShowT) {
        self.SelM.options.add(new Option(CMD, ""));
		 var slist = CMData[fi][si-1];
    }else{
		 var slist = CMData[fi][si];
	}

	for (var i = 0; i < slist.length; i++) {
			var title, value;
			title = slist[i].split("-")[0];
			value = slist[i].split("-")[1];
			if (title == CMD) { value = "" }
			self.SelM.options.add(new Option(title, value));
			if (self.DefM == value) {
				self.SelM[self.SelS.value == "" ? i + 1 : i].selected = true
			}
	}
	
}