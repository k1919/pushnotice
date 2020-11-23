<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-20
 * Time: 10:55
 */
namespace wstools\push\notice;


class PushNotice
{

    const PUSH_URL = "http://pushnotice.wszx.cc/api.php?app=";




    protected static $_sign;

    public static function setSign($sign)
    {
        self::$_sign = $sign;
    }
    public  static  function regCid($uid){
        self::doPush(['uid'=>$uid],'push@RegCid');
    }
    /**
     * 发送验证码
     */
    public static function pushOneMsg($uid,$msg,$title,$url)
    {
        $content=[
            'uid'=>$uid,
            'msg'=>$msg,
            'title'=>$title,
            'ulr'=>$url,
        ];
        return self::doPush($content,'');
    }



    protected static function doPush($content,$route)
    {

        $content['sign']=self::$_sign;
        $request = json_decode(self::curlRequest(self::PUSH_URL.$route,false,'post',$content),true);
        if(!empty($_REQUEST['debug'])){
            var_dump($request);exit;
        }
        if($request['code'] == '1'){
            return true;
        }else{
            return false;
        }
    }

    protected static function curlRequest($url, $https = true, $method = "get", $data = null, $json = false)
    {
        $headers = array(
            "Content-type: application/json;charset='utf-8'",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($method === 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($json) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}