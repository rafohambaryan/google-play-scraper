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
//    php artisan make:command DemoCron --command=demo:cron

    $gameAll = \App\Models\GooglePlayStoreGame::where('id', '>=', 0)->count();
    $devAll = \App\Models\GooglePlayStoreDeveloper::where('id', '>=', 0)->count();

//    $games = \App\Models\GooglePlayStoreGame::select(\Illuminate\Support\Facades\DB::raw('DATE_FORMAT(releaseDate, "%Y-%m-%d") as releaseDate, COUNT(releaseDate) as dateCount'))
//        ->groupBy(\Illuminate\Support\Facades\DB::raw('DATE_FORMAT(releaseDate, "%Y-%m-%d")'))
//        ->orderBy('releaseDate', 'DESC')->paginate(15);

    return view('welcome', ['games' => [], 'count' => $gameAll,'dev' => $devAll]);
});
