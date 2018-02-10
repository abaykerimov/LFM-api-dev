<?php

namespace App\Http\Controllers;

use App\Models\AuctionsOption;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AuctionOptionController extends Controller
{
	public function index() {
		$option = DB::table('auctions_options')->latest('id')->first();
		return response()->json($option);
	}
	
    public function store(Request $request) {
	    $tournament = DB::table('tournaments')->latest('id')->first();
        $user = User::find($request->user_id);
        $auctionsOption = new AuctionsOption();
        $auctionsOption->started_at = $request->started_at;
        $auctionsOption->turnir_year = $request->turnir_year;
        $auctionsOption->creator()->associate($user);
        $auctionsOption->tournament()->associate($tournament);
        $data = $auctionsOption->save();
        return response()->json($data);
    }
}
