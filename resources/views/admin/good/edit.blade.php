<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>商品添加-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;商品添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>商品添加</span>
				</div>
				<form  method="post" action="{{url('good/update/'.$data->goods_id)}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="oldimg" value="{{$data->goods_imgd}}" />
				<div class="baBody">
					<div class="bbD">
						商品名称：<input type="text" name="goods_name" class="input3" value="{{$data->goods_name}}" />@php echo $errors->first('goods_name'); @endphp
					</div>
					<div class="bbD">
						商品货号：<input type="text" name="goods_sn" class="input3" value="{{$data->goods_sn}}" />
					</div>
					<div class="bbD">
						商品分类：<select class="input3" name="cat_id">
										<option value="{{$data->cat_id}}">{{$data->cat_name}}</option>
										@foreach ($cat as $v)
										<option value="{{$v->cat_id}}">{{str_repeat('——|  ',$v->level-1).$v->cat_name}}</option>
										@endforeach
								  </select>
					</div>
					<div class="bbD">
						商品品牌：<select class="input3" name="brand_id">
										<option value="{{$data->brand_id}}">{{$data->brand_name}}</option>
										@foreach ($brand as $v)
										<option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
										@endforeach
								  </select>
					</div>
					<!-- <div class="bbD">
						网站类型：<label><input type="radio" checked="checked"
							name="con_type" value="0" />&nbsp;LOGO链接</label><label><input type="radio"
							name="con_type" value="1" />&nbsp;文字链接</label>
					</div> -->
					<div class="bbD">
						本店售价：<input type="number" name="shop_price" class="input3" value="{{$data->shop_price}}" />@php echo $errors->first('shop_price'); @endphp
					</div>
					<div class="bbD">
						商品数量：<input type="number" name="goods_number" class="input3" value="{{$data->goods_number}}" />@php echo $errors->first('goods_number'); @endphp
					</div>
					<div class="bbD">
						上传商品图片：<input type="file" name="goods_img"/><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}">
					</div>
					
					<div class="bbD">
						介绍：
						<div class="btext">
							<textarea class="text2" name="goods_desc">{{$data->goods_desc}}</textarea>
						</div>
					</div>
					<!-- <div class="bbD">
						审核状态：<label><input type="radio" checked="checked"
							name="styleshoice1" />&nbsp;未审核</label> <label><input
							type="radio" name="styleshoice1" />&nbsp;已通过</label> <label class="lar"><input
							type="radio" name="styleshoice1" />&nbsp;不通过</label>
					</div> -->
					<div class="bbD">
						是否上架：<label><input type="radio" checked="checked"
							name="is_on_sale" value="0" @if($data->is_on_sale==0) checked="checkbox" @endif />&nbsp;是</label><label><input type="radio"
							name="is_on_sale" value="1" @if($data->is_on_sale==1) checked="checkbox" @endif />&nbsp;否</label>
					</div>
					<div class="bbD">
						是否热销：<label><input type="radio" checked="checked"
							name="is_hat" value="0" @if($data->is_hat==0) checked="checkbox" @endif />&nbsp;是</label><label><input type="radio"
							name="is_hat" value="1" @if($data->is_hat==1) checked="checkbox" @endif />&nbsp;否</label>
					</div>
					<div class="bbD">
						是否显示在首页：<label><input type="radio" checked="checked"
							name="is_new" value="0" @if($data->is_new==0) checked="checkbox" @endif />&nbsp;是</label><label><input type="radio"
							name="is_new" value="1" @if($data->is_new==1) checked="checkbox" @endif />&nbsp;否</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes">提交</button>
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
