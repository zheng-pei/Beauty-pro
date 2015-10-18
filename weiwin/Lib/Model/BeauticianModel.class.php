<?php
class BeauticianModel extends RelationModel{
/*     protected $_validate = array(
        array('name','','已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
    ); */
    protected $_link = array(
         'Area'=>array(
            'mapping_type'=>BELONGS_TO,
            'class_name'=>'area',
            'foreign_key'=>'areaid',
            'mapping_name'=>'areaname',
            'mapping_fields'=>'areaname',
            'as_fields'=>'areaname'
        ) ,
        
        'Business'=>array(
            'mapping_type'=>BELONGS_TO,
            'class_name'=>'business',
            'foreign_key'=>'bsid',
            'mapping_name'=>'busname',
            'mapping_fields'=>'name',
            'as_fields'=>'name:bsname'
            )
        
    );
}