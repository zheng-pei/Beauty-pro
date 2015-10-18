var CFD = "请选择";
var CSD = "请选择";
var CMD = "请选择";
var CDD = "请选择";
var ShowT = 0;

var CFData = [];
var CSData = [];
var CMData = [];

var CAData ='';
var CBData ='';
function CS() {

    if (ShowT)
        CLIST = CFD + "$" + CSD + "#"+CMD+"@@"+ CLIST;

    	CAData = CLIST.split("@@");

		for (var i = 0; i < CAData.length; i++) {	
			
			var sdata=[];
			var mdata=[];			
			parts = CAData[i].split("$");
			CFData[i] = parts[0];
            if(parts[1]==''){continue;}
			CBData=parts[1].split("|"); 
			
			for (var j = 0; j < CBData.length; j++) {
				parts2=CBData[j].split("#");
				sdata[j]=  parts2[0];
				if(parts2[1]==''){mdata[j]=['无-0'];continue;}
				mdata[j]=parts2[1].split(",");
				
			}
            if(CBData.length==0){
                sdata=['无'];
            }

            CSData[i] =sdata;
			CMData[i] = mdata;


		}
		//            alert(CMData[1]);
		//	alert(CMData[1]);
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
	if(arguments[6]!=""&&typeof(arguments[6])!="undefined"){
		this.SelDI = document.getElementById(arguments[6]);
	}
    this.DefF = arguments[3]; 
    this.DefS = arguments[4];
	this.DefM = arguments[5];
	if(arguments[7]!=""&&typeof(arguments[7])!="undefined"){
		this.DefDI = arguments[7];
	}
	if(arguments[0]!=""){
    	this.SelF.CS = this;
	}
	if(arguments[1]!=""){
    	this.SelS.CS = this;
	}
	if(arguments[2]!=""){
		this.SelM.CS = this;
	}
	if(arguments[6]!=""&&typeof(arguments[6])!="undefined"){
		this.SelDI.CS = this;
		//alert(arguments[6]);
	}
    this.SelF.onchange = function () {
        CS.SetS(self)
    };
	this.SelS.onchange = function () {
        CS.SetM(self)
    };
	if(arguments[6]!=""&&typeof(arguments[6])!="undefined"){
		this.SelM.onchange = function () {
        	CS.SetDI(self)
    	};
	}
     CS.SetF(this);
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
    if (self.SelF.value != "" && ShowT) {
        self.SelS.options.add(new Option(CSD, ""));
    }

    for (var i = 0; i < slist.length; i++) {
        var title, value; 
        title = slist[i].split("-")[0];
        value = slist[i].split("-")[1];
        if (title == CSD) { value = "" }
        self.SelS.options.add(new Option(title, value));
        if (self.DefS == value) {
			if(ShowT){
				self.SelS[i+1].selected = true;
			}else{
            	self.SelS[i].selected = true;
			}
        }	
    }

	CS.SetM(self)
};
CS.SetM = function (self) {
    var fi = self.SelF.selectedIndex;
	var si = self.SelS.selectedIndex;


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
				if(ShowT){
					self.SelM[i+1].selected = true;
				}else{
					self.SelM[i].selected = true;
				}
			}
	}
	if(self.SelDI!=""&&typeof(self.SelDI)!="undefined"){
		CS.SetDI(self)
	}
	
}
CS.SetDI = function (self) {
	var fi = self.SelF.selectedIndex;
	var si = self.SelS.selectedIndex;
	var mi = self.SelM.selectedIndex;
	var sheng=self.SelF.options[fi].value;
	var shi=self.SelS.options[si].value;
	var qu=self.SelM.options[mi].value;
	 self.SelDI.length = 0;
	if(sheng!=""&&shi!=""&qu!=""){
		var darr=eval('('+DList+')');
		var slist=darr[sheng][shi][qu];
		if (ShowT) {
			self.SelDI.options.add(new Option(CDD, ""));
		}
		for (var i = 0; i < slist.length; i++) {
			var title, value;
			value = slist[i].split("-")[0];
			title = slist[i].split("-")[1];
			if (title == CDD) { value = "" }
			self.SelDI.options.add(new Option(title, value));

			if (self.DefDI == value) {
				if(ShowT){
					self.SelDI[i+1].selected = true;
				}else{
					self.SelDI[i].selected = true;
				}
			}
		}
	}
}