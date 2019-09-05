@extends('layouts.index')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
 <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/
head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('reg_save')}}" method="post" class="reg-login">
     @csrf
      <h3>已经有账号了？点此<a class="orange" href="{{url('log')}}">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="emil" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" name="code" onblur="cod()" placeholder="输入短信验证码" /> <input type="button" onclick="emils()"  style="height:37.986px;width:174.722px;display:inline-block;margin:3;background-color:#f60;color:#fff;" value="获取验证码"></div>
       <div class="lrList"><input type="password" name="pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" name="pwds" onblur="pw()" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即注册" onclick="sub()" />
      </div>
     </form><!--reg-login/-->
<script src="/js/jq.js"></script>
<script type="text/javascript">
function emils(){
     var emil=$('[name="emil"]').val();
     var reg =/(^0{0,1}(13[0-9]|15[7-9]|153|156|18[7-9])[0-9]{8}$)|(^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$)/i;
     // alert(emil);return;
     if(!emil){
      alert("请填写手机号码或者邮箱号");return;
    }
    if(reg.test(emil)){
      alert("请填写正确的手机或邮箱");return;
    }
    
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajax({
      method: "post",
      url: "{{url('reg_emil')}}",
      data: { emil:emil }
    }).done(function( msgs ) {
      // alert(msg);return;
      alert("发送成功");
      // if (msgs.status == 1) {
        // alert(msgs.msg);return;
      // }
    });

  }
  function cod()
  {
    var emil=$('[name="emil"]').val();
    var code=$('[name="code"]').val();
    if(!code){
      alert("请填写验证码");return;
    }
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajax({
      method: "post",
      url: "{{url('reg_emil')}}",
      data: { code:code ,emil:emil}
    }).done(function( msgs ) {
      // alert(msg);return;
      alert("发送成功");
      // if (msgs.status == 0) {
      //   alert(msgs.msg);return;
      // }
    });
  }
  function pw()
  {
    var fal=false;
    var pwd=$('[name="pwd"]').val();
    var pwds=$('[name="pwds"]').val();
    // alert(pwds);
    if(!pwd){
      alert("请填入密码");return;
    }
    if(!pwds){
      alert("请填入确认密码");return;
    }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajax({
      method: "post",
      url: "{{url('reg_emil')}}",
      data: { pwd:pwd ,pwds:pwds}
    }).done(function( msgs ) {
      // alert(msg);return;
      // alert("发送成功");
      if (msgs.status == 0) {
        alert(msgs.msg);return;
      }
    });
  }
  function sub()
  {
    var fal=false;
    var emil=$('[name="emil"]').val();
    if(!emil){
      alert("请填写手机号码或者邮箱号");return;
    }
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajax({
      method: "post",
      url: "{{url('xz')}}",
      data: { emil:emil }
    }).done(function( msg ) {
      // alert(msg);return;
      alert("发送成功");
    });
    var code=$('[name="code"]').val();
    if(!code){
      alert("请填写验证码");return;
    }
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajax({
      method: "post",
      url: "{{url('reg_emil')}}",
      data: { code:code ,emil:emil}
    }).done(function( msgs ) {
      // alert(msg);return;
      // alert("发送成功");
      if (msgs.status == 0) {
        alert(msgs.msg);return;
      }
    });
     var pwd=$('[name="pwd"]').val();
    var pwds=$('[name="pwds"]').val();
    // alert(pwds);
    if(!pwd){
      alert("请填入密码");return;
    }
    if(!pwds){
      alert("请填入确认密码");return;
    }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); 
     $.ajax({
      method: "post",
      url: "{{url('reg_emil')}}",
      data: { pwd:pwd ,pwds:pwds}
    }).done(function( msgs ) {
      // alert(msg);return;
      // alert("发送成功");
      if (msgs.status == 0) {
        alert(msgs.msg);return;
      }
    });
    $('form').submit();
  }
</script>
     @endsection
