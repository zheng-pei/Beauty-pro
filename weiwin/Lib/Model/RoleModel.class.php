<?php
    class RoleModel extends Model{
        protected $_validate = array(
            array('rolename','','该角色名称已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        );
       
    }
?>