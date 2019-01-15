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


Route::get('/', function (){
  return redirect(App\Http\Middleware\Locale::getLocale());
})->name('home');
//Route::post('translate','ControllerLanguages@GetTranslate')->name('translate');
Route::group(['prefix' =>  App\Http\Middleware\Locale::getLocale()], function() {
    Route::post('CheckEmail', 'Auth\RegisterController@checkUniqueEmail')->name('CheckEmail');
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('file', 'ControllerFile');
    Route::post('file/download', 'ControllerFile@download')->name('file.download');
    Auth::routes();
    Route::post('translate','ControllerLanguages@GetTranslate')->name('translate');
    Route::resource('profile', 'ControllerProfile', ['only' => [
        'index', 'update', 'destroy'
    ]])->middleware('auth');
    Route::resource('file.comment','ControllerComment',['only'=>['store','update','destroy']])->middleware('auth');
        Route::get( '{user}/files', 'ControllerProfile@showFiles')->name('profile.files')->middleware('auth');


});
Route::get('setlocale/{locale}', function ($locale) {
    $NewUri = null;
    $Refresh = URL::previous();
    $languages = Config::get('app.locales');
    if (in_array($locale, Config::get('app.locales'))) {
        Session::put('locale', $locale);
        for($i=0;$i<count($languages);$i++){
            $StartPos =strpos($Refresh,$languages[$i]);
            $EndPos =strripos($Refresh,$languages[$i]);
            if($StartPos && $EndPos){
                $NewUri = str_replace($languages,$locale,$Refresh);
                break;
            }
        }
        if(empty($NewUri)){
            //$EndPos =strripos($Refresh,request()->getHttpHost());
            $NewUri = substr_replace($Refresh, $locale, strlen($Refresh), 0);
        }
    } else{
        Session::put('locale', Config::get('app.locale'));
        return redirect('/');
    }

        return redirect($NewUri);

})->name('setlocale');