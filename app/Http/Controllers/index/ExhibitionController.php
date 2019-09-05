<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Goods;
use App\admin\Admin_Cat;

class ExhibitionController extends Controller
{
    public function index()
    {
    	if (!request()->session()->has('user_id')) {
				return redirect('log')->with('tip', '账号错误！');die;
		}
    	$topid=Request()->cat_id;
    	//取所有的数据
    	$cat_ids=Admin_Cat::get()->toArray();
    	// dump($cat_ids);die;
    	// 调用递归
    	$cat_idn=createTree($cat_ids,$topid);
    	//取一列
    	$cat_idn=array_column($cat_idn,'cat_id');
    	// dump($cat_idn);die;
    	// 追加接到的cat_id
        array_unshift($cat_idn,$topid);
        //  in 批量查询
        $goods=Goods::whereIn('cat_id',$cat_idn)->get()->toArray();
    	// dump($good);
    	return 	view('index/exhibition/index',['goods'=>$goods]);
    }
}
