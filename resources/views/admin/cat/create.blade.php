<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题添加-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/
coin02.png" /><span><a href="">首页</a>&nbsp;-&nbsp;<a
					href="">公共管理</a>&nbsp;-</span>&nbsp;分类添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>话题添加</span>
				</div>
				<form  method="post" action="{{url('cat/save')}}" enctype="multipart/form-data">
				@csrf
				<div class="baBody">
					<div class="bbD">
						分类名称：<input type="text" name="cat_name" class="input3" />@php echo $errors->first('cat_name') @endphp
					</div>
					<div class="bbD">
						话题时长：<select class="input3" name="parent_id">
										<option value="0">顶级分类</option>
										@foreach ($cat as $v)
										<option value="{{$v->cat_id}}">{{str_repeat('——|  ',$v->level-1).$v->cat_name}}</option>
										@endforeach
								  </select>
					</div>
					<!-- <div class="bbD">
						审核状态：<label><input type="radio" checked="checked"
							name="styleshoice1" />&nbsp;未审核</label> <label><input
							type="radio" name="styleshoice1" />&nbsp;已通过</label> <label class="lar"><input
							type="radio" name="styleshoice1" />&nbsp;不通过</label>
					</div>
					<div class="bbD">
						是否推荐：<label><input type="radio" checked="checked"
							name="styleshoice2" />&nbsp;是</label><label><input type="radio"
							name="styleshoice2" />&nbsp;否</label>
					</div> -->
					<div class="bbD">
						分类排序：<input type="number" name="sort_order" class="input3" />@php echo $errors->first('sort_order') @endphp
					</div>
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes">提交</button>
							<a class="btn_ok btn_no" href="#">取消</a>
						</p>
					</div>
				</div>
				</form>
			</div>

			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
</html>