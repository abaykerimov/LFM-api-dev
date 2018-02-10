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
		$auctions = Auction::whereHas('auctionOption', function ($option){
            $option->where('tournament_id', 2);
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
		$query = Auction::where('player_id', $request->player_id)->where('auction_option_id', $request->auctions_option_id)->get();

		if (count($query) == 0) {
            $auction = new Auction();
            $auction->description = $request->description;
            $auction->player_id = $request->player_id;
            $auction->team_id = $request->team_id;
            $auction->auction_option_id = $request->auctions_option_id;
            $auction->initial_cost = $request->initial_cost;
            $auction->user_id = $request->user_id;
            $auction->save();
			//$data = $auction->create($request->all());

			if ($auction) {
				UserAuction::create(['user_id' => $auction->user_id, 'auction_id' => $auction->id]);
			}
			event(new AuctionCreated($auction));
		} else {
			$data = array('response' => 'Аукцион уже существует!');
		}
        
        return response()->json($data);
    }

    public function show(Auction $auction) {
        //$item = Auction::findOrFail($id)->get();
        $auction->offers = $auction->offers()->get();
		$auction->player = Auction::whereId($auction->player)->get();
        $auction->team = Auction::whereId($auction->team)->get();
        return response()->json($auction);
    }

    public function update(Request $request, Auction $auction) {
        if ($auction->final_cost == 0) {
            $data = $auction->update($request->all());
        }
        return response()->json($data);
    }
}
