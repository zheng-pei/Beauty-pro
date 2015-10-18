<?php
class IndexAction extends BackAction{
	public function index(){
            $this->assign("userid", $_SESSION [C('USER_AUTH_KEY')]);
	    $this->display();	
	}
    
    public function edit() {
        $this->display();
    } 
    
    public function messages(){
        $map['isread']=array('neq',1);
        $noread=M('Order')->where($map)->count();
        echo $noread;
    }
}
?>