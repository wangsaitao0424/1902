<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
// 	// 中间件
// 	session(['user'=>'王']);
// 	$user = Auth::user();
//     return view('welcome');
// });
// Route::get('hello',function(){
// 	return 'Hello, welcome to LaravelAcademy.org';
// });
// Route::get('user',function(){
// 	return '<form action="useradd" method="post"><input type="hidden" name="_token" value='.csrf_token().'><input type="text" name="names"><button>提交</button></form>';
// });
// Route::get('user',function(){
// 	return '<form action='.route('u').' method="post">'.csrf_field().'<input type="text" name="names"><button>提交</button></form>';
// });
// Route::post('useradd',function(){
// 	dd(request()->names);
// })->name('u');
// Route::match(['get','post'],'useradd',function(){
// 	dd(request()->names);
// });
// Route::any('useradd',function(){
// 	dd(request()->names);
// });
// 开发库存管理系统
Route::prefix('stock')->middleware('auth')->group(function (){
	// //首页
	// Route::get('index', 'admin\\AdminController@index');
	//管理员
	Route::get('create', 'StockController@create');
	Route::post('save', 'StockController@save');
	Route::get('list', 'StockController@list');
	Route::get('edit/{stock_id}', 'StockController@edit');
	Route::post('update/{stock_id}', 'StockController@update');
	Route::get('delete/{stock_id}', 'StockController@delete');
});
//足球结果竞猜系统
Route::prefix('soccer')->group(function (){
	Route::get('create', 'soccer\SoccerController@create');
	Route::post('save', 'soccer\SoccerController@save');
	Route::get('list', 'soccer\SoccerController@list');
	//竞猜中
	Route::get('soccers/{soccer_id}', 'soccer\SoccerController@soccers');
	Route::get('soccerss', 'soccer\SoccerController@soccerss');
	//竞猜已过时间结果
	Route::get('result/{soccer_id}', 'soccer\SoccerController@result');
	Route::get('delete/{goods_id}', 'soccer\SoccerController@delete');
});
// 文章
Route::prefix('article')->group(function (){
	Route::get('login', 'ArticleController@login');
	Route::post('login_do', 'ArticleController@login_do');
	Route::get('create', 'ArticleController@create');
	Route::post('save', 'ArticleController@save');
	Route::get('lie', 'ArticleController@list');
	Route::get('zan', 'ArticleController@zan');
	Route::get('content/{article_id}', 'ArticleController@content');
});

Route::get('yes/{id?}', 'UsersController@index');
//学生管理
Route::prefix('student')->group(function (){
	Route::get('create', 'StudentController@create');
	Route::post('save', 'StudentController@save');
	Route::get('lie{stu_status?}', 'StudentController@list');
	Route::get('update/{stu_id}', 'StudentController@update');
	Route::post('update_do{stu_id}', 'StudentController@update_do');
});

Route::prefix('student')->group(function (){
	Route::get('add', 'UsersController@add');
	Route::get('add_do', 'UsersController@add_do')->name('d');
	Route::post('lists', 'UsersController@lists');
});
Route::get('email', 'MailController@index');

