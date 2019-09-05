<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Admin_Brand;
use Validator;
use Illuminate\Validation\Rule;
class BrandController extends Controller
{
	/**
	 * 添加
	 * [create description]
	 * @return [type] [description]
	 */
    public function create()
    {
    	return view('admin/brand/create');
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
        // dd($PostData);die;
        // 验证
        $validator = Validator::make($PostData, [
           'brand_name' => 'required|unique:admin_brand|max:30',
            'site_url' => 'required',
        ],[
            'brand_name.required' => '姓名必填',
            'brand_name.unique' => '姓名已有',
            'brand_name.max' => '字段最大姓名为30位',
            'site_url.required' => '网址必填',
        ]);
        if ($validator->fails()) {
            return redirect('brand/create')
            ->withErrors($validator)
            ->withInput();
        }
        //调用upload方法  
        if(request()->hasFile('brand_logo')){
            $PostData['brand_logo']=upload('brand_logo');
        }
        // $user=DB::table('admin_user')->insert($PostData);
        $info=Admin_Brand::create($PostData);
        if($info){
            return redirect('brand/list');
        }else{
            return redirect('brand/create');
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
        $brand_name=$query['brand_name']??'';
        if($brand_name){
            $where[]=['brand_name','like',"%$brand_name%"];
        }
        $site_url=$query['site_url']??'';
        if($site_url){
            $where[]=['site_url','=',$site_url];
        }
        //分页
        $pageSize=config('app.pageSize');
        $data=Admin_Brand::where($where)->paginate($pageSize);
        // dd($data);
        return view('/admin/brand/list',compact('data','query','brand_name','site_url'));
    }

    /**
     * 修改
     * [edit description]
     * @param  [type] $brand_id [description]
     * @return [type]           [description]
     */
    public function edit($brand_id)
    {
        // echo $brand_id;die;
        $data=Admin_Brand::find($brand_id);
        return view('admin/brand/edit',['data'=>$data]);
    }

    /**
     * 修改执行
     * [update description]
     * @param  [type] $brand_id [description]
     * @return [type]           [description]
     */
    public function update($brand_id)
    {
        // echo $user_id;die;
        $PostData=Request()->except('_token');
        // dd($PostData);
        $validator = Validator::make($PostData, [
           'brand_name' => [
                'required',
                Rule::unique('admin_brand')->ignore($brand_id,'brand_id'),
                'max:30',
            ],
            'site_url' => 'required',
        ],[
            'brand_name.required' => '姓名必填',
            'brand_name.unique' => '姓名已有',
            'brand_name.max' => '字段最大姓名为30位',
            'site_url.required' => '网址必填',
        ]);
        if ($validator->fails()) {
            return redirect('brand/edit')
            ->withErrors($validator)
            ->withInput();
        }
        //修改旧图片
        if(request()->hasFile('brand_logo')){
            $PostData['brand_logo']=upload('brand_logo');
            if($PostData['oldimg']){
            	$filename=storage_path('app/public').'/'.$PostData['oldimg'];
	            // dd($filename);
	            if(file_exists($filename)){
	                unlink($filename);
	            }
            }
        }
        unset($PostData['oldimg']);
        // $PostData['insert_time']=time();
        $res=Admin_Brand::where(['brand_id'=>$brand_id])->update($PostData);
        // if($res){
             
        // }
        return redirect('brand/list');
        
    }

    /**
     * 删除
     * [delete description]
     * @param  [type] $brand_id [description]
     * @return [type]           [description]
     */
    public function delete($brand_id)
    {
        // echo $brand_id;die;
        Admin_Brand::where(['brand_id'=>$brand_id])->delete();
        return redirect('brand/list');
		// destory()
    }
}
