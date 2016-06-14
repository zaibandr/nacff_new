<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('404', function () {
//    return View::make('errors.404');
//});
Route::post('auth',['as'=>'auth', 'uses'=>'AuthController@check']);
Route::get('auth',function(){
    return View::make('auth');
});
Route::get('phpinfo',function(){
    return phpinfo();
});
Route::get('messages','InfoController@index');
Route::get('integration','InfoController@index');
Route::get('help','InfoController@index');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'isAdmin'], function () {
        Route::resource('page66','LPU');
        Route::get('page67','LPU@index');
        Route::get('page68','LPU@index');
    });
    Route::get('/', function () {
        return View::make('main');
    });
    $arr = [1,2,18,19,38,43,44,45,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63];
    Route::get('/main', ['as' => 'main', 'uses' => 'MainController@index']);
    Route::resource('page47', 'DiscountController', array('except'=>['show', 'create']));
    Route::resource('page6', 'UserController', array('except'=>['show', 'create']));
    Route::resource('page20', 'DepController', array('except'=>['show', 'create']));
    foreach ($arr as $v) {
        Route::any("page$v", ['as' => "page$v", 'uses' => "MainController@page$v"]);
    }
    Route::resource('request', 'RequestController', array('only' => array('index', 'show')));
    Route::get('draft/{id}', 'DraftController@index');
    Route::get('pid/{id}', 'PidController@index');
    Route::any('print/{id}', 'PrintController@index');
    Route::get('delete/{id}', 'DeleteController@index');
    Route::resource('edit', 'EditController', array('only' => array('index', 'show')));
    Route::resource('new', 'NewRegController', array('only' => array('index', 'show')));
    Route::get('mail/{id}', 'MailController@index');
    Route::post('mail/{id}', 'MailController@indexPost');
// Authentication routes...
    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | This route group applies the "web" middleware group to every route
    | it contains. The "web" middleware group is defined in your HTTP
    | kernel and includes session state, CSRF protection, and more.
    |
    */
});
Route::any('/test', ['as' => 'test', 'uses' => 'test@index']);
Route::any('/logout', function () {
    Session::put('userCheck', 0);
    Session::forget('login');
    Session::forget('menu');
    Session::forget('isAdmin');
    Session::forget('clientid');
    Session::forget('dept');
    return Redirect::route('main');
});
Route::group(['middleware' => ['web']], function () {
    //
});
