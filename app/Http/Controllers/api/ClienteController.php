<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\client_bots;
use App\Models\game_bots;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function check($game,$email)
    {
        $gameid = game_bots::where('name', $game)->first();
        $user = client_bots::where('email', $email)->where('game_id',$gameid)->first();
        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Usuário encontrado',
                'data' => $user
            ], 200);
           
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado',
                'data' => null
            ], 200);
        }
    }
}
