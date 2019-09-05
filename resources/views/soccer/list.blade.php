<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<h2>竞猜列表</h2>
	<table cellpadding="5">
	@foreach($data as $v)
		<tr>
			<td>{{$v->nba1}}<b>vs</b>{{$v->nba2}}</td>
			<td>@if(time()<$v->finish_time)<a href="{{url('soccer/soccers/'.$v->soccer_id)}}">竞猜</a>@else<a href="{{url('soccer/result/'.$v->soccer_id)}}">查看结果</a>@endif</td>
		</tr>
		@endforeach
	</table>
</body>
</html>