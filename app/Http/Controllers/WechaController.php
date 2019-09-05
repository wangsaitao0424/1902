<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechaController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_user_list()
    {
    	 $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->get_access_token().'&next_openid=');
        $re = json_decode($result,1);
        $last_info = [];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
        return view('Wechat.userList',['info'=>$last_info]);
    }
    public function get_access_token()
    {
    	return $this->get_wechat_access_token();
    }
    public function get_wechat_access_token()
    {
    	$redis=new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	//加入缓存
    	$access_token_key='wechat_access_token';
    	if($redis->exists($access_token_key)){
    		//存在
            return $redis->get($access_token_key);
    	}else{
    		//不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx8f7b768865714a34&secret=02e61fe328d2bd4ee6ef48c397c51589');
            $re = json_decode($result,1);
            // dd($re);
            $redis->set($access_token_key,$re['access_token'],$re['expires_in']);  //加入缓存
            return $re['access_token'];
    	}
    }
}

