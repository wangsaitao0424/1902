<?php
	//文件上传
	function upload($name)
    {
        if (request()->file($name)->isValid()) {
            $photo = request()->file($name);
            // $extension = $photo->extension();
            //$store_result = $photo->store('photo');
            $store_result = $photo->store('');
            // $output = [
            // 'extension' => $extension,
            // 'store_result' => $store_result
            // ];
            // print_r($output);exit();
            return $store_result;
            }
            exit('未获取到上传文件或上传过程出错');
    }
    //无限极分类
   	function createTree($data,$parent_id=0,$level=1)
	{
		//1、定义一个容器  static 可以一直存在，不被循环掉
		static $new_arr=[];
		// dd($data);
		//2、遍历数据一条一条的找
		foreach ($data as $key => $value) {
			// dd($value);
			//3、先找parent_id=0
			if($value['parent_id']==$parent_id){
				//4、找到后放入容器中
				$value['level']=$level;
				$new_arr[]=$value;
				//5、调用程序自身递归找子级parent_id=cat_id
				createTree($data,$value['cat_id'],$level+1);
				// $new_arr = array_merge(createTree($data,$value['cat_id'],$lev+1));
			}
		}
		return $new_arr;
	}