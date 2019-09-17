<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Storage;
class AgentController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    /**
     * 生成二维码视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function agent_list()
    {
        $list=DB::connection('mysql_wx')->table('index_wetchat')->get();
//        dd($list);
        return view('Agent.agentlist',['list'=>$list]);
    }

    public function agent_qu()
    {
//        $uid=Request()->all();
//        dd($uid);
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'expire_seconds'=>604800,
            'action_name'=>'QR_STR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_str'=>Request()->all()['uid']
                ]
            ]
        ];
//        dd($data);
        $re=$this->tools->curl_post($url,json_encode($data));
//        dd($re);
        $result=json_decode($re,1);
//        dd($result);
        $qrcode_info=file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($result['ticket']));
//        dd($qrcode_info);
        $path='/wechat/qrcode/'.time().rand(1000,9999).'.jpg';
        Storage::put($path, $qrcode_info);
//        dd($path);
        DB::connection('mysql_wx')->table('index_wetchat')->where(['w_id'=>Request()->all()['uid']])->update(['agent_path'=>$path]);
        return redirect('wechat/agent_list');
    }

}
