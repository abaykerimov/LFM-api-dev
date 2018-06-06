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

Route::get('/test', function() {
    $players = \App\Models\Player::where('tournament_id', 3)->get();
    foreach ($players as $player) {
        $id = strlen((string)$player->player_id);
        if ($id === 6) {
            $player->avatar .= 'png';
//            $player->save();
        } else if ($id === 5) {
            $player->avatar .= 'ng';
//            $player->save();
        } else if ($id === 4) {
            $player->avatar .= 'g';
//            $player->save();
        }
    }

    dd('ok');


//    $id = 27689;
////    $id = 0;
//    $players = \App\Models\Player::all();
//    foreach ($players as $player) {
//        $id++;
//        $auction = \App\Models\Auction::where('auction_option_id', 8)->where('player_id', $player->id)->first();
//        if($auction) {
//            $auction->player_id = $id;
//            $auction->save();
//        }
//        $player->id = $id;
//        $player->save();
//    }
});