@if (session('status'))
<div class="alert alert-success">
{{ session('status') }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>添加竞猜球队</title>
</head>
<body>
	<h1>添加竞猜球队</h1>
	<form action="{{url('soccer/save')}}" method="post">
	@csrf
		<table cellpadding="5">
			<tr>
				<td><input type="text" name="nba1"><b>vs</b></td>
				<td><input type="text" name="nba2"></td>
			</tr>
			<tr>
				<td>结束竞猜时间：</td>
				<td><input type="datetime-local" name="finish_time"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="添加"></td>
			</tr>
		</table>
	</form>
</body>
</html>