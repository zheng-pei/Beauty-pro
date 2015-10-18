<?php
    class OrderModel extends RelationModel{
       
        protected $_link=array(
            "beauty_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'beautician',
                'foreign_key'=>'beautyid',
                'mapping_name'=>'beautyname',
                'mapping_fields'=>'name',
                'as_fields'=>'name:beautyname'
            ),
        );
        
        protected $_validate = array(   
            array('username','require','用户名不能为空!'), 
            array('phone','require','手机号码不能为空!'),  
        );   
    }
?>