Route::prefix('store')->middleware('auth')->group(function (){
	//首页
	Route::get('index', 'admin\\AdminController@index');
	//管理员
	Route::get('create', 'admin\\AdminController@create');
	Route::post('save', 'admin\\AdminController@save');
	Route::get('list', 'admin\\AdminController@list');
	Route::get('edit/{user_id}', 'admin\\AdminController@edit');
	Route::post('update/{user_id}', 'admin\\AdminController@update');
	Route::get('delete/{user_id}', 'admin\\AdminController@delete');
});
//品牌
Route::prefix('brand')->group(function (){
	Route::get('create', 'admin\\BrandController@create');
	Route::post('save', 'admin\\BrandController@save');
	Route::get('list', 'admin\\BrandController@list');
	Route::get('edit/{brand_id}', 'admin\\BrandController@edit');
	Route::post('update/{brand_id}', 'admin\\BrandController@update');
	Route::get('delete/{brand_id}', 'admin\\BrandController@delete');
});
//分类
Route::prefix('cat')->group(function (){
	Route::get('create', 'admin\\CatController@create');
	Route::post('save', 'admin\\CatController@save');
	Route::get('list', 'admin\\CatController@list');
	Route::get('edit/{cat_id}/{parent_id}', 'admin\\CatController@edit');
	Route::post('update/{cat_id}/{parent_id}', 'admin\\CatController@update');
	Route::get('delete/{cat_id}', 'admin\\CatController@delete');
});
//商品
Route::prefix('good')->group(function (){
	Route::get('create', 'admin\\GoodController@create');
	Route::post('save', 'admin\\GoodController@save');
	Route::get('list', 'admin\\GoodController@list');
	Route::get('edit/{goods_id}', 'admin\\GoodController@edit');
	Route::post('update/{goods_id}', 'admin\\GoodController@update');
	Route::get('delete/{goods_id}', 'admin\\GoodController@delete');
});
//登录认证
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//友情 ->middleware('checklogin')
Route::prefix('friend')->group(function (){
	Route::get('create', 'FriendController@create');
	Route::post('save', 'FriendController@save');
	Route::get('list', 'FriendController@list');
	Route::get('edit/{friend_id}', 'FriendController@edit');
	Route::post('update/{friend_id}', 'FriendController@update');
	Route::get('delete/{friend_id}', 'FriendController@delete');
	Route::post('checkName', 'FriendController@checkName');
});

//登录
Route::get('log/{goods_id?}', 'index\LoginController@index');
Route::get('index_wat', 'index\LoginController@wat_login');
Route::get('index/codes', 'index\LoginController@codes');

Route::post('log_do/{goods_id?}', 'index\LoginController@login_do');
//注册
Route::get('reg', 'index\RegController@index');
Route::post('reg_emil', 'index\RegController@reg_emil');
Route::post('reg_save', 'index\RegController@reg_save');
// Route::get('car', 'index\RegController@index');
//展示
Route::get('lists/{cat_id?}', 'index\ExhibitionController@index');
//详情
Route::get('particulars/{goods_id?}', 'index\ParticularsController@index');
//购物车
Route::post('particulars/addCar', 'index\CarController@addCar');
//购物车列表
Route::get('car/index', 'index\CarController@index');
//购物车计算金额
Route::get('car/getMoney', 'index\CarController@getMoney');
//前台首页
Route::get('/', 'index\IndexController@index');
Route::get('get_wechat_access_token','WechaController@get_wechat_access_token');
    Route::get('get_access_token','WechaController@get_access_token');
    Route::get('get_user_list{tagid?}','WechaController@get_user_list');
Route::get('codes','CodeController@login');
Route::prefix('wechat')->group(function (){
    Route::get('wechat_login','CodeController@wechat_login');
    Route::get('code','CodeController@code');
    Route::get('upload','WechaController@upload');//上传文件
    Route::post('do_upload','WechaController@do_upload');
    Route::get('clear_api','WechaController@clear_api');//调用频次清0
    Route::get('source','WechaController@wechat_source'); //素材管理
    Route::get('download_source','WechaController@download_source'); //下载资源
    Route::get('tag_list','TagController@tag_list');  //公众号标签列表
    Route::get('add_tag','TagController@add_tag');
    Route::post('do_add_tag','TagController@do_add_tag');
    Route::get('tag_openid_list','TagController@tag_openid_list'); //标签下用户的openid列表
    Route::post('tag_openid','TagController@tag_openid'); //为用户打标签
    Route::get('user_tag_list','TagController@user_tag_list'); //用户下的标签列表
    Route::get('push_tag_message','TagController@push_tag_message'); //推送标签消息
    Route::post('do_push_tag_message','TagController@do_push_tag_message'); //执行推送标签消息

});
Route::get('wechat/agent_list','AgentController@agent_list');
Route::get('wechat/agent_qu','AgentController@agent_qu');
Route::get('event','EventController@event');



