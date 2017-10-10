<?php

namespace App\Http\Controllers;

use App\Models\AuctionsOption;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AuctionOptionController extends Controller
{
	public function index() {
		$option = DB::table('auctions_options')->latest('id')->first();
		return response()->json($option);
	}
	
    public function store(Request $request, AuctionsOption $auctionsOption) {
        $data = $auctionsOption->create($request->all());
        return response()->json($data);
    }
}
