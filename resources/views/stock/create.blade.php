<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>货物管理</title>
</head>
<body>
	<h2>货物入库</h2>
	<form action="{{url('stock/save')}}" method="post" enctype="multipart/form-data" >
	@csrf
	<table border="66">
		<tr>
			<td>货物名称</td>
			<td><input type="text" name="stock_name"></td>
		</tr>
		<tr>
			<td>货物图片</td>
			<td><input type="file" name="goods_img"/></td>
		</tr>
		<tr>
			<td>货物的数量</td>
			<td><input type="number" name="stock_num"></td>
		</tr>
		<tr>
			<td><input type="submit" value="入库"></td>
			<td></td>
		</tr>
	</table>
	</form>
</body>
</html>