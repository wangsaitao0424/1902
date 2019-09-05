<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<form action="{{url('student/save')}}" method="post">
	@csrf
		<table border="66" >
			<tr>
				<td>学生姓名</td>
				<td><input type="text" name="stu_name"></td>
			</tr>
			<tr>
				<td>学生年龄</td>
				<td>
					<select name="stu_age">
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>学生地址</td>
				<td>
					<select name="stu_address1">
						<option value="北京">北京</option>
					</select>
					<select name="stu_address2">
						<option value="昌平">昌平</option>
						<option value="房山">房山</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>学生状态</td>
				<td><input type="radio" name="stu_status" value="1" checked>在校<input type="radio" name="stu_status" value="0">离校</td>
			</tr>
			<tr>
				<td><input type="submit" value="提交"></td>
				<td></td>
			</tr>
		</table>
	</form>
</body>
</html>