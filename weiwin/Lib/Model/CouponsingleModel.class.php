<?php
    class CouponsingleModel extends RelationModel{
        
        protected $_link=array(
            "cp_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'coupon',
                'foreign_key'=>'cpid',
                'mapping_name'=>'cpname,isfree,remark',
                'mapping_fields'=>'cpname,isfree,remark',
                'mapping_key'=>'id',
                'as_fields'=>'cpname,isfree,remark'
            ),
            "mem_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'member',
                'foreign_key'=>'memberid',
                'mapping_name'=>'username,num,phone',
                'mapping_fields'=>'username,num,phone',
                'mapping_key'=>'id',
                'as_fields'=>'username,num,phone'
            )
        );
        
    }
?>