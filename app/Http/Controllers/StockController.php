<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
class StockController extends Controller
{
    public function create()
    {
    	// echo "kongbai";
    	return view('stock/create');
    }
    public function save()
    {
        $PostData=Request()->except('_token');
//    	dd($PostData);
        if(request()->hasFile('goods_img')){
//            echo 111;die;
            $PostData['goods_img']=upload('goods_img');
        }
        $PostData['insert_time']=time();
        // dd($PostData);
        $status=Stock::create($PostData);
        if($status){
            return redirect('stock/list');
        }
    }
    public function list()
    {
    	// echo 11;
    	$list=Stock::get();
    	return view('stock/list',['list'=>$list]);
    }
    public function edit($stock_id)
    {
    	// echo $stock_id;
    	$stock=Stock::find($stock_id);
    	return view('stock/edit',['stock'=>$stock]);
    }
    public function update($stock_id)
    {
    	$data=Request()->except('_token');
    	if($data['stock_nums']>$data['stock_num']){
    		return redirect('stock/edit/'.$stock_id)->with('status', '当前库存量不足!');die;
    	}
    	// dd($data);
    	$PostData=$data['stock_num']-$data['stock_nums'];
    	// dd($PostData);
    	Stock::where(['stock_id'=>$stock_id])->update(['stock_num'=>$PostData]);
    	return redirect('stock/list');
    }
    // $stock=Stock::find($stock_id);
    	// dd($stock);
}
