<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
<h2>比赛结果</h2>
<h3>{{$info->nba1}}vs{{$info->nba2}}</h3>
<input type="radio"  @if($info->soccer_result==0) checked  @endif >胜
<input type="radio"  @if($info->soccer_result==1) checked  @endif >负
<input type="radio"   @if($info->soccer_result==2) checked  @endif >平局
</body>
</html>