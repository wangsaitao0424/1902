<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\index\Index_User;
use DB;
class LoginController extends Controller
{
    public function index()
    {
    	return view('index/login');
    }


    public function login_do()
    {
    	$PostData=Request()->except('_token');
    	$name=$PostData['emil'];
    	$pwd=$PostData['pwd'];
    	$res=Index_User::where(['emil'=>$name])->first();
    	if(!$res){
    		return redirect('log')->with('tip', '账号错误！');die;
    	}
    	if($res['pwd']!=$pwd){
    		return redirect('log')->with('tip', '密码错误！');die;
    	}else{
    		session(['emil'=>$res]);
    	}
    		return redirect('/')->with('tip', '登录成功！');die;
    }

    /**
     *微信登录 获取code
     *
     */
    public function wat_login()
    {
        $redirect_uri='http://www.laravel.com/index/codes';
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.urlencode($redirect_uri) .'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);
    }

    /**
     * 微信登录
     */
    public function codes()
    {
        $req=Request()->all();
//        dd($req);
        //获取access_token
        $result=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
        $res=json_decode($result,1);
//        dd($res);
        $user_info=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN');
        $user_info_wechat=json_decode($user_info,1);
//        dd($user_info_wechat['nickname']);
        //查表 index_wetchat openid是否存在
        $user=DB::connection('mysql_wx')->table('index_wetchat')->where(['openid'=>$user_info_wechat['openid']])->first();
//        dd($user);
        if(empty($user)){
            //不存在
            //开启事务
            DB::connection('mysql_wx')->beginTransaction();
            DB::connection('mysql')->beginTransaction();
            $user_id=DB::connection('mysql')->table('index_user')->insertGetId(
                [
                    'emil'=>$user_info_wechat['nickname'],
                    'pwd'=>'000000',
                ]
            );
//            dd($user_id);
            DB::connection('mysql_wx')->table('index_wetchat')->insert(
              [
                  'uid'=>$user_id,
                  'openid'=>$user_info_wechat['openid'],
              ]
            );
        }
        //存在 存session
        request()->session()->forget('uid');
        session('uid','$user->w_id');
        return redirect('/');
    }
}
