<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    名称：<input type="text" name="" ><br>
    密码：<input type="password" name=""><br>
    <input type="button" class="code" value="获取微信权限">
<script src="/js/jq.js"></script>
<script>
    $('.code').click(function() {
        location.href="{{ url('wechat/wechat_login') }}";
    })
</script>
</body>
</html>
