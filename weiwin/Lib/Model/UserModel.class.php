<?php
    class UserModel extends RelationModel{
        protected $_validate = array(
            array('username','','帐号名称已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        );
        protected $_link=array(
            "role_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'role',
                'foreign_key'=>'roleid',
                'mapping_name'=>'rolename',
                'mapping_fields'=>'rolename',
                'mapping_key'=>'id',
                'as_fields'=>'rolename'
            ),
            // "mem_name"=>array(
            //     'mapping_type'=>BELONGS_TO,
            //     'class_name'=>'member',
            //     'foreign_key'=>'memberid',
            //     //'mapping_name'=>'username,num',
            //     //'mapping_fields'=>'username,num',
            //     'mapping_key'=>'id',
            //     'as_fields'=>'username:memname,num'
            // )
            
        );
        // protected function _after_insert($data, $options) {
        //    M("member")->where("id=".$data["memberid"])->setField("memtype", 4);
        // }
        
        
        // protected function _after_update($data, $options) {
        //     M("member")->where("id=".$data["memberid"])->setField("memtype", 4);
        // }
        
    }
?>