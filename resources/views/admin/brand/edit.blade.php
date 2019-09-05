<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头部-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/
coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">品牌管理</a>&nbsp;-</span>&nbsp;品牌添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>品牌添加</span>
				</div>
				<form method="post" action="{{url('brand/update/'.$data->brand_id)}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="brand_id" value="{{$data->brand_id}}" />
				<input type="hidden" name="oldimg" value="{{$data->brand_logo}}" />
				<div class="baBody">
					<div class="bbD">
						品牌名称：<input type="text" class="input1" value="{{$data->brand_name}}" name="brand_name" />@php echo $errors->first('brand_name') @endphp
					</div>
					<div class="bbD">
						链接地址：<input type="text" class="input1" value="{{$data->site_url}}" name="site_url" />
						@php echo $errors->first('site_url') @endphp
					</div>
					<div class="bbD">
						上传图片：
						<div class="bbDd">
							<div class="bbDImg">+</div>
							<input type="file" class="file" value="{{$data->brand_logo}}" name="brand_logo" /> <!-- <a class="bbDDel" href="#">删除</a> -->
						<img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}" height="40">

						</div>
					</div>
					<div class="bbD">
						是否显示：<label><input type="radio" checked="checked" name="is_show" value="1" @if($data->is_show==1) checked="checkbox" @endif />是</label> <label><input
							type="radio" name="is_show" value="0" @if($data->is_show==0) checked="checkbox" @endif />否</label>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input class="input2"
							type="number" value="{{$data->sort_order}}"  name="sort_order" />
					</div>
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes" >提交</button>
							<a class="btn_ok btn_no" href="/">取消</a>
						</p>
					</div>
				</div>
			</div>
			</form>
			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
</html>