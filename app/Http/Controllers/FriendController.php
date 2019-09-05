<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Friend;
use Illuminate\Validation\Rule;
class FriendController extends Controller
{
	/**
	 * 添加页
	 * [create description]
	 * @return [type] [description]
	 */
    public function create()
    {
    	return view('admin/friend/create');
    }
    /**
     * 添加执行
     * [save description]
     * @return [type] [description]
     */
    public function save()
    {
    	$PostData=Request()->except('_token');
    	// dump($PostData);
    	$validator = Validator::make($PostData, [
			'site_name' => 'required|unique:friend|max:60',
			'friend_url' => 'required',
		]);
		if ($validator->fails()) {
			return redirect('friend/create')
			->withErrors($validator)
			->withInput();
		}
		if(request()->hasFile('files'))
		{
			$PostData['files']=upload('files');
		}
		$info=Friend::create($PostData);
		return redirect('friend/list');
    }
    /**
     * 列表
     * [list description]
     * @return [type] [description]
     */
    public function list()
    {
    	$query=Request()->get('site_name');
    	// dump($site_name);
    	$where=[];
    	if($query){
    		$where[]=['site_name','like',"%$query%"];
    	}
    	$pageSize=config('app.pageSize');
    	$data=Friend::where($where)->paginate($pageSize);
    	// dump($data);
    	return view('admin/friend/list',['data'=>$data,'query'=>$query]);
    }
    /**
     * 修改页
     * [edit description]
     * @param  [type] $friend_id [description]
     * @return [type]          [description]
     */
    public function edit($friend_id)
    {
        $data=Friend::find($friend_id);
        return view('admin/friend/edit',['data'=>$data]);
    }
    public function update($friend_id)
    {
        // echo $friend_id;die;
        $PostData=Request()->except('_token');
        
        $validator = Validator::make($PostData, [
           'site_name' => [
                'required',
                Rule::unique('friend')->ignore($friend_id,'friend_id'),
                'max:60',
            ],
           'friend_url' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('friend/edit'.$friend_id)
            ->withErrors($validator)
            ->withInput();
        }
        // dd($PostData);
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
        $res=Friend::where(['friend_id'=>$friend_id])->update($PostData);
        // if($res){
             
        // }
        return redirect('friend/list');
        
    }

    public function delete($friend_id)
    {
        // echo $friend_id;die;
        $res=Friend::where(['friend_id'=>$friend_id])->delete();
        // return redirect('friend/list');
        if ($res) {
	      $data = [
	        'status' => 0,
	        'msg' => '删除成功'
	      ];
	    } else {
	      $data = [
	        'status' => 1,
	        'msg' => '删除失败'
	      ];
	    }
	    return $data;
	}

    public function checkName()
    {
        $site_name=Request()->site_name;
        $friend_id=Request()->friend_id??'';
        // echo $site_name;
        $where=[];
        if($site_name){
            $where[]=['site_name','=',$site_name];
        }
        if($friend_id){
            $where[]=['friend_id','!=',$friend_id];
        }
        $res=Friend::where($where)->count();
        return $res;
    }
}
