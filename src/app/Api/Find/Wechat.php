<?php
/**
 * User: kewin.cheng
 * Date: 2018/1/9
 * Time: 10:51
 */

namespace App\Api\Find;

use App\Common\Utils\Code;
use App\WxCore\lib\WxPayConfig;
use App\WxCore\WXAuth;
use App\WxCore\WxComponentApi;
use PhalApi\Api;
use PhalApi\Exception;

/**
 * 微信相关接口
 * Class Wechat
 * @package App\Api\Find
 */
class Wechat extends Api{

    public function getRules(){
        return array(
            'getAccessToken' => array(
                'thirdSessionKey' => array('name' => 'thirdSessionKey', 'type' => 'string', 'require' => true, 'desc' => '第三方session'),
                'appId' => array('name' => 'appId', 'type' => 'string', 'max' => 18, 'require' => true, 'desc' => 'appId'),
            ),
            'getQrcode' => array(
                'thirdSessionKey' => array('name' => 'thirdSessionKey', 'type' => 'string', 'require' => true, 'desc' => '第三方session')
            )
        );
    }

    /**
     * 获取accessToken
     * @desc 获取accessToken
     * @return string accessToken
     * @exception -100010 appId校验失败
     */
    public function getAccessToken(){
        if($this->appId != WxPayConfig::APPID){
            throw new Exception('appId校验失败', Code::VERIFY_APPID_FAIL);
        }

        return WXAuth::getAccessToken();
    }

    /**
     * 获取小程序二维码
     * @desc 获取不同场景下的小程序二维码
     * @param $accessToken
     */
    public function getQrcode(){

        $accessToken = WXAuth::getAccessToken();

        $data = array(
            'scene' => time(),
            'width' => '430',
            'auto_color' => false
        );

        //{"errcode": 0, "errmsg": "ok"}
        $data = WxComponentApi::getQrcode($accessToken, $data);

        return $data;
    }


}