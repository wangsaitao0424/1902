<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加用户-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/
coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;修改管理员
			</div>
		</div>
		<div class="page ">
			<!-- 会员注册页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>修改会员注册</span>
				</div>
				<form method="post" action="{{url('store/update/'.$data->user_id)}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="user_id" value="{{$data->user_id}}" />
				<input type="hidden" name="oldimg" value="{{$data->files}}" />
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;用户名：<input type="text" name="user_name" value="{{$data->user_name}}" class="input3" />
						@php echo $errors->first('user_name')  @endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码：<input type="password"
							class="input3" value="{{$data->user_pwd}}" name="user_pwd" />
							@php echo $errors->first('user_pwd')  @endphp
					</div>
					<div class="bbD">
						用户等级：<input type="text" name="user_grade" value="{{$data->user_grade}}" class="input3" />
						@php echo $errors->first('user_grade')  @endphp
					</div>
					<div class="bbD">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;性别：<input type="radio"  name="user_sex" value="1"  @if($data->user_sex==1) checked="checkbox" @endif />男&nbsp;&nbsp;<input type="radio" name="user_sex" value="2"  @if($data->user_sex==2) checked="checkbox" @endif />女@php echo $errors->first('user_sex')  @endphp
					</div>
					<div class="bbD">
						<input type="file" name="files" />
						<img src="{{env('UPLOAD_URL')}}{{$data->files}}" height="40">
					</div>
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes">提交</button>
							<a class="btn_ok btn_no" href="/">取消</a>
						</p>
					</div>
				</div>
			</div>
			</form>
			<!-- 会员注册页面样式end -->
		</div>
	</div>
</body>
</html>