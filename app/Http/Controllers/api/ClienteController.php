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
        $user = client_bots::where('email', $email)->where('game_id',$gameid->id)->first();
        // dd($gameid);
        // dd($user);
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
    public function checkPerUser($game,$user,$email)
    {
        try {
            $gameid = game_bots::where('name', $game)->first();
            $client = client_bots::where('email', $email)->where('game_id',$gameid->id)->where('user_id',$user)->first();

            // dd($gameid);
            // dd($client);
            if ($client) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Usuário encontrado',
                    'data' => $client
                ], 200);

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Usuário não encontrado',
                    'data' => null
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado',
                'data' => null
            ], 200);
        }

    }
}
