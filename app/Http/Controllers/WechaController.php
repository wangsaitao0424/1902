<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Tools\Tools;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
class WechaController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }
    /**
     * 调用频次清0
     */
    public function  clear_api()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->get_wechat_access_token();
        $data = ['appid'=>env('APPID')];
        $this->curl_post($url,json_encode($data));
    }

    public function download_source(Request $request)
    {
        $req = $request->all();
//        dd($req);
        $source_info = DB::connection('mysql_wx')->table('wechat_source')->where(['id'=>$req['id']])->first();
//        dd($source_info);
        $source_arr = [1=>'image',2=>'voice',3=>'video',4=>'thumb'];
        $source_type = $source_arr[$source_info->type]; //image,voice,video,thumb
//        dd($source_type);
        //素材列表
        //$media_id = 'dcgUiQ4LgcdYRovlZqP88RB3GUc9kszTy771IOSadSM'; //音频
        //$media_id = 'dcgUiQ4LgcdYRovlZqP88dUuf1H6G4Z84rdYXuCmj6s'; //视频
        $media_id = $source_info->media_id;
//        dd($media_id);
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->get_wechat_access_token();
        $re = $this->curl_post($url,json_encode(['media_id'=>$media_id]));
//        dd($re);
        if($source_type != 'video'){
            Storage::put('1902/'.$source_type.'/'.$source_info->file_name, $re);
            DB::connection('mysql_wx')->table('wechat_source')->where(['id'=>$req['id']])->update([
                'path'=>'/storage/1902/'.$source_type.'/'.$source_info->file_name,
            ]);
            dd('ok');
        }
        $result = json_decode($re,1);
        dd($result);
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
//        dd($context);
        //$url请求的地址，例如：
        $read = file_get_contents($result['down_url'],false, $context);
        Storage::put('1902/video/'.$source_info['file_name'], $read);
        DB::connection('mysql_wx')->table('wechat_source')->where(['id'=>$req['id']])->update([
            'path'=>'/storage/1902/'.$source_type.'/'.$source_info->file_name,
        ]);
        dd('ok');
        //Storage::put('file.mp3', $re);
    }
    /**
     *获取微信素材管理页面
     */
    public function wechat_source(Request $request,Client $client)
    {
        $req = $request->all();
//      dd($req);
        empty($req['source_type'])?$source_type = 'image':$source_type=$req['source_type'];
        if(!in_array($source_type,['image','voice','video','thumb'])){
            dd('类型错误');
        }
        if(!empty($req['page']) && $req['page'] <= 0 ){
            dd('页码错误');
        }
        empty($req['page'])?$page = 1:$page=$req['page'];
//        if($req['page'] <= 0 ){
//            dd('页码错误');
//        }
       if($page <= 0 ){
           dd('页码错误');
        }
        $pre_page = $page - 1;
        $pre_page <= 0 && $pre_page = 1;
        $next_page = $page + 1;
        //获取素材列表
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->get_wechat_access_token();
        $data = [
            'type' =>$source_type,
            'offset' => $page == 1 ? 0 : ($page - 1) * 20,
            'count' => 20
        ];
        //guzzle使用方法
//        $r = $client->request('POST', $url, [
//        'body' => json_encode($data)
//    ]);
//        $re = $r->getBody();
        $re = $this->tools->redis->get('source_info');
//        $re = $this->curl_post($url,json_encode($data));
        $this->tools->redis->set('source_info',$re);
        $info = json_decode($re,1);
//        dd($info);
        $media_id_list = [];
        $source_arr = ['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
//        dd($source_arr);
        foreach($info['item'] as $v){
            //同步数据库
            $media_info = DB::connection('mysql_wx')->table('wechat_source')->where(['media_id'=>$v['media_id']])->select(['id'])->first();
            if(empty($media_info)){
                DB::connection('mysql_wx')->table('wechat_source')->insert([
                    'media_id'=>$v['media_id'],
                    'type' => $source_arr[$source_type],
                    'add_time'=>$v['update_time'],
                    'file_name'=>$v['name'],
                ]);
            }
            $media_id_list[] = $v['media_id'];
        }
        $source_info = DB::connection('mysql_wx')->table('wechat_source')->whereIn('media_id',$media_id_list)->where(['type'=>$source_arr[$source_type]])->get();
//        dd($source_info);
        foreach($source_info as $k=>$v){
            $is_download = 0;  //是否需要下载文件 0 否 1 是
            if(empty($v->path)){
                $is_download = 1;
            }elseif (!empty($v->path) && !file_exists('.'.$v->path)){
                $is_download = 1;
            }
            $source_info[$k]->is_download = $is_download;
        }
//        dd($source_info);
        return view('Wechat.source',['info'=>$source_info,'pre_page'=>$pre_page,'next_page'=>$next_page,'source_type'=>$source_type]);
    }
    /**
     *  上传
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload()
    {
        return view('Wechat.upload');
    }

    /**
     * 上传
     * @param Request $request
     * @param Client $client
     */
    public function do_upload(Request $request ,Client $client)
    {
        $succ=$request->all();
        $type_succ=$succ['type'];
//        dd($type_succ);
        $source_type = '';
        switch ($type_succ){
            case 1:$source_type='image';break;
            case 2:$source_type='voice';break;
            case 3:$source_type='video';break;
            case 4:$source_type='thumb';break;
            default;
        }
//        dd($type_succ);
        $name = 'file_name';
//        dd($name);
        if(!empty($request->hasFile($name)) && request()->file($name)->isValid()){
//            $path = request()->file($name)->store($type_succ);
            $ext = $request->file($name)->getClientOriginalExtension();
//            dd($ext);
            $size = $request->file($name)->getClientSize() / 1024 / 1024;
//            dd($path);
//            dd('/storage/'.$path);
            if($source_type == 'image'){
                if(!in_array($ext,['jpg','png','jpeg','gif'])){
                    dd('图片类型不支持');
                }
                if($size > 2){
                    dd('guo大');
                }
            }else if($source_type == 'voice'){
                if(!in_array($ext,['AMR','MP3','mp3','amr'])){
                    dd('语音格式不正确');
                }
                if($size>2){
                    dd('guo大');
                }
            }else if($source_type=='video'){
                if(!in_array($ext,['MP4','mp4'])){
                    dd('视频格式不正确');
                }
                if($size>10){
                    dd('guo大');
                }
            }else if($source_type=='thumb'){
                if(!in_array($ext,['JPG'])){
                    dd('缩略图格式不正确');
                }
                if($size>0.0625){
                    dd('guo大');
                }
            }
//            echo 11;die;
            $file_name = time().rand(1000,9999).'.'.$ext;
//            dd($file_name);
//            $path = request()->file($name)->storeAs('1902\voice',$file_name);
            $path = request()->file($name)->storeAs('1902/'.$source_type,$file_name);
            $storage_path = '/storage/'.$path;
            $path = realpath('./storage/'.$path);
//            dd($path);
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->get_wechat_access_token().'&type='.$source_type;
//            dd($url);
            //$result = $this->curl_upload($url,$path);
            if($source_type == 'video'){
                $title = '标题'; //视频标题
                $desc = '描述'; //视频描述
                $result = $this->guzzle_upload($url,$path,$client,1,$title,$desc);
            }else{
                $result = $this->guzzle_upload($url,$path,$client);
            }
            $re = json_decode($result,1);
//             dd($re);
            //插入数据库
            DB::connection('mysql_wx')->table('wechat_source')->insert([
                'media_id'=>$re['media_id'],
                'type' => $type_succ,
                'path' => $storage_path,
                'add_time'=>time()
            ]);
            echo 'ok';
        }
    }
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

    /**
     * @return bool|string
     */
    public function get_access_token()
    {
    	return $this->get_wechat_access_token();
    }

    /**
     * access_token
     * @return bool|string
     */
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

        /**
         * @param $url
         * @param $data
         */
        public function curl_post($url,$data)
        {
//            echo 11;die;
            $curl = curl_init($url);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_POST,true);  //发送post
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
            $data = curl_exec($curl);
            $errno = curl_errno($curl);  //错误码
            $err_msg = curl_error($curl); //错误信息
            curl_close($curl);
            return $data;
        }
    /**
     * curl上传微信素材
     * @param $url
     * @param $path
     * @return bool|string
     */
    public function curl_upload($url,$path)
    {
        $curl = curl_init($url);
//        dd($curl);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        $form_data = [
            'media' => new \CURLFile($path)
        ];
//        dd($form_data);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        dd($data);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
//        dd($data);
        return $data;
    }

    public function guzzle_upload($url,$path,$client,$is_video=0,$title='',$desc=''){
        $multipart =  [
            [
                'name'     => 'media',
                'contents' => fopen($path, 'r')
            ]
        ];
        if($is_video == 1){
            $multipart[] = [
                'name'=>'description',
                'contents' => json_encode(['title'=>$title,'introduction'=>$desc],JSON_UNESCAPED_UNICODE)
            ];
        }
        $result = $client->request('POST',$url,[
            'multipart' => $multipart
        ]);
        return $result->getBody();
    }
}

