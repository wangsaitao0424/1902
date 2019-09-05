<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>无标题</title>
</head>
<body>
	<button class="show">显示离校学生</button>
	<table border="66" class="a">
		<tr>
			<td>ID</td>
			<td>姓名</td>
			<td>年龄</td>
			<td>市</td>
			<td>区</td>
			<td>状态</td>
			<td></td>
		</tr>
		@foreach($list as $v)
		<tr>
			<td>{{$v->stu_id}}</td>
			<td>{{$v->stu_name}}</td>
			<td>{{$v->stu_age}}</td>
			<td>{{$v->stu_address1}}</td>
			<td>{{$v->stu_address2}}</td>
			<td> @if ($v->stu_status == 1) 在校 @else 离校 @endif </td>
			<td><a href="{{url('student/update/'.$v->stu_id)}}">编辑</a>|<a href=""></a></td>
		</tr>
		@endforeach
	</table>
	<table border="66" class="b" style="display:none;">
		<tr>
			<td>ID</td>
			<td>姓名</td>
			<td>年龄</td>
			<td>市</td>
			<td>区</td>
			<td>状态</td>
			<td></td>
		</tr>
		@foreach($lists as $v)
		<tr>
			<td>{{$v->stu_id}}</td>
			<td>{{$v->stu_name}}</td>
			<td>{{$v->stu_age}}</td>
			<td>{{$v->stu_address1}}</td>
			<td>{{$v->stu_address2}}</td>
			<td> @if ($v->stu_status == 1) 在校 @else 离校 @endif </td>
			<td><a href="{{url('student/update/'.$v->stu_id)}}">编辑</a>|<a href=""></a></td>
		</tr>
		@endforeach
	</table>
</body>
</html>
<script src="/js/jq.js"></script>
<script type="text/javascript">
    $('.show').click(function() {
        // alert(1)
        var a = $(this).text();
        if (a=='显示离校学生') {
      	$(this).text('显示在校学生');
            $('.a').hide();
            $('.b').show();
        }else{
            $(this).text('显示离校学生');
            $('.b').hide();
            $('.a').show();
        }
    });
</script>