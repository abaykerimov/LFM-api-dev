<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        $user  = User::find($user_id);
        $team = $user->teams();
        dd($team);
        $teams = User::find($user_id)->teams();
        return response()->json($teams);
    }
}
