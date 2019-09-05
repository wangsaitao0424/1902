@if(!empty(session('tip')))
        　　
        <div class="alert alert-success" role="alert" style="z-index: 999">
            　　　　{{session('tip')}}
        </div>
        <script>
            setInterval(function(){
                $('.alert').remove();
            },3000);
        </script>
@endif
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<form action="{{url('article/login_do')}}" method="post">
	@csrf
		<table>
			<tr>
				<td>姓名</td>
				<td><input type="text" name="user_name"></td>
			</tr>
			<tr>
				<td>密码</td>
				<td><input type="password" name="user_pwd"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="登录"></td>
			</tr>
		</table>
	</form>
</body>
</html>