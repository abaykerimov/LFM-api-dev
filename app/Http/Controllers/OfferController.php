<?php

namespace App\Http\Controllers;

use App\Events\OfferCreated;
use App\Models\Offer;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class OfferController extends Controller
{
	public function show($id) {
        $offers = Offer::with('team', 'user')->where('auction_id', $id)->orderBy('created_at', 'desc')->get();
//		foreach($offers as $offer) {
//			$offer->team = Offer::whereId($offer->team)->get();
//			$offer->user = Offer::whereId($offer->user)->get();
//
//		}
        return response()->json($offers);
    }
	
    public function store(Request $request, Offer $offer) {
        $data = $offer->create($request->all());
//        $data->auction = Auction::whereId($data->auction)->get();
        event(new OfferCreated($data));
        return response()->json($data);
    }
}
