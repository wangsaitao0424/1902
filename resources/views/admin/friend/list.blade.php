<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<link rel="stylesheet" href="http://www.laravel.com/css/bootstrap.min.css">  
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/

coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;-</span>&nbsp;管理员管理
			</div>
		</div>
		
		
		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					<form method="" action="list">
						<div class="cfD">
							<input class="userinput" type="text" value="{{$query}}" name="site_name" placeholder="输入网站名称" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							
							<button class="userbtn">搜索</button>&nbsp;&nbsp;<!-- <button class="userbtn" href="create">添加</button> -->
						</div>
					</form>
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="435px" class="tdColor">网站名称</td>
							<td width="400px" class="tdColor">图片LOGO</td>
							<td width="400px" class="tdColor">链接类型</td>
							<td width="400px" class="tdColor">状态</td>
							<!-- <td width="630px" class="tdColor">排序</td> -->
							<td width="130px" class="tdColor">操作</td>
						</tr>
						@foreach ($data as $v)
						<tr height="40px">
							<td>{{$v->friend_id}}</td>
							<td>{{$v->site_name}}</td>
							<!-- <td>{{$v->friend_url}}</td> -->
							<td><img src="{{env('UPLOAD_URL')}}{{$v->files}}" height="20"></td>
							<!-- <td>{{$v->friend_url}}</td> -->
							<td>@if($v->con_type==0)LOGO链接@else文字链接@endif</td>
							<td>@if($v->is_show==0)显示@else不显示@endif</td>
							
							<!-- <td>{{$v->sort_order}}</td> href="{{url('friend/delete/'.$v->friend_id)}}"-->
							<td><a href="{{url('friend/edit/'.$v->friend_id)}}"><img class="operation"
									src="/admin/img/update.png"></a> <a  onclick="delUser({{ $v->friend_id }})"><img class="operation delban"
								src="/admin/img/delete.png"></a></td>
						</tr>
						@endforeach
					</table>
					<div class="paging">{{ $data->appends(['site_name'=>$query])->links() }}</div>
				</div>
				<!-- user 表格 显示 end-->
			</div>
			<!-- user页面样式end -->
		</div>

	</div>


	<!-- 删除弹出框 -->
	<!-- <div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="/admin/img/

shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="{{url('brand/delete/'.$v->brand_id)}}" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div> -->
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
// 广告弹出框
$(".delban").click(function(){
  $(".banDel").show();
});
$(".close").click(function(){
  $(".banDel").hide();
});
$(".no").click(function(){
  $(".banDel").hide();
});
// 广告弹出框 end

function delUser(friend_id)
{
	// alert(friend_id);return;
	var pages=$('.paging .active').text();
	// alert(page);return;
    $.get("{{ url('friend/delete') }}/" + friend_id, {  // 网址、数据、成功后操作
    }, function(data) {
      if (data.status == 0) {
        alert(data.msg);
        location.href = "{{ url('friend/list?page=') }}"+pages;
      } else {
        alert(data.msg);
      }
    });
  }

</script>
</html>