<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Admin_Cat;
use Validator;
use Illuminate\Validation\Rule;
class CatController extends Controller
{
    /**
	 * 添加
	 * [create description]
	 * @return [type] [description]
	 */
    public function create()
    {
    	$cat=Admin_Cat::get();
        $cat=createTree($cat);
    	// dd($cat);
    	return view('admin/cat/create',['cat'=>$cat]);
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
           'cat_name' => 'required|unique:admin_cat|max:30',
            'sort_order' => 'required|numeric',
        ],[
            'brand_name.required' => '分类名称必填',
            'brand_name.unique' => '分类名称已有',
            'brand_name.max' => '字段最大姓名为30位',
            'site_url.required' => '排序必填',
            'site_url.numeric' => '排序必选为数字',
        ]);
        if ($validator->fails()) {
            return redirect('cat/create')
            ->withErrors($validator)
            ->withInput();
        }
        //调用upload方法  
        // if(request()->hasFile('brand_logo')){
        //     $PostData['brand_logo']=upload('brand_logo');
        // }
        // $user=DB::table('admin_user')->insert($PostData);
        $info=Admin_Cat::create($PostData);
        if($info){
            return redirect('cat/list');
        }else{
            return redirect('cat/create');
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
        $cat_name=$query['cat_name']??'';
        if($cat_name){
            $where[]=['cat_name','like',"%$cat_name%"];
        }
        // $site_url=$query['site_url']??'';
        // if($site_url){
        //     $where[]=['site_url','=',$site_url];
        // }
        //分页
        // $pageSize=config('app.pageSize');
        $data=Admin_Cat::where($where)->get();
        // dump($data);
        $data=createTree($data);
        // dd($datas);
        return view('/admin/cat/list',compact('data','query','cat_name'));
    }

    /**
     * 修改
     * [edit description]
     * @param  [type] $brand_id [description]
     * @return [type]           [description]
     */
    public function edit($cat_id,$parent_id)
    {
        // echo $brand_id;die;
        $cat=Admin_Cat::get();
        $cat=createTree($cat);
        $data=Admin_Cat::find($cat_id);
        // $parent_id=$data['parent_id'];
        // $parent_ids=Admin_Cat::where(['parent_id'=>$parent_id])->first();
        // dd($parent_ids);
        return view('admin/cat/edit',compact('data','cat'));
    }

     public function update($cat_id,$parent_id)
    {
        //接收字段的值 把_token排除掉
        $PostData=Request()->except('_token');
        // dd($PostData);die;
        // 验证
        $validator = Validator::make($PostData, [
            'cat_name' => [
                'required',
                Rule::unique('admin_cat')->ignore($cat_id,'cat_id'),
                'max:30',
            ],
            'sort_order' => 'required|numeric',
        ],[
            'brand_name.required' => '分类名称必填',
            'brand_name.unique' => '分类名称已有',
            'brand_name.max' => '字段最大姓名为30位',
            'site_url.required' => '排序必填',
            'site_url.numeric' => '排序必选为数字',
        ]);
        if ($validator->fails()) {
            return redirect('cat/edit'.$cat_id)
            ->withErrors($validator)
            ->withInput();
        }
        //调用upload方法  
        // if(request()->hasFile('brand_logo')){
        //     $PostData['brand_logo']=upload('brand_logo');
        // }
        // $user=DB::table('admin_user')->insert($PostData);
        // $PostData['insert_time']=time();
        $res=Admin_Cat::where(['cat_id'=>$cat_id])->update($PostData);
        return redirect('cat/list');
    }

    public function delete($cat_id)
    {
        // dd($cat_id,$parent_id);
        $count=Admin_Cat::where(['parent_id'=>$cat_id])->count();
        // dd($count);
        if($count==0){
            Admin_Cat::where(['cat_id'=>$cat_id])->delete();
            // echo "删除成功";
            $data = [
            'status' => 0,
            'msg' => '删除成功'
          ];
        }else{
            $data = [
            'status' => 1,
            'msg' => '该分类下有分类'
          ];
        }
        return $data;
        
    }

}
