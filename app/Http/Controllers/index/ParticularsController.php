<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Goods;

class ParticularsController extends Controller
{
    public function index()
    {
    	$goods_id=Request()->goods_id;
    	// dd($goods_id);
    	$goods=Goods::find($goods_id)->toArray();
    	// dd($goods);
    	return view('index/particulars/particulars',['goods'=>$goods,'goods_id'=>$goods_id]);
    }

  //   public function addCar()
  //   {
  //   	// $emil = session('emil');
  //   	if (!request()->session()->has('user_id')) {
		// 		return redirect('log')->with('tip', '账号错误！');die;
		// }
  //   	// dump($emil);die;
 	// 	echo 11;die;
  //   	$goods_id=Request()->goods_id;
  //   	$buy_number=Request()->buy_number;
  //   	// echo $buy_number;die;
  //   	// if(!is_numeric($buy_number)){
  //   	// 	return redirect('particulars/'.$goods_id)->with('tip', '账号错误！');die;;
  //   	// }
  //   	$data=[];
  //   	$data=[
  //   		'user_id'=>$user_id,
  //   		'goods_id'=>$goods_id,
  //   		'buy_number'=>$buy_number,
  //   		'insert_time'=>time(),
  //   	];
  //   }
}
