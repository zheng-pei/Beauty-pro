<?php
   class CouponModel extends Model{
       protected function _after_insert($data, $options) {
          if($data["id"]){
              $arr=array();
              if($data["storenum"]>0){
                 $arr["cpid"]=$data["id"];
                 $arr["status"]=0;
                 $arr["serviceid"]=$data["serviceid"];
                 $arr["price"]=$data["price"];
                 for($i=1;$i<=$data["storenum"];$i++){
                    $code=  generate_password(6);
                    do{
                        $iscz=M("couponsingle")->where("code='".$code."'")->count();
                        if($iscz==0){
                            break;
                        }else{
                            $code=  generate_password(6);
                        }
                    }while(1);
                    $arr["code"]=$code;
                    M("couponsingle")->add($arr);
                 }
              }
          }
       }
       
       protected function _after_update($data, $options) {
           $arr=array();
           $arr["serviceid"]=$data["serviceid"];
           $arr["price"]=$data["price"];
           M("couponsingle")->where("cpid=".$data["id"])->save($arr);
       }
        
    }
?>