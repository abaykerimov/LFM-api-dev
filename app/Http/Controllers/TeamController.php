<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TeamController extends Controller
{
    public function index(Request $request, Team $team) {
        $keyword = $request->search;
        $query = $team->where('title', 'LIKE', '%'.$keyword.'%')->orderBy('title', 'ASC')->get()->take(10);
        return response()->json($query, 200);
    }
}
