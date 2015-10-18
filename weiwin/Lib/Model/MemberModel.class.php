<?php
    class MemberModel extends RelationModel{
      
        protected $_link=array(
           
        );
        
        protected function _after_insert($data, $options) {
           // $invitecode=geninvitecode();
           // M("member")->where("id=".$data["id"])->setField("invitecode",$invitecode);
         //  M("cardhistory")->add(array("cardnum"=>$data["num"]));
        }
    }
?>