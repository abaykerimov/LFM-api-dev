<?php

namespace App\Http\Controllers;

use App\Models\UserReply;
use Illuminate\Http\Request;

class UserReplyController extends Controller
{
    public function store(Request $request, UserReply $userReply) {
        $data = $userReply->create($request->all());
        return response()->json($data);
    }
}
