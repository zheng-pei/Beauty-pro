<?php
// +----------------------------------------------------------------------
// | G3weixin [ ALL WHERE,ALL TIME ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://lietouzhe.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 微信信息推送、事件推送程序
 */
class WeixinAction extends Action{
    private $token;
	private $fun;
	private $data = array ();
	
        public function _initialize(){
            $this->appID=C('appid');
            $this->appSecret=C('appkey');
        }
	public function index() 

	{
		$this->token = $_GET["token"];
		$weixin = new Wechat ( $this->token );
                $data = $weixin->request();
                list ( $content, $type ) = $this->reply ( $data );	
		$weixin->response ( $content, $type );
    }
        private function reply($data){
            if ('click' == strtolower($data ['Event'])) {	
			$data ['Content'] = $data ['EventKey'];
                        exit;
            }elseif('subscribe' == strtolower($data ['Event'])){
               return array (
						"非常感谢关注小美平台，这里有最新上线的美容项目，最专业的美容老师，最给力的优惠活动，最火爆的游戏大奖，更有像花儿一样漂亮的小美小编——神仙妹，有啥问题或建议欢迎骚扰:)",
						'text' 
					);
                
            }
            
           
        }
        
        function wxApi($url){  
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1 );
            $output=curl_exec($ch);
            curl_close($ch);

            //$output='{"access_token":"125bd9bfc74b808b","appsecret":"3d90da73abe125bd9bfc74b808b93948"}';
            $jsoninfo=json_decode($output,true);
            //$access_token=$jsoninfo['access_token'];
            return $jsoninfo;
        }
	
}

?>