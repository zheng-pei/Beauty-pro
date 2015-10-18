<?php
class ArticleModel extends RelationModel{

         protected function _after_delete($data) {
            $model=M('ablum');
            $result=$model->where("imgtype=1 and relatid not in (select id from sk_Article)")->delete();
        }
    }
?>