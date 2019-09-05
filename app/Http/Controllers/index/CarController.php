<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\index\Index_Car;

class CarController extends Controller
{
    public function addCar()
    {
    	if (request()->session()->has('emil')) {
			$emil=request()->session()->get('emil');
			// dd($emil['user_id']);
			$user_id=$emil['user_id'];
	 		// echo 11;die;
	    	// $goods_id=Request()->goods_id;
	    	$buy_number=Request()->buy_number;
	    	$goods_id=Request()->goods_id;
	    	// dd($buy_number);
	    	 $where=[
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
	        ];
	        //查询购物车有无此商品的信息
	    	$res=Index_Car::where($where)->first();
	    	$data=[];
			if($res){
				$data=[
		    		'buy_number'=>$res['buy_number']+$buy_number,
		    		'insert_time'=>time(),
		    	];
		    	$car=Index_Car::where(['car_id'=>$res['car_id']])->update($data);
		    	if($car){
	                return ['code'=>'00000','msg'=>'成功加入购物车'];
	            }
			}else{
		    	$data=[
		    		'user_id'=>$user_id,
		    		'goods_id'=>$goods_id,
		    		'buy_number'=>$buy_number,
		    		'insert_time'=>time(),
		    	];
		    	$car=Index_Car::create($data);
		    	if($car){
	                return ['code'=>'00000','msg'=>'成功加入购物车'];
	            }
			}
		}else{
			return ['code'=>'00001','msg'=>'请先登录'];
		}
		
    }

    public function index()
    {
    	$emil=request()->session()->get('emil');
		// dd($emil['user_id']);
		$user_id=$emil['user_id'];
		if(!$user_id){
			return redirect('log')->with('tip',"未登录，请登录");die;
		}
    	$car=Index_Car::join('admin_goods', 'index_car.goods_id', '=', 'admin_goods.goods_id')->where(['user_id'=>$user_id])->get();
    	// dd($car);
    	$count=Index_Car::where(['user_id'=>$user_id])->count();
    	return view('index/car/index',compact('car','count'));
    }
     /**
     * 计算金额
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function getMoney()
    { 	
        $goods_ids=Request()->goods_id;
        // dump($goods_ids);die;
        // 判断为空
        if(!$goods_ids){
            return number_format(0,'2','.','');
        }
        $emil=request()->session()->get('emil');
		// dd($emil['user_id']);
		$user_id=$emil['user_id'];
        // dump($user_id);die;
        //登陆过
        if(is_array($goods_ids)){
            $goods_ids=implode(',',$goods_ids);
        }
        // dump($goods_ids);die;
        // DB::connection()->enableQueryLog();
        $price1=Index_Car::join('admin_goods', 'index_car.goods_id', '=', 'admin_goods.goods_id')
        ->where(['index_car.goods_id'=>$goods_ids,'index_car.user_id'=>$user_id])
        ->select('index_car.buy_number', 'admin_goods.shop_price')
        ->get();
   		// $price1->count();
         //$logs = DB::getQueryLog();
        //dd($logs);
        // dd($price1);
        // if(!is_array($price1)){
        // 	$price=$price1['buy_number']*$price1['shop_price'];
        // }else{
			foreach ($price1 as $key => $v) 
			{
	        	// dd($key);
	        	$price="";
	        	$price.=$v['buy_number']*$v['shop_price'];
	        	// echo $price;die;
	        	// $price=$price+$price;
	        	return $price;
	        }
        // }
        dd($price);
        echo $price;
    }
}
