<?php
    class ServiceModel extends RelationModel{
        /* protected $_validate = array(
            array('sname','','该服务名称已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        ); */
        protected $_link=array(
            "Servicetype"=>array(
                'mapping_type'=>BELONGS_TO,
                'class_name'=>'servicetype',
                'foreign_key'=>'classid',
                'mapping_name'=>'classname',
                'mapping_fields'=>'classname',
                'as_fields'=>'classname'
            ),
        );
    }
?>