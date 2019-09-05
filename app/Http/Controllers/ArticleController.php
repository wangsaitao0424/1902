<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\admin\Admin_User;
use Validator;
use App\Article;
use Illuminate\Support\Facades\Redis;
use DB;
class ArticleController extends Controller
{
	/**
	 * 登陆页面
	 * [login description]
	 * @return [type] [description]
	 */
	public function login()
	{
		return view('article_login');
	}
	/**
	 * 登陆执行页
	 * [login_do description]
	 * @return [type] [description]
	 */
	public function login_do()
	{
        $postData=Request()->except('_token');
    	$res=Admin_User::where(['user_name'=>$postData['user_name']])->first();
    	// dd($res);
    	if(!$res){
    		return redirect('article/login')->with('tip', '账号错误！');die;
    	}
    	if($res['user_pwd']!=$postData['user_pwd']){
    		return redirect('article/login')->with('tip', '密码错误！');die;
    	}else{
    		session(['user'=>$res]);
    	}
    	
    	return redirect('article/create');
	}
	/**
	 * 添加页
	 * [create description]
	 * @return [type] [description]
	 */
    public function create()
    {
    	if (!request()->session()->has('user')) {
    		return redirect('article/login')->with('请登录');die;
    	}
    	return view('article_create');
    }
    /**
     * 添加执行页
     * [save description]
     * @return [type] [description]
     */
    public function save()
    {
        $PostData=Request()->except('_token');
    	// dd($PostData);
    	$validator = Validator::make($PostData, [
           'title' => 'required|unique:article|max:30',
            'author' => 'required',
            'content' => 'required',
        ],[
            'title.required' => '标题必填',
            'title.unique' => '标题已有',
            'title.max' => '字段最大标题为30位',
            'author.required' => '作者必填',
            'content.required' => '内容必选',
        ]);
        if ($validator->fails()) {
            return redirect('article/create')
            ->withErrors($validator)
            ->withInput();
        }
        $PostData['insert_time']=time();
        // dd($PostData);
        $res=Article::create($PostData);
        if($res){
        	return redirect('article/lie');
        }
    }
    /**
     * 列表
     * [list description]
     * @return [type] [description]
     */
    public function list()
    {
    	if (!request()->session()->has('user')) {
    		return redirect('article/login')->with('请登录');die;
    	}
    	$data=Article::get();
    	$rela = DB::table('like')->where(['user_id' => session('user')['user_id']])->get();
        $rela = json_decode(json_encode($rela),true);
    	// $data=json_decode(json_encode($data),true);
    	// dd($data);
        $dianzan = array_column($rela, 'article_id');
    	
    	foreach ($data as $key => $value) {
    		 $v = Redis::get('name' . $value['article_id']);
            $data[$key]['name'] = empty($v) ? 0 : $v;
            $data[$key]['flag'] = in_array($value['article_id'], $dianzan) ? '取消点赞' : '点赞';
    	}
    	return view('article_list',['data'=>$data]);
    }
    /**
     * 内容
     * [content description]
     * @param  [type] $article_id [description]
     * @return [type]             [description]
     */
    public function content($article_id)
    {
    	$data=Article::where('article_id',$article_id)->first('content');
    	// dd($data);
    	return view('article_content',['data'=>$data]);
    }
    /**
     * [zan description]
     * @return [type] [description]
     */
    public function zan()
    {
    	$article_id=Request()->article_id;
    	$flag=Request()->flag;
    	// echo $flag;die;
    	if($flag=='点赞'){
			Redis::incr('name'.$article_id);
			 // 新增点赞关系
            DB::table('like')->insert(['user_id' => session('user')['user_id'], 'article_id' => $article_id]);
    	}else{
			Redis::decr('name'.$article_id);
             // 删除点赞关系
            DB::table('like')->where(['user_id' => session('user')['user_id'], 'article_id' => $article_id])->delete();	
    	}
    	
    	echo Redis::get('name'.$article_id);
    }
}
