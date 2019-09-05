<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentPost;
use Validator;
use DB;
use Cookie;
use Illuminate\Support\Facades\Redis;
class UsersController extends Controller
{
    public function index($id=1)
    {
        //memcache
        $memcache=New \memcache;
        $memcache->connect('127.0.0.1','11211');
        $memcache->set('shuzi',1,0,6000);
        echo $memcache->get('shuzi');
        // echo $memcache->increment('shuzi');
        // echo $memcache->decrement('shuzi');
        // $memcache->set('jian','zhi',0,60);
        // $data=$memcache->get('UsersController_index_students');
        // if(empty($data)){
        //     $data=json_encode(DB::table('students')->get());
        //     // dd($data);
        //     $memcache->set('UsersController_index_students',$data,0,30);
        // }
        // print_r($data);
        // echo $memcache->get('jian');
    	// echo "低风险见附件".$id;
    }

    public function add()
    {
        //redis
        Redis::set('name','wanghuawei');
        echo Redis::get('name');die;
        // $use = ['uid'=>1,'name'=>'qq'];
        //存session
        // session(['user'=>$use]);
        // request()->session()->put('user',$use);
        // request()->session()->save();
        //取session
        // $user = session('user');
        // $user = request()->session()->get('user');
        //删除session
        // session(['user'=>null]);
        // $user = session('user');
        
       // $user=request()->session()->pull('user');
       // $user=request()->session()->forget('user');
        // $user=request()->session()->flush();
        // $user = request()->session()->get('user');
        // dd($user);
        // Cookie::queue(Cookie::make('name', 'value', 24*6));
        Cookie::queue('name', 'value', 24*6);
    	return view('add');
    	// echo "11";
    }

    public function add_do(StoreStudentPost $request)
    {
    	//对指定方法以外的方法生效 except
    	//只对指定方法生效 only
        // $request->validate([
        //     'student_name' => 'required|unique:student|max:30',
        //     'student_age' => 'required|numeric',
        //     'student_sex' => 'required',
        // ],[
        //     'student_name.required' => '姓名必填',
        //     'student_name.unique' => '姓名已有',
        //     'student_name.max' => '字段最大姓名为30位',
        //     'student_age.numeric' => '年龄必选为数值',
        //     'student_age.required' => '年龄必填',
        //     'student_sex.required' => '性别必选',
        // ]);
        $postData=Request()->except('_token');
        $validator = Validator::make($postData, [
           'student_name' => 'required|unique:student|max:30',
            'student_age' => 'required|numeric',
            'student_sex' => 'required',
        ],[
            'student_name.required' => '姓名必填',
            'student_name.unique' => '姓名已有',
            'student_name.max' => '字段最大姓名为30位',
            'student_age.numeric' => '年龄必选为数值',
            'student_age.required' => '年龄必填',
            'student_sex.required' => '性别必选',
        ]);
        if ($validator->fails()) {
            return redirect('student/add')
            ->withErrors($validator)
            ->withInput();
        }
        if(request()->hasFile('file')){
            $postData['file']=upload('file');
        }
        
    	$info = DB::table('student')->insertGetId($postData);

    	// dd($postData);
    	// dd($info);
    	if($info){
    		return redirect('student/lists');
    	}
    }

    public function lists()
    {
        $query=Request()->input();
        // dd($$query['student_name']);
        $student_name=$query['student_name']??'';
        // dd($student_name);
        $where=[];
        if($student_name){
            $where[]=['student_name','like',"%$student_name%"];
        }
        $student_age=$query['student_age']??'';
        if($student_age){
            $where[]=['student_age','=',$student_age];
        }
        $pageSize=config('app.pageSize');
        // DB::connection()->enableQueryLog();
        $list= DB::table('student')->where($where)->paginate($pageSize);
        // $logs = DB::getQueryLog();
        // dd($logs);
        return view('lists',compact('list','query','student_name','student_age'));
    }

    
}
