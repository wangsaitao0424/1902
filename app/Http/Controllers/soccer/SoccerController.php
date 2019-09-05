<?php

namespace App\Http\Controllers\soccer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Soccer;
use Validator;
class SoccerController extends Controller
{
	/**
	 * 竞猜球队
	 * [create description]
	 * @return [type] [description]
	 */
    public function create()
    {
    	return view('soccer/create');
    }
    /**
     *添加
     * [save description]
     * @return [type] [description]
     */
    public function save()
    {
    	$PostData=Request()->except(['_token']);
    	//把时间格式转化成时间戳
    	$PostData['finish_time']=strtotime($PostData['finish_time']);
    	// dd($PostData);
    	// 判断两个球队名字
    	if($PostData['nba1']==$PostData['nba2']){
    		return redirect('soccer/create')->with('status', '请输入不同的国家名!');;
    	}
    	//验证
    	$validator = Validator::make($PostData, [
			'nba1' => 'required',
			'nba2' => 'required',
			'finish_time' => 'required',
		],[
			'nba1.required'=>'不可为空',
			'nba2.required'=>'不可为空',
			'finish_time.required'=>'不可为空',
		]);
		if ($validator->fails()) {
			return redirect('soccer/create')
			->withErrors($validator)
			->withInput();
		}
		//竞猜结果
		// $PostData['soccer_result']=0;
		$res=Soccer::create($PostData);
		if($res){
			return redirect('soccer/list');
		}
    }
    /**
     * 竞猜列表
     * [list description]
     * @return [type] [description]
     */
    public function list()
    {
    	// echo date("Y-m-d H:i:s",time());die;
    	$data=Soccer::get();
    	return view('soccer/list',['data'=>$data]);
    }
    /**
     * 竞猜中
     * [soccers description]
     * @param  [type] $soccer_id [description]
     * @return [type]            [description]
     */
    public function soccers($soccer_id)
    {
    	// echo $soccer_id;
    	$info=Soccer::where('soccer_id',$soccer_id)->first();
    	// dd($info);
    	return view('soccer/soccers',['info'=>$info]);
    }
    /**
     * ajax传来来的竞猜
     * [soccerss description]
     * @return [type] [description]
     */
    public function soccerss()
    {
    	request()->session()->pull('soccer_result');
    	request()->session()->pull('soccer_id');
    	$soccer_id=Request()->soccer_id;
    	$soccer_result=Request()->soccer_result;
    	 // echo $soccer_result;
    	session(['soccer_result' => $soccer_result]);
    	session(['soccer_id' => $soccer_id]);
    	return redirect('soccer/list');
    }
    /**
     * 竞猜已过时间或结果
     * [result description]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function result($soccer_id)
    {
    	$soccer_ids = request()->session()->get('soccer_id');
    	
    	if($soccer_ids==$soccer_id){
    		//session 中存的soccer_id和接受到的soccer_id一致 已竞猜 看结果
    		$soccer_results = request()->session()->get('soccer_result');
    		// echo 11;die;
    		$info=Soccer::where('soccer_id',$soccer_id)->first();
    		return view('soccer/results',['info'=>$info,'soccer_results'=>$soccer_results]);die;
    	}else{
    		//未竞猜 看结果
    		$info=Soccer::where('soccer_id',$soccer_id)->first();
	    	// dd($info);
	    	return view('soccer/result',['info'=>$info]);
    	}
    }
}
