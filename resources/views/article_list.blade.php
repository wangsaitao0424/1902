<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
<b>列表页</b>
	<table>
	@foreach($data as $v)
		<tr>
			<td><a href="{{url('article/content/'.$v->article_id)}}">{{$v->title}}</a></td>
			<td><a class="but" data-id="{{$v['article_id']}}">{{$v['flag']}}</a> <b class="su{{$v['article_id']}}" >{{$v->name}}</b></td>
		</tr>
	@endforeach
	</table>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
	$('.but').click(function(){
		var obj=$(this);
		var article_id=obj.data('id');
		var su=$('.su'+article_id).text();
		var flag = obj.html();
		// alert(article_id);
		$.ajax({
			url:"{{url('article/zan')}}",
			data:{'article_id':article_id,'flag':flag},
			success:function(msg){
				$('.su'+article_id).html(msg);
				if(flag=='点赞'){
					obj.html('取消点赞');
				}else{
					obj.html('点赞');
				}
				
			}
		})
		
		
	})
</script>