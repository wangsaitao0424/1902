@extends('layouts.index')
@section('content')
@if(!empty(session('tip')))
        　　
        <div class="alert alert-success" role="alert" style="z-index: 999">
            　　　　{{session('tip')}}
        </div>
        <script>
            setInterval(function(){
                $('.alert').remove();
            },3000);
        </script>
    @endif
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
     <form action="{{url('log_do')}}" method="post" class="reg-login">
     @csrf
      <h3>还没有三级分销账号？点此<a class="orange" href="reg.html">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="emil" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="text" name="pwd" placeholder="输入证码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即登录" />
      </div>
     </form><!--reg-login/-->
    <div class="lrSub">
        <input type="button" class="code" value="微信登录" />
    </div>
    <script src="js/jq.js"></script>
    <script>
    // $('[name="emil"]').blur
        $('.code').click(function(){
            location.href="{{url('index_wat')}}";
        })
    </script>
     @endsection
     