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
//URL::forceRootUrl('https://nacpp.info/new'); // all your routes are declared below this point.
Route::post('auth',['as'=>'auth', 'uses'=>'AuthController@check']);
Route::get('auth',function(){
    return View::make('auth');
});
Route::get('phpinfo',function(){
    //return phpinfo();
});
Route::get('messages','InfoController@index');
Route::get('integration','IntegrationController@index');
Route::get('help','HelpController@index');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'isAdmin'], function () {
        Route::resource('page66','LPU');
        Route::resource('page67','AdminFolders', array('only'=>['index','store']));
        Route::resource('page68','AdminDep');
        Route::resource('page69','MenuSettings',array('only'=>['index','store', 'edit']));
        Route::resource('page70','PanelSettings',array('only'=>['index','store','create','destroy']));
        Route::resource('page71','TestSettings',array('only'=>['index','edit']));
        Route::resource('page72','NetController',['only'=>['index','edit','create','store','destroy']]);
        Route::resource('page74','PretenceController',['only'=>['index','edit','create','store','destroy']]);
        Route::any('/test', ['as' => 'test', 'uses' => 'test@index']);
    });
    Route::get('/', 'MainController@index');
    $arr = [1,2,18,19,38,43,44,45,48,49,51,52,53,54,55,56,57,58,59,60,61,62,63];
    Route::get('/main', ['as' => 'main', 'uses' => 'MainController@index']);
    Route::resource('page47', 'DiscountController', array('except'=>['show', 'create']));
    Route::resource('page6', 'UserController', array('except'=>['show', 'create']));
    Route::resource('page20', 'DepController', array('except'=>['show', 'create']));
    Route::resource('page50', 'PanelController');
    Route::resource('page73', 'CourierController', array('only'=>['index', 'store']));
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
Route::any('/panelPreanalytics', ['as' => 'PR', 'uses' => 'PR@index']);
Route::any('/logout', function () {
    Session::put('userCheck', 0);
    Session::forget('login');
    Session::forget('menu');
    Session::forget('isAdmin');
    Session::forget('clientid');
    Session::forget('clientcode');
    Session::forget('dept');
    Session::forget('name');
    return Redirect::route('main');
});
Route::group(['middleware' => ['web']], function () {
    //
});
