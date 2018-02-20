<?php

namespace App\Http\Controllers;

use App\Events\TransferCreated;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index(Request $request) {
        $tournament = DB::table('tournaments')->latest('id')->first();
        $transfers = Transfer::whereHas('auctionOption', function ($option) use($tournament){
            $option->where('tournament_id', $tournament->id);
        })->with('user', 'player', 'team', 'player.team')->orderBy('created_at', 'desc');

        $user_id = $request->user;
        if ($request->has('user') && !$request->has('is_request')) {
            $transfers->where('user_id', $user_id);
        }

        if ($request->has('user') && $request->has('is_request')) {
            $transfers->whereHas('player.team.user', function($user) use($user_id) {
                $user->where('user_id', $user_id);
            })->whereNull('transfer_id')->doesntHave('children');
        }

        if (!$request->has('user') && !$request->has('is_request')) {
            $transfers->whereNull('transfer_id')->has('children')->where('status', 'accepted');
        }
        return response()->json($transfers->get());
    }

    public function store(Request $request, Transfer $transfer) {
        $data = $query = [];
        if (!$request->transfer_id){
            $query = Transfer::where('player_id', $request->player_id)->where('auction_option_id', $request->auction_option_id)->get();
        }

        if (count($query) == 0) {
            $data = $transfer->create($request->only(['transfer_id', 'player_id', 'team_id', 'cost', 'transfer_type', 'loan_cost', 'loan_type', 'user_id', 'description', 'auction_option_id', 'status']));

            if ($data && $request->has('transfer_id')) {
                $data->parent()->update(['status' => $request->status]);
            }
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
