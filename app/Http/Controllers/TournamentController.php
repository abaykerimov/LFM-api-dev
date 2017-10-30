<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    public function index() {
        $data = DB::table('tournaments')->latest('id')->first();
        return response()->json($data);
    }

    public function store(Request $request, Tournament $tournament) {
        $data = $tournament->create($request->all());
        return response()->json($data);
    }
}
