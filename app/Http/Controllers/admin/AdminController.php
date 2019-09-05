<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\admin\Admin_User;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    public function index()
    {
    	return view('/admin/index');
    	// echo 11;
    }
    
    public function create()
    {

    	return view('/admin/admin/create');
    	// echo 11;
    }


    public function list()
    {
        $query=Request()->input();
        // dd($query);
        $where=[];
        $user_name=$query['user_name']??'';
        if($user_name){
            $where[]=['user_name','like',"%$user_name%"];
        }
        $user_grade=$query['user_grade']??'';
        if($user_grade){
            $where[]=['user_grade','=',$user_grade];
        }
        $pageSize=config('app.pageSize');
        $data=DB::table('admin_user')->where($where)->paginate($pageSize);
        // dd($data);
        return view('/admin/admin/list',compact('data','query','user_name','user_grade'));
    }

     public function save()
    {
        $PostData=Request()->except('_token');
        // dd($PostData);die;
        $validator = Validator::make($PostData, [
           'user_name' => 'required|unique:admin_user|max:30',
            'user_pwd' => 'required',
            'user_sex' => 'required',
            'user_grade'=>'required',
        ],[
            'user_name.required' => '姓名必填',
            'user_name.unique' => '姓名已有',
            'user_name.max' => '字段最大姓名为30位',
            'user_pwd.required' => '年龄必填',
            'user_sex.required' => '年龄必填',
            'user_grade.required' => '等级必填',
        ]);
        if ($validator->fails()) {
            return redirect('store/create')
            ->withErrors($validator)
            ->withInput();
        }
        if(request()->hasFile('files')){
            $PostData['files']=upload('files');
        }
        $PostData['insert_time']=time();
        $user=DB::table('admin_user')->insert($PostData);
        if($user){
            return redirect('store/list');
        }else{
            return redirect('store/create');
        }
        // echo json_encode(['ret'=>0,'msg'=>'提交失败']);
        // $pageSize=config('app.pageSize');
        // DB::connection()->enableQueryLog();
        // $list= DB::table('student')->where($where)->paginate($pageSize);
    }

    

    public function edit($user_id)
    {
        // echo $user_id;die;
        $data=Admin_User::find($user_id);
        return view('admin/admin/edit',['data'=>$data]);
    }
    public function update($user_id)
    {
        // echo $user_id;die;
        $PostData=Request()->except('_token');
        // dd($PostData);
        $validator = Validator::make($PostData, [
           'user_name' => [
                'required',
                Rule::unique('admin_user')->ignore($user_id,'user_id'),
                'max:30',
            ],
            'user_pwd' => 'required',
            'user_sex' => 'required',
            'user_grade'=>'required',
        ],[
            'student_name.required' => '姓名必填',
            'student_name.unique' => '姓名已有',
            'student_name.max' => '字段最大姓名为30位',
            'user_pwd.required' => '年龄必填',
            'user_sex.required' => '年龄必填',
            'user_grade.required' => '等级必填',
        ]);
        if ($validator->fails()) {
            return redirect('store/edit')
            ->withErrors($validator)
            ->withInput();
        }
        if(request()->hasFile('files')){
            $PostData['files']=upload('files');
            if($PostData['oldimg']){
                $filename=storage_path('app/public').'/'.$PostData['oldimg'];
                // dd($filename);
                if(file_exists($filename)){
                    unlink($filename);
                }
            }
        }
        unset($PostData['oldimg']);
        $PostData['insert_time']=time();
        $res=Admin_User::where(['user_id'=>$user_id])->update($PostData);
        // if($res){
             
        // }
        return redirect('store/list');
        
    }

    public function delete($user_id)
    {
        // echo $user_id;die;
        Admin_User::where(['user_id'=>$user_id])->delete();
        return redirect('store/list');
// destory()
    }
}
