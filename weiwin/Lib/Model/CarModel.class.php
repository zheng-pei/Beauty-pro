<?php
    class CarModel extends RelationModel{
        protected $_validate = array(
            array('carname','','此车系名称已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        );
        protected $_link=array(
            "brand_name"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'brand',
                'foreign_key'=>'brandid',
                'mapping_name'=>'brandname',
                'mapping_fields'=>'brandname',
                'mapping_key'=>'id',
                'as_fields'=>'brandname'
            )
        );
        
    }
?>