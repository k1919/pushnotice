<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-20
 * Time: 10:55
 */
namespace wenshi\push\notice;


class PushNotice
{

    const PUSH_URL = "http://pushnotice.wszx.cc/api.php?app=";




    protected static $_sign;

    public static function setSign($sign)
    {
        self::$_sign = $sign;
    }



    /*
     * 注册CID(如果存在直接修改)
     *@param   uid 用户ID
     * @param  cid
     * */
    public  static  function regCid($uid,$cid){
      return  self::doPush(['uid'=>$uid,'cid'=>$cid],'push@RegCid');
    }

    /*
     * 发送多条或者一条信息
     *
     * uid  用户uid
     * title 发送的标题
     * content  发送的内容
     * url 打开地址
     * param 参数[]
     * url_type 1 在app内打开   2 在某一个网站打开
     *
     * */

    public  static  function  PushNotice($uid,$tltle,$content,$url,$param=[],$url_type=1){
        $data=[
             'uid'=>$uid,
             'title'=>$tltle,
             'content'=>$content,
             'url'=>$url,
             'param'=>json_encode($param),
             'url_type'=>$url_type
            ];
        return self::doPush($data,'push@DoPush');
    }


    public  static  function  PushAll($tltle,$content,$url,$param=[],$url_type=1){
            $data=[
                'title'=>$tltle,
                'content'=>$content,
                'url'=>$url,
                'param'=>json_encode($param),
                'url_type'=>$url_type
            ];
            return self::doPush($data,'push@DoPush');
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