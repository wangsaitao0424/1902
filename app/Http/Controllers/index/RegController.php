<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\index\Index_User;
class RegController extends Controller
{
    public function index()
    {
    	// $name = request()->session()->get('codes');
    	// dump($name);
    	return view('index/reg');
    }
    public function reg_save()
    {
    	$PostData=Request()->only(['emil', 'pwd']);
    	// dd($PostData);
    	// if($PostData['pwd']!=$PostData['pwds']){
    	// 	return redirect('reg');
    	// }
         
    	$res=Index_User::insert($PostData);
    	if($res){
    		return redirect('log');
    	}else{
    		return redirect('reg');
    	}
    	// dd($PostData['']);
    	// $email=$PostData['emil'];
   //  	if(!$PostData['code']){
			
			// $num=$this->send($email);
			// // echo $num;
			// // return redirect('reg');
   //  	}

    }

    public function reg_emil()
    {
    	$email=Request()->emil??'';
    	$code=Request()->code??'';
    	$pwd=Request()->pwd??'';
    	$pwds=Request()->pwds??'';
    	// dump($code);
    	// dd($email);
    	if($pwds){
    		if($pwd==$pwds){
    			$data = [
		        'status' => 1,
		        'msg' => '密码已确认'
		      ];
    		}else{
				$data = [
		        'status' => 0,
		        'msg' => '请填写一致的密码'
		      ];    		
		  }
		  return $data;die;
    	}
    	if($code){
    		$name = request()->session()->get('name');
    		$codes = request()->session()->get('codes');
    		if($email==$name&&$code==$codes){
    			$data = [
		        'status' => 1,
		        'msg' => '验证码正确'
		      ];
    		}else{
				$data = [
		        'status' => 0,
		        'msg' => '请填写正确的验证码',
		      ];
    		}
             // request()->session()->pull('codes',session('codes'));
            // $request->session()->forget('name');
            request()->session()->forget('codes');
	     return $data;die;
    	}
    	// dd($email);
    	$num=$this->send($email);
        session(['name'=>$email]);
        session(['codes'=>$num]);
    }
    public function send($email)
    {
        $num=rand('1000','9999');
        $msg=$num;
        \Mail::raw($msg ,function($message)use($email){
        //设置主题
            $message->subject("欢迎注册微商城有限公司");
        //设置接收方
            $message->to($email);
        });
        if($email){
            echo 11;die;
        }
        return $num;
    }
}
