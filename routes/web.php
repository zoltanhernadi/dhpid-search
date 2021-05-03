<?php

use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/dso/en/search');
Route::group(['prefix' => 'dso'], function(){

    Route::group(['prefix' => '{language}'], function(){
        Route::view('/search', 'AHR.search')->name('search');
        Route::get('/establishment', 'AHR\EstablishmentController@establishmentPage')->name('establishment');
        Route::get('/deficiencies', 'AHR\InitialDeficienciesController@deficiencies')->name('deficiencies');
        Route::get('/reportcard', 'AHR\ReportCardController@reportcard')->name('reportcard');
        Route::get('/result', 'AHR\ResultController@receive')->name('result');
    });
});

Route::redirect('/cto', '/cto/en/search');
Route::group(['prefix' => 'cto'], function(){
    Route::group(['prefix' =>'{language}'], function(){
        Route::view('/search', 'CTO.search')->name('ctosearch');
        Route::get('/result', 'CTO\ResultController@receive')->name('ctoresult');
        Route::get('/establishment', 'CTO\EstablishmentController@establishmentPage')->name('ctoestablishment');
        Route::get('/deficiencies', 'CTO\InitialDeficienciesController@deficiencies')->name('ctodeficiencies');
        Route::get('/reportcard', 'CTO\ReportCardController@reportcard')->name('ctoreportcard');
    });
});
