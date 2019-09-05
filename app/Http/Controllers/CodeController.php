<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function login()
    {
        return view('Wechat/code');
    }
    /**
     * 微信登陆
     */
    public function wechat_login()
    {
//        echo 11;die;
//        $redirect_uri = 'http://www.laravel.com/wechat/code';
        $redirect_uri = 'http://www.laravel.com/wechat/code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//        dd($url);
        header('Location:'.$url);
    }

    /**
     * 接收code 第二部
     */
    public function code(Request $request)
    {
//        echo 11;die;
        $req = $request->all();
//        dd($req);
        //获取access_token
        $result=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
        $re=json_decode($result,1);
        dd($re['openid']);
//        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
//        $re = json_decode($result,1);
        //拉取用户信息  snsapi_userinfo
        $user_info=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
//        dd($user_info);
        $wechat_user_info=json_decode($user_info,1);
//        dd($wechat_user_info);
//        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
//        dd($user_info);
//        $wechat_user_info = json_decode($user_info,1);
        dd($wechat_user_info);
    }

}
