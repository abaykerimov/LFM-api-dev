<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function index() {
        $tournament = DB::table('tournaments')->latest('id')->first();
        $query = Player::where('tournament_id', $tournament->id)->with('team')->orderBy('skill', 'DESC')->get();
        return response()->json($query, 200);
    }

    public function store(Request $request, Player $player) {
        $data = $player->create($request->all());
        return response()->json($data);
    }

    public function update(Request $request, Player $player) {
        $data = $player->update($request->all());
        return response()->json($data);
    }

    public function show(Request $request) {
        $tournament = DB::table('tournaments')->latest('id')->first();
        $keyword = $request->search;
        $query = Player::where('title', 'LIKE', '%'.$keyword.'%')->where('tournament_id', $tournament->id)->with('team')->orderBy('skill', 'DESC')->get()->take(10);
        return response()->json($query, 200);
    }
}
