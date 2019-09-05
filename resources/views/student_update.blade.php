<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<form action="{{url('student/update_do'.$info->stu_id)}}" method="post">
	@csrf
		<table border="66" >
			<tr>
				<td>学生地址</td>
				<td>
					<select name="stu_address1">
						<option value="{{$info->stu_address1}}">{{$info->stu_address1}}</option>
					</select>
					<select name="stu_address2">@if ($info->stu_address2 == "昌平")
						<option value="昌平" >昌平</option>
						<option value="房山"  >房山</option>
						@elseif ($info->stu_address2 == "房山")
						<option value="房山"  >房山</option>
						<option value="昌平" >昌平</option>
						@endif
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" value="提交"></td>
				<td></td>
			</tr>
		</table>
	</form>
</body>
</html>