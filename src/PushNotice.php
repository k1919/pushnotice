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
     * 退出关闭
     *@param   uid 用户ID
     * @param  cid
     * */
    public  static  function closeCid($uid,$cid){
        return  self::doPush(['uid'=>$uid,'cid'=>$cid],'push@CloseCid');
    }

    /*
     * 发送多条或者一条信息
     *
     * uid  用户uid(多个已逗号隔开)
     * title 发送的标题
     * content  发送的内容
     * data 参数[]
     * */

    public  static  function  Push($uids,$tltle,$content,$data=[]){
        $data=[
             'uids'=>$uids,
             'title'=>$tltle,
             'content'=>$content,
             'data'=>json_encode($data),
            ];
        return self::doPush($data,'push@push');
    }

    /*
        * 发送全部
        * title 发送的标题
        * content  发送的内容
        * data 参数[]
        *
        * */
    public  static  function  pushToApp($tltle,$content,$data=[]){
        $data=[
            'title'=>$tltle,
            'content'=>$content,
            'data'=>json_encode($data),
        ];
        return self::doPush($data,'push@pushToApp');
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
            return $request['msg'];
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