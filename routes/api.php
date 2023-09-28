<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register','RegisterController@register');
Route::post('login','RegisterController@login');


Route::get('showmymark','ResultController@showMyMark');
Route::post('priviliges','ResultController@priviliges');
Route::get('show','ResultController@show');
Route::get('showPriviliges','ResultController@showPriviliges');


//result for web:

Route::resource('resultsS','ResultScientificController');
Route::post('upload-resS','ResultScientificController@uploadContent');

Route::resource('resultsL','ResultLiteraryController');
Route::post('upload-resL','ResultLiteraryController@uploadContent');


//comparison:

Route::post('/upload-contentS',[\App\Http\Controllers\ComparisonScientificController::class,'uploadContent']);
Route::resource('comparisonS','ComparisonScientificController');

Route::post('/upload-contentL',[\App\Http\Controllers\ComparisonLiteraryController::class,'uploadContent']);
Route::resource('comparisonL','ComparisonLiteraryController');


Route::get('view','ComparisonController@show');



Route::get('chooseLanguage','ComparisonController@choose');

Route::get('showRigester','ComparisonController@showRigester');



Route::get('showFinalResult','ComparisonController@showFinalResult');


Route::get('test','ComparisonController@test');

Route::post('registerL','ComparisonLiteraryController@register');
Route::get('showDesire','ComparisonController@showDesire');


Route::post('registerS','ComparisonScientificController@register');



Route::get('algorithm','ComparisonController@algorithm');



Route::get('studentS','StudentController@showScientific');
Route::get('studentL','StudentController@showLitterary');

