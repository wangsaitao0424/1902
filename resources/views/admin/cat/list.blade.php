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
							<input class="userinput" type="text" value="{{$cat_name}}" name="cat_name" placeholder="输入分类名称" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<button class="userbtn">搜索</button>&nbsp;&nbsp;<!-- <button class="userbtn" href="create">添加</button> -->
						</div>
					</form>
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="435px" class="tdColor">分类名称</td>
							<td width="400px" class="tdColor">分类排序</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
						@foreach ($data as $v)
						<tr height="40px">
							<td>{{$v->cat_id}}</td>
							<td>{{str_repeat('——|  ',$v->level-1).$v->cat_name}}</td>
							<td>{{$v->sort_order}}</td>
							<td><a href="{{url('cat/edit/'.$v->cat_id.'/'.$v->parent_id)}}"><img class="operation"
									src="/admin/img/update.png"></a> <a  onclick="del({{ $v->cat_id }})"><img class="operation delban"
								src="/admin/img/delete.png"></a></td>
						</tr>
						@endforeach
					</table>
					<div class="paging"></div>
				</div>
				<!-- user 表格 显示 end-->
			</div>
			<!-- user页面样式end -->
		</div>

	</div>


	
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
// 广告弹出框 end  href="{{url('cat/delete/'.$v->cat_id)}}"

function del(cat_id)
{
	// alert(friend_id);return;
	var pages=$('.paging .active').text();
	// alert(page);return;
    $.get("{{ url('cat/delete') }}/" + cat_id, {  // 网址、数据、成功后操作
    }, function(data) {
      if (data.status == 0) {
        alert(data.msg);
        location.href = "{{ url('cat/list') }}";
      } else {
        alert(data.msg);
      }
    });
  }
</script>
</html>