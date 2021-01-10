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
use App\Models\RunCronJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Nelexa\GPlay\GPlayApps;

Route::get('/', function () {

//    event('start');
//
//
//    $date1 = new DateTime('2006-04-14 2:30:00');
//    $date2 = new DateTime('2006-04-14 4:10:10');
//
//// The diff-methods returns a new DateInterval-object...
//    $diff = $date2->diff($date1);
//
//// Call the format method on the DateInterval-object
//    echo $diff->format('%H:%I:%S');
//    die;


//    php artisan make:command DemoCron --command=demo:cron


    $gameAll = \App\Models\GooglePlayStoreGame::where('category_id', '1')
        ->orWhere('category_id', '2')
        ->orWhere('category_id', '3')
        ->orWhere('category_id', '4')
        ->orWhere('category_id', '5')
        ->orWhere('category_id', '6')
        ->orWhere('category_id', '7')
        ->orWhere('category_id', '8')
        ->orWhere('category_id', '9')
        ->orWhere('category_id', '10')
        ->orWhere('category_id', '11')
        ->orWhere('category_id', '12')
        ->orWhere('category_id', '13')
        ->orWhere('category_id', '14')
        ->orWhere('category_id', '15')
        ->orWhere('category_id', '16')
        ->orWhere('category_id', '17')
        ->orWhere('category_id', '18')
        ->orWhere('category_id', '19')
        ->count();
    $appAll = \App\Models\GooglePlayStoreGame::where('category_id', '<>', '1')
        ->where('category_id', '<>','2')
        ->where('category_id', '<>','3')
        ->where('category_id', '<>','4')
        ->where('category_id', '<>','5')
        ->where('category_id', '<>','6')
        ->where('category_id', '<>','7')
        ->where('category_id', '<>','8')
        ->where('category_id', '<>','9')
        ->where('category_id', '<>','10')
        ->where('category_id', '<>','11')
        ->where('category_id', '<>','12')
        ->where('category_id', '<>','13')
        ->where('category_id', '<>','14')
        ->where('category_id', '<>','15')
        ->where('category_id', '<>','16')
        ->where('category_id', '<>','17')
        ->where('category_id', '<>','18')
        ->where('category_id', '<>','19')
        ->count();
    $devAll = \App\Models\GooglePlayStoreDeveloper::where('id', '>=', 0)->count();

    $games = \App\Models\GooglePlayStoreGame::select(\Illuminate\Support\Facades\DB::raw('DATE_FORMAT(releaseDate, "%Y-%m-%d") as releaseDate, COUNT(releaseDate) as dateCount'))
        ->groupBy(\Illuminate\Support\Facades\DB::raw('DATE_FORMAT(releaseDate, "%Y-%m-%d")'))
        ->orderBy('releaseDate', 'DESC')->paginate(10);

    return view('welcome', ['games' => $games, 'count' => $gameAll, 'dev' => $devAll,'appCount' => $appAll]);

});
Route::get('start-up', function () {

});
