<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="http://www.laravel.com/css/bootstrap.min.css">  
	<title>无标题</title>
</head>
<body>
<form method="" action="">
	姓名：<input type="text" value="{{$student_name}}" name="student_name" placeholder="请填入姓名"><br>
	年龄：<input type="text" value="{{$student_age}}" name="student_age" placeholder="请填入年龄"><br>
	<button>搜索</button>
</form>
<table border="10" align="content">
	<tr>
		<td>ID</td>
		<td>姓名</td>
		<td>年龄</td>
		<td>性别</td>
		<td>文件</td>
	</tr>
@foreach ($list as $v)
	<tr>
		<td>{{$v->student_id}}</td>
		<td>{{$v->student_name}}</td>
		<td>{{$v->student_age}}</td>
		<td>
			@if($v->student_sex==0)男@else女@endif
		</td>
		<td>
			<img src="{{env('UPLOAD_URL')}}{{$v->file}}" height="40">
		</td>
	</tr>
@endforeach
</table>
{{ $list->appends($query)->links() }}
</body>
</html>