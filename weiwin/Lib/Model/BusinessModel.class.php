<?php
class BusinessModel extends RelationModel{
    protected $_validate = array(
        array('name','','商铺已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
    );
    protected $_link = array(
        'Area'=>array(
            'mapping_type'=>BELONGS_TO,
            'class_name'=>'Area',
            'foreign_key'=>'areaid',
            'mapping_name'=>'areaname',
            'mapping_fields'=>'areaname',
            'as_fields'=>'areaname'   
        )
    );
}