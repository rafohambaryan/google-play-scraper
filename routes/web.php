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

use App\Models\GooglePlayStoreCategory;
use Nelexa\GPlay\GPlayApps;

Route::get('/', function () {

    $games = \App\Models\GooglePlayStoreGame::where('releaseDate' ,'>=', date('y-m-d'))->count();
    dd($games);
//    $google = new GPlayApps();
//  $developer = $google->getPermissions('com.yuwen.perfectart');
//    dd($developer);
    return view('welcome');
});
