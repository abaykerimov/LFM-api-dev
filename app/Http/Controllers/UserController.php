<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request, User $user) {
        $find = User::find($request->id);

        if (count($find) == 0) {
            $user->create($request->only(['id', 'photo_200', 'first_name', 'last_name']));
        }
        return response()->json($user);
    }
	
	public function show($id) {
		$user = User::find($id);		
        return response()->json($user);
    }
}
