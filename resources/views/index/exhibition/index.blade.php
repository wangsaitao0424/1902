@extends('layouts.index')
@section('content')

     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <form action="#" method="get" class="prosearch"><input type="text" /></form>
      </div>
     </header>
     <ul class="pro-select">
      <li class=""><a href=""  order_1="1" class="new1">新品</a></li>
      <li><a href="javascript:;" order_2="2"  class="new1">销量</a></li>
      <li><a href="javascript:;"  order_3="3" class="new1">价格</a></li>
     </ul><!--pro-select/-->
     <div class="prolist">
     @foreach($goods as $v)
      <dl>
       <dt><a href="{{url('particulars'.'/'.$v['goods_id'])}}"><img src="{{env('UPLOAD_URL')}}{{$v['goods_img']}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('particulars'.'/'.$v['goods_id'])}}">{{$v['goods_name']}}</a></h3>
        <div class="prolist-price"><strong>¥{{$v['shop_price']}}</strong> <!-- <span>¥599</span> --></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      @endforeach
     </div><!--prolist/-->
     <script src="/js/jq.js"></script>
     <script >
        $('.new1').click(function(){

            // $(this).parent().addClass('pro-selCur').parent().removeClass('pro-selCur');
        })
     </script>
     @endsection
    