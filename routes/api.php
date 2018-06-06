<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
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

Route::get('test', function (){
    return 'working!';
});
Route::resource('tournament', 'TournamentController');
Route::resource('teams', 'TeamController');
Route::resource('players', 'PlayerController');
Route::resource('auction', 'AuctionController');
Route::resource('user', 'UserController');
Route::resource('offer', 'OfferController');
Route::resource('option', 'AuctionOptionController');
Route::resource('bookmarks', 'UserAuctionController');
Route::resource('reply', 'UserReplyController');
Route::resource('transfer', 'TransferController');

Route::get('getBookmark/{user_id}/{auction_id}', 'UserAuctionController@getBookmark');
Route::get('clubs/{user}', 'UserController@clubs');
//Route::get('players/search', 'PlayerController@search');