<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>添加页</title>
</head>
<body>
<b>添加页</b>
	<form action="{{url('article/save')}}" method="post">
	@csrf
		<table border="66">
			<tr>
				<td>标题</td>
				<td><input type="text" name="title">@php echo $errors->first('title')  @endphp</td>
			</tr>
			<tr>
				<td>作者</td>
				<td><input type="text" name="author">@php echo $errors->first('author')  @endphp</td>
			</tr>
			<tr>
				<td>内容</td>
				<td><textarea rows="3" cols="20" name="content"></textarea>@php echo $errors->first('content')  @endphp</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="submit"></td>
			</tr>
		</table>
	</form>
</body>
</html>