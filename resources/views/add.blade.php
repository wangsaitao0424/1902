<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
<conter>
<!-- @if ($errors->any()) -->
	<div class="alert alert-danger">
	<ul>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	<!-- @endforeach -->
	</ul>
	</div>
	<!-- @endif -->
	<form method="post" action="{{route('d')}}" enctype="multipart/form-data">
	@csrf
		<table border="1">
			<tr>
				<td>姓名</td>
				<td><input type="text" name="student_name" placeholder="请输入学生姓名">@php echo $errors->first('student_name')  @endphp</td>
			</tr>
			<tr>
				<td>年龄</td>
				<td><input type="number" name="student_age" placeholder="请输入学生年龄">@php echo $errors->first('student_age')  @endphp</td>
			</tr>
			<tr>
				<td>文件上传</td>
				<td><input type="radio" name="student_sex" value="0">男<input type="radio" name="student_sex" value="1">女 @php echo $errors->first('student_sex')  @endphp</td>
			</tr>
			<tr>
				<td>性别</td>
				<td><input type="file" name="file" id="file" /> </td>
			</tr>
			<tr>
				<td><button>提交</button></td>
				<td></td>
			</tr>
		</table>
	</form>
</conter>
</body>
</html>