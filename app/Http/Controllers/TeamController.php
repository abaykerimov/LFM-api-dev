<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index(Request $request, Team $team) {
        $keyword = $request->search;
        $query = $team->where('title', 'LIKE', '%'.$keyword.'%')->orderBy('title', 'ASC')->get()->take(10);
        return response()->json($query, 200);
    }

    public function store(Request $request, Team $team) {
        $data = $team->create($request->all());
        return response()->json($data);
    }

    public function update(Request $request, Team $team) {
        $data = $team->update($request->all());
        return response()->json($data);
    }

    public function show($user_id) {
        $tournament = DB::table('tournaments')->latest('id')->first();
        $teams = User::find($user_id)->teams;
        $filterTeam = $teams->where('pivot.tournament_id', $tournament->id);
        $data = [];
        foreach($filterTeam as $team) {
            $players = $team->players();
            $filterPlayers = $players->where('tournament_id', $tournament->id);
            $team->players = $filterPlayers->get();
            $data[] = $team;
        }
        return response()->json($data);
    }
}
