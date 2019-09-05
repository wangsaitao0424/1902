<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<table border="66">
		<tr>
			<td>货物id</td>
			<td>货物名称</td>
			<td>货物图</td>
			<td>当前库存量</td>
			<td>入库时间</td>
			<td>操作</td>
		</tr>
		@foreach($list as $v)
		<tr>
			<td>{{$v->stock_id}}</td>
			<td>{{$v->stock_name}}</td>
			<td><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" alt=""></td>
			<td>{{$v->stock_num}}</td>
			<td>{{date("Y-m-d H:i",$v->insert_time)}}</td>
			<td><a href="{{url('stock/edit/'.$v->stock_id)}}">出库</a></td>
		</tr>
		@endforeach
	</table>
</body>
</html>