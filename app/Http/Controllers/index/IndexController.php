<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Goods;
use App\admin\Admin_Cat;
class IndexController extends Controller
{
    public function index()
    {
    	// $name=request()->session()->get('emil');
    	// dump($name);
    	$count=Goods::count();
    	// dump($count);
    	$is_new=Goods::where(['is_new'=>0])->get();
    	$top=Admin_Cat::where(['parent_id'=>0])->get();
    	$next=Goods::where(['is_hat'=>0])->limit(8)->get();
    	$Boutique=Goods::where(['is_on_sale'=>0])->limit(3)->get();
    	// dump($next);
    	// dump($top);
    	// dump($is_new);
    	return view('index.index',compact('is_new','count','top','next','Boutique'));
    }

    public function list()
    {
    	
    }
}