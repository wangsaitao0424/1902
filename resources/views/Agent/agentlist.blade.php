<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>生成带参数二维码</title>
</head>
<body>
 <center>
    <table border="1">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>二维码</td>
            <td>操作</td>
        </tr>
        @foreach($list as $v)
        <tr>
            <td>{{$v->w_id}}</td>
            <td>{{$v->name}}</td>
            <td><img src="{{asset($v->agent_path)}}" alt="" height="100" ></td>
            <td><a href="{{url('wechat/agent_qu')}}?uid={{$v->w_id}}">生成二维码</a></td>
        </tr>
        @endforeach
    </table>
 </center>
</body>
</html>