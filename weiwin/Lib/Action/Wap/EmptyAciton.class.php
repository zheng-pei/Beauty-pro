<?php
class EmptyAction extends Action{
    public function index(){
    	header("HTTP/1.0 404 Not Found"); 
        $this->display("Public:error");
    }

    public function _empty(){
        header("HTTP/1.0 404 Not Found"); 
        $this->display("Public:error");
    }
}