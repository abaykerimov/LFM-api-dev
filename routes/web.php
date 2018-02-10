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

Route::get('/dob', function () {
    $players = \App\Models\Player::all();
    $arr = [];
    foreach ($players as $player) {
        array_push($arr, \Carbon\Carbon::createFromFormat('M j, Y', $player->date_of_birth)->format('Y-m-d'));

        $dob = \Carbon\Carbon::createFromFormat('M j, Y', $player->date_of_birth)->format('Y-m-d');

        $player->update(array('dob' => $dob));
    }
    return response()->json($arr);
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pusher', function() {
    event(new App\Events\AuctionCreated(\App\Models\Auction::find(2)));
    return "Event has been sent!";
});