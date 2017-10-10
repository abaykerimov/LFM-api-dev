<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Offer;
use App\Models\User;
use App\Models\UserAuction;
use Illuminate\Http\Request;

class UserAuctionController extends Controller
{
    public function show($id) {
        $auctions = UserAuction::with('user')->where('user_id', $id)->orderBy('updated_at', 'desc')->get();
        foreach ($auctions as $auction) {
            $auction->auction = Auction::with('owner', 'player')->where('id', $auction->auction_id)->get();

            foreach ($auction->auction as $item) {
                $item->offers = Offer::where('auction_id', $item->id)->orderBy('id', 'desc')->get();
            }
        }
        return response()->json($auctions);
    }

    protected function getBookmark(Request $request) {
        $data = UserAuction::where('user_id', $request->user_id)->where('auction_id', $request->auction_id)->get();
        return response()->json($data);
    }

    public function store(Request $request, UserAuction $auction) {
        $check = UserAuction::where('user_id', $request->user_id)->where('auction_id', $request->auction_id)->get();
        $data= [];
        if (count($check) == 0) {
            $data = $auction->create(['user_id' => $request->user_id, 'auction_id' => $request->auction_id]);
        }
        return response()->json($data, 200);
    }
	
	public function destroy($id) {
        $auction = UserAuction::find($id);
        $data = $auction->delete($id);
        return response()->json($data);
    }
}
