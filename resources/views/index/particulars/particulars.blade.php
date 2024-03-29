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
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
      <img src="{{env('UPLOAD_URL')}}{{$goods['goods_img']}}" />
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange">￥{{$goods['shop_price']}}</strong></th>
       <td>
        <input type="text" class="spinnerExample" name="buy_number" id="n_ipt"/>
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$goods['goods_name']}}</strong>
        <p class="hui">暂无信息</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <!-- <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul> --><!--guige/-->
     <!-- <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div>zhaieq/
     <div class="proinfoList">
      <img src="images/image4.jpg" width="636" height="822" />
     </div><!--proinfoList/-->
     <!-- <div class="proinfoList">
      暂无信息....
     </div> --><!--proinfoList/-->
     <!-- <div class="proinfoList">
      暂无信息......
     </div> --> <!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <!-- <td><a class="button" href="{{url('particulars/addCar'.'/'.$goods['goods_id'])}}"  >加入购物车</a></td> -->
       <td><button class="button" id="addcar">加入购物车</button></td>
      </tr>
     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/index/js/jquery.excoloSlider.js"></script>
    <script>
    $(function () {
     $("#sliderA").excoloSlider();
    });
  </script>
     <!--jq加减-->
    <script src="/index/js/jquery.spinner.js"></script>
   <script>
  $('.spinnerExample').spinner({});
  //input 防止xss攻击
            jQuery('#n_ipt').blur(function(){
                // alert(1);
                var text=parseInt(jQuery(this).val());
                // alert(text);return;
                var goods_number={{$goods['goods_number']}};
                // alert(goods_number);
                // alert(text);
                if(isNaN(text)){
                    text=1;
                }
                if(goods_number<text){
                    text=goods_number;
                }
                if(text<=1){
                    text=1;
                }
                jQuery(this).val(text);
            })
          //添加购物车
            $('#addcar').click(function(){
                var goods_id={{$goods['goods_id']}};
                // alert(goods_id);return;
                var buy_number=$('#n_ipt').val();
                $.ajaxSetup({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                }); 
                // alert(buy_number);return;
                if(goods_id&&buy_number){
                    $.post("{{url('particulars/addCar')}}",{goods_id:goods_id,buy_number:buy_number},function(msg){
                        // alert(msg);
                        if(msg.code=="00000"){
                             alert(msg.msg);
                             location.href="{{url('car/index')}}";
                        }else if(msg.code=="00001"){
                              alert(msg.msg);
                              var url="{{url('log')}}";
                              location.href=url;
                        }
                    },'json')
                }
            })
            
  </script>
  </body>
</html>
