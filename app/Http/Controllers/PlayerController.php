<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PlayerController extends Controller
{
    public function index(Request $request, Player $player) {
        $keyword = $request->search;
        $query = $player->where('title', 'LIKE', '%'.$keyword.'%')->where('tournament_id', $this->tournament->id)->with('team')->orderBy('skill', 'DESC')->get()->take(10);
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
}
