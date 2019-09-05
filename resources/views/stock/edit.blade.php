@if (session('status'))
<div class="alert alert-success">
{{ session('status') }}
</div>
@endif
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<form action="{{url('stock/update/'.$stock->stock_id)}}" method="post">
		@csrf
		<input type="hidden" name="stock_num" value="{{$stock->stock_num}}">
		<input type="number" name="stock_nums">
		<input type="submit" value="出库">
	</form>
</body>
</html>