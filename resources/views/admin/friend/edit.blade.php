<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>友情添加-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;友情添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>友情添加</span>
				</div>
				<form  method="post" action="{{url('friend/update/'.$data->friend_id)}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="oldimg" value="{{$data->files}}" />
				<div class="baBody">
					<div class="bbD">
						网站名称：<input type="text" name="site_name" value="{{$data->site_name}}" class="input3" onblur="site1()" /><span class="span1" style="color:red">*</span>@php echo $errors->first('site_name'); @endphp
					</div>
					<div class="bbD">
						网站网址：<input type="text" name="friend_url" value="{{$data->friend_url}}" class="input3" onblur="url1()" /><span class="span2" style="color:red">*</span>@php echo $errors->first('friend_url'); @endphp
					</div>
					<div class="bbD">
						网站类型：<label><input type="radio" checked="checked"
							name="con_type" value="0" @if($data->con_type==0) checked="checkbox" @endif  />&nbsp;LOGO链接</label><label><input type="radio"
							name="con_type" value="1" @if($data->con_type==1) checked="checkbox" @endif />&nbsp;文字链接</label>
					</div>
					<div class="bbD">
						网站联系人：<input type="text" value="{{$data->friend_linkman}}" name="friend_linkman" class="input3" />
					</div>
					<div class="bbD">
						网站LOGO：<input type="file"  name="files"/><img src="{{env('UPLOAD_URL')}}{{$data->files}}" height="20">
					</div>
					
					<div class="bbD">
						网站介绍：
						<div class="btext">
							<textarea class="text2" name="friend_desc">{{$data->friend_desc}}</textarea>
						</div>
					</div>
					<!-- <div class="bbD">
						审核状态：<l abel><input type="radio" checked="checked"
							name="styleshoice1" />&nbsp;未审核</label> <label><input
							type="radio" name="styleshoice1" />&nbsp;已通过</label> <label class="lar"><input
							type="radio" name="styleshoice1" />&nbsp;不通过</label>
					</div> -->
					<div class="bbD">
						是否显示：<label><input type="radio" checked="checked"
							name="is_state" value="0" @if($data->is_state==0) checked="checkbox" @endif />&nbsp;是</label><label><input type="radio"
							name="is_state" value="1" @if($data->is_state==1) checked="checkbox" @endif />&nbsp;否</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<input class="btn_ok btn_yes" type="button" value="提交" onclick="check()">
							<a class="btn_ok btn_no" href="">取消</a>
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
<script type="text/javascript">
	function site1(){
		var site_name=$('[name="site_name"]').val();
		$('[name="site_name"]').next().empty();
		// var regular=/^[a-z0-9_-]{3,16}$/;
		// 中文字母数字下划线、网站验证格式不能为空
		var reg=/^(\w|-|[\u4E00-\u9FA5])*$/;
		if(site_name==""){
			$('.span1').text('网站名称不能为空');
			return;
		} 
		if(!reg.test(site_name)){
			$('.span1').text('用户名不合法');
			return;
		}
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
		  method: "POST",
		  url: "{{url('friend/checkName')}}",
		  async:false,
		  data: {site_name:site_name}
		}).done(function( msg ) {
		  if(msg>0){
			$('.span1').text('用户名已有');
			return;
		  }
		});

	}
	function url1(){

		var url2=$('[name="friend_url"]').val();
		$('[name="friend_url"]').next().empty();
		// 开头以http开头的
		var reg =/^((http):\/\/)/;
		if(url2==""){
			$('.span2').text('网站网址不能为空');
			return;
		}else if(!reg.test(url2)){
			$('.span2').text('网站网址必须以http开头');
			return;
		}
	}
	function check()
	{
		var fal=false;
		var site_name=$('[name="site_name"]').val();
		$('[name="site_name"]').next().empty();
		var friend_id={{$data->friend_id}};
		// var regular=/^[a-z0-9_-]{3,16}$/;
		// 中文字母数字下划线、网站验证格式不能为空
		var reg=/^(\w|-|[\u4E00-\u9FA5])*$/;
		if(site_name==""){
			$('.span1').text('网站名称不能为空');
			return;
		} 
		if(!reg.test(site_name)){
			$('.span1').text('用户名不合法');
			return;
		}
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
		  method: "POST",
		  url: "{{url('friend/checkName')}}",
		  async:false,
		  data: {site_name:site_name,friend_id:friend_id}
		}).done(function( msg ) {
		  if(msg>0){
			$('.span1').text('用户名已有');
			return;
		  }
		});
		var url2=$('[name="friend_url"]').val();
		$('[name="friend_url"]').next().empty();
		// 开头以http开头的
		var reg =/^((http):\/\/)/;
		if(url2==""){
			$('.span2').text('网站网址不能为空');
			return;
		}else if(!reg.test(url2)){
			$('.span2').text('网站网址必须以http开头');
			return;
		}
		$('form').submit();

	}
</script>