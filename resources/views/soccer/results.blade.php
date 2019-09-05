<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<h2>比赛结果</h2>
	<h3>对阵结果：{{$info->nba1}}@if($info->soccer_result==0)胜@elseif($info->soccer_result==1)负@else平局@endif{{$info->nba2}}</h3>
	<h3>您的竞猜：{{$info->nba1}}@if($soccer_results==0)胜@elseif($soccer_results==1)负@else平局@endif{{$info->nba2}}</h3>
	<h3>结果：@if($soccer_results==$info->soccer_result)恭喜您，猜中了！@else 很遗憾，您没猜中@endif</h3>
</body>
</html>