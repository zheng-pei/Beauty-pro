<?php
    class BrandModel extends Model{
        protected $_validate = array(
            array('brandname','','该品牌名称已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        );
       
    }
?>