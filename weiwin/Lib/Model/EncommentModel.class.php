<?php
    class EncommentModel extends RelationModel{
       
        protected $_link=array(
            "en_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'engineer',
                'foreign_key'=>'enid',
                'mapping_name'=>'truename',
                'mapping_fields'=>'truename',
                'mapping_key'=>'id',
                'as_fields'=>'truename'
            ),
            "mem_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'member',
                'foreign_key'=>'memberid',
                'mapping_name'=>'username,pic,num',
                'mapping_fields'=>'username,pic,num',
                'mapping_key'=>'id',
                'as_fields'=>'username,pic,num:unum'
            ),
            "order_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'order',
                'foreign_key'=>'orderid',
                'mapping_name'=>'ordernum',
                'mapping_fields'=>'ordernum',
                'mapping_key'=>'id',
                'as_fields'=>'ordernum'
            )
        );
        
       
        
    }
?>