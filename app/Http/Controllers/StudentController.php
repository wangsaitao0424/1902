<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Students;
class StudentController extends Controller
{
    public function create()
    {
    	return view('student_create');
    }
    public function save()
    {
    	$PostData=Request()->except('_token');
    	// dd($PostData['stu_address1']);
    	$res=Students::create($PostData);
    	// dd($res);
    	if($res){
    		return redirect('student/lie');
    	}
    }
    public function list()
    {
    	$lists=Students::where(['stu_status'=>0])->get();
    	$list=Students::where(['stu_status'=>1])->get();
    	return view('student_list',['list'=>$list,'lists'=>$lists]);
    }
    public function update($stu_id)
    {
    	$info=Students::find($stu_id);
    	// dd($info['stu_address2']);
    	return view('student_update',['info'=>$info]);
    }
    public function update_do($stu_id)
    {
    	$PostData=Request()->except('_token');
    	$res=Students::where(['stu_id'=>$stu_id])->update($PostData);
    	if($res){
    		return redirect('student/lie');
    	}
    }
}
