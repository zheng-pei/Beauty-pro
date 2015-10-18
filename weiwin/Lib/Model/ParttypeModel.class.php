<?php
    class ParttypeModel extends Model{
        protected $_validate = array(
            array('typename','','该配件类型已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        );
       
    }
?>