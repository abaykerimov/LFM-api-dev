<?php

namespace App\Http\Controllers;

use App\Events\AuctionCreated;
use App\Events\AuctionExpired;
use App\Models\Auction;
use App\Models\Offer;
use App\Models\UserAuction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    public function index() {
        $tournament = DB::table('tournaments')->latest('id')->first();
        $auctions = Auction::whereHas('auctionOption', function ($option) use($tournament){
            $option->where('tournament_id', $tournament->id);
        })->with('owner', 'player', 'offers')->orderBy('updated_at', 'desc')->get();

//
//        foreach ($auctions as $auction) {
//            $auction->offers = Offer::with('user')->where('auction_id', $auction->id)->orderBy('created_at', 'desc')->get();
//
////            var_dump($auction['offers'][0]['created_at']);
////            if (Carbon::parse($auction->updated_at)->addMinute(20)->lt(Carbon::now())) {
////                event(new AuctionExpired($auction));
////            }
//        }

		return response()->json($auctions);
    }

    public function store(Request $request, Auction $auction) {
		$data = [];
		$query = Auction::where('player_id', $request->player_id)->where('auction_option_id', $request->auction_option_id)->get();

		if (count($query) == 0) {
			$data = $auction->create($request->all());

			if ($data) {
				UserAuction::create(['user_id' => $data->user_id, 'auction_id' => $data->id]);
			}
			event(new AuctionCreated($data));
		} else {
			$data = array('response' => 'Аукцион уже существует!');
		}
        
        return response()->json($data);
    }

    public function show($id) {
        $auction = Auction::whereId($id)->with('player', 'team')->first();
        $auction->offers = $auction->offers()->with('user', 'team')->orderBy('created_at', 'desc')->get();
        return response()->json($auction);
    }

    public function update(Request $request, Auction $auction) {
        if ($auction->final_cost == 0) {
            $data = $auction->update($request->all());
        }
        return response()->json($data);
    }
}
