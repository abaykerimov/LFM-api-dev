<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Offer;
use App\Models\UserAuction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    public function index() {
		$auctions = Auction::with('owner', 'player')->orderBy('updated_at', 'desc')->get();
        foreach ($auctions as $auction) {
            $auction->offers = Offer::with('user')->where('auction_id', $auction->id)->orderBy('created_at', 'desc')->get();
        }
		return response()->json($auctions);
    }

    public function store(Request $request, Auction $auction) {
        $data = $auction->create($request->all());
        if ($data) {
            UserAuction::create(['user_id' => $data->user_id, 'auction_id' => $data->id]);
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
        $data = $auction->update($request->all());
        return response()->json($data);
    }
}
