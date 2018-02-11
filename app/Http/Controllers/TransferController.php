<?php

namespace App\Http\Controllers;

use App\Events\TransferCreated;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index() {
        $tournament = DB::table('tournaments')->latest('id')->first();
        $transfers = Transfer::whereHas('auctionOption', function ($option) use($tournament){
            $option->where('tournament_id', $tournament->id);
        })->with('user', 'player', 'team')->orderBy('created_at', 'desc')->get();

        return response()->json($transfers);
    }

    public function store(Request $request, Transfer $transfer) {
        $data = [];
        $query = Transfer::where('player_id', $request->player_id)->where('auction_option_id', $request->auction_option_id)->get();

        if (count($query) == 0) {
            $data = $transfer->create($request->all());

            event(new TransferCreated($data));
        } else {
            $data = array('response' => 'Трансфер уже существует!');
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
