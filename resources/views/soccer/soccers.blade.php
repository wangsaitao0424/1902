<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
<h2>我要竞猜</h2>
<h3>{{$info->nba1}}vs{{$info->nba2}}</h3>
<input type="radio" name="soccer_result" value="0">胜
<input type="radio" name="soccer_result" value="1">负
<input type="radio" name="soccer_result" value="2">平局<br>
<input type="button" value="确定" onclick="soccerss()">
<script src="/js/jq.js"></script>
<script>
	function soccerss() {
		soccer_id={{$info->soccer_id}}
		// alert(soccer_id);
		if(!soccer_id){
			alert('请');return;
		}
		soccer_result=$('input:checked').val();
		// alert(soccer_result);
		if(!soccer_result){
			alert('请选择您要竞猜结果');return;
		}
		$.ajax({
			url:"{{url('soccer/soccerss')}}",
			data:{'soccer_result':soccer_result,'soccer_id':soccer_id},
			success:function(msg){
				alert('已竞猜');
				location.href="{{url('soccer/list')}}"
			}
		})
	}
</script>
</body>
</html>
