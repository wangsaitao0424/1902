<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Admin_Brand;
use App\admin\Admin_Cat;
use App\admin\Goods;
use Illuminate\Validation\Rule;
use Validator;
class GoodController extends Controller
{
    public function create()
    {
    	$brand=Admin_Brand::get();
    	$cat=Admin_Cat::get();
        $cat=createTree($cat);
    	return view('admin/good/create',['cat'=>$cat,'brand'=>$brand]);
    }


    /**
     * 添加执行
     * [save description]
     * @return [type] [description]
     */
    public function save()
    {
        //接收字段的值 把_token排除掉
        $PostData=Request()->except('_token');
//         dd($PostData);
        // 验证
        $validator = Validator::make($PostData, [
           'goods_name' => 'required|unique:admin_goods|max:30',
            'shop_price' => 'required|numeric',
            'goods_number' => 'required|numeric',
        ],[
            'goods_name.required' => '名称必填',
            'goods_name.unique' => '名称已有',
            'goods_name.max' => '字段最大姓名为30位',
            'shop_price.required' => '必填',
            'shop_price.numeric' => '必选为数字',
            'goods_number.required' => '必填',
            'goods_number.numeric' => '必选为数字',
        ]);
        if ($validator->fails()) {
            return redirect('good/create')
            ->withErrors($validator)
            ->withInput();
        }
        //调用upload方法  
        if(request()->hasFile('goods_img')){
//            echo 11;die;
            $PostData['goods_img']=upload('goods_img');
        }
        $PostData['insert_time']=date("Y-m-d H:i:s",time());
        if(!$PostData['goods_sn']){
            $PostData['goods_sn']=$this->goodssn();
        }
        // dd($PostData);
        //调用upload方法  
        // if(request()->hasFile('brand_logo')){
        //     $PostData['brand_logo']=upload('brand_logo');
        // }
        // $user=DB::table('admin_user')->insert($PostData);
        $info=Goods::create($PostData);
        if($info){
            return redirect('good/list');
        }else{
            return redirect('good/create');
        }
        // echo json_encode(['ret'=>0,'msg'=>'提交失败']);
        // $pageSize=config('app.pageSize');
        // DB::connection()->enableQueryLog();
        // $list= DB::table('student')->where($where)->paginate($pageSize);
    }

   
    /**
     * 列表
     * [list description]
     * @return [type] [description]
     */
    public function list()
    {
    	//搜索
    	 $query=Request()->input();
        // dd($query);
        $where=[];
        $goods_name=$query['goods_name']??'';
//        dump($goods_name);
        if($goods_name){
            $where[]=['goods_name','like',"%$goods_name%"];
        }
        // $site_url=$query['site_url']??'';
        // if($site_url){
        //     $where[]=['site_url','=',$site_url];
        // }
        //分页
        $pageSize=config('app.pageSize');
      	$data=Goods::join('admin_cat', 'admin_goods.cat_id', '=', 'admin_cat.cat_id')->join('admin_brand', 'admin_goods.brand_id', '=', 'admin_brand.brand_id')->where($where)->paginate($pageSize);
        // dd($data);
        return view('/admin/good/list',compact('data','goods_name'));
    }

     /**
     * 修改
     * [edit description]
     * @param  [type] $brand_id [description]
     * @return [type]           [description]
     */
    public function edit($goods_id)
    {
    	// echo $goods_id;die;
    	$brand=Admin_Brand::get();
    	$cat=Admin_Cat::get();
        $cat=createTree($cat);
        // echo $brand_id;die;
        $data=Goods::join('admin_cat', 'admin_goods.cat_id', '=', 'admin_cat.cat_id')->join('admin_brand', 'admin_goods.brand_id', '=', 'admin_brand.brand_id')->find($goods_id);
        return view('admin/good/edit',compact('data','brand','cat'));
    }

     public function update($goods_id)
    {
        //接收字段的值 把_token排除掉
        $PostData=Request()->except('_token');
        // dd($PostData);
        // 验证
        $validator = Validator::make($PostData, [
           'goods_name' => [
                'required',
                Rule::unique('admin_goods')->ignore($goods_id,'goods_id'),
                'max:30',
            ],
            'shop_price' => 'required|numeric',
            'goods_number' => 'required|numeric',
        ],[
            'goods_name.required' => '名称必填',
            'goods_name.unique' => '名称已有',
            'goods_name.max' => '字段最大姓名为30位',
            'shop_price.required' => '必填',
            'shop_price.numeric' => '必选为数字',
            'goods_number.required' => '必填',
            'goods_number.numeric' => '必选为数字',
        ]);
        if ($validator->fails()) {
            return redirect('good/create')
            ->withErrors($validator)
            ->withInput();
        }
               //修改旧图片
        if(request()->hasFile('goods_img')){
            $PostData['goods_img']=upload('goods_img');
            if($PostData['oldimg']){
            	$filename=storage_path('app/public').'/'.$PostData['oldimg'];
	            // dd($filename);
	            if(file_exists($filename)){
	                unlink($filename);
	            }
            }
        }
        unset($PostData['oldimg']);
        $PostData['insert_time']=date("Y-m-d H:i:s",time());
        // $PostData['goods_sn']=$this->goodssn();
        // dd($PostData);
        //调用upload方法  
        // if(request()->hasFile('brand_logo')){
        //     $PostData['brand_logo']=upload('brand_logo');
        // }
        // $user=DB::table('admin_user')->insert($PostData);
        $info=Goods::where(['goods_id'=>$goods_id])->update($PostData);
        return redirect('good/list');
        
    }

    /**
     * 删除
     * [delete description]
     * @param  [type] $brand_id [description]
     * @return [type]           [description]
     */
    public function delete($goods_id)
    {
        // echo $brand_id;die;
        Goods::where(['goods_id'=>$goods_id])->delete();
        return redirect('good/list');
		// destory()
    }

    /**
     * 随机生成商品货号
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function goodssn()
    {
        return "1902a".date("YmdHis").rand("1000","9999");
    }


}
