[toc]
## 推送服务：

使用之前务必初始化sign(全局有效,项目唯一码获取方式为在后台注册获得或者联系管理员)

```php
use wenshi\push\notice;

PushNotice::setSign('您的项目唯一码');
```

### 一，注册账户 

(用于注册手机序列号到商户服务)

如下代码 返回true为成功 false为失败


```php
use wenshi\push\notice;

/**
*@param uid   必填   用户id
*@param cid   必填   手机序列号
*/
PushNotice::regCid('5','2925b1bcf4eb21feffda6d14e1bfecb6');
```

### 二，退出登录后不收消息 

如下代码 返回true为成功 false为失败

```php
use wenshi\push\notice;

/**
*用户手机号
*用户填写的验证码
*/
/**
*@param uid   必填   用户id
*@param cid   必填   手机序列号
*/
PushNotice::closeCid('5','2925b1bcf4eb21feffda6d14e1bfecb6');
```


### 三，推送消息(一条或者多条)



如下代码 返回true为成功 失败返回失败原因

```php
use wenshi\push\notice;

*/
/**
*@param uid       必填     用户id,多个已逗号隔开
*@param title     必填     推送的标题
*@param content   必填     推送的内容
@param data       非必填   个人需要传递推送的数据 []
*/
PushNotice::Push('5,6,11','这个推送标题','推送的内容',['info'=>'你好','type'=>1]);
```


### 四，推送消息(整个平台)




如下代码 返回true为成功 失败返回失败原因

```php
use wenshi\push\notice;

*/
*@param title     必填     推送的标题
*@param content   必填     推送的内容
@param data       非必填   个人需要传递推送的数据 []
*/
PushNotice::pushToApp('这个推送标题','推送的内容',['info'=>'你好','status'=>1]);
```