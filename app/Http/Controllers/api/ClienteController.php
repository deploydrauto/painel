<?php
namespace App\Http\Controllers\api;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json');

use App\Http\Controllers\Controller;
use App\Models\client_bots;
use App\Models\game_bots;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function check(Request $request,$game,$email)
    {
        $mail = $request->query('email');
        if($mail){
            $email = $mail;
        }
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
    public function check2(Request $request,$game)
    {
        try {
            $mail = $request->query('email');
            if($mail){
                $email = $mail;
            }
            $gameid = game_bots::where('name', $game)->first();
            $user = client_bots::where('email', $email)->where('game_id',$gameid->id)->where('status',1)->first();
            // dd($gameid);
            // dd($user);
            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Usuário encontrado',
                    'data' => $user['remain']
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
                'data' => $th
            ], 200);
        }

    }
    public function checkPerUser($game,$user,$email)
    {
        try {
            $gameid = game_bots::where('name', $game)->first();
            $client = client_bots::where('email', $email)->where('game_id',$gameid->id)->where('id_user',$user)->first();

            // dd($gameid);
            // dd($client);
            if ($client) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Usuário encontrado',
                    'data' => $client['remain']
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
                'data' => $th
            ], 200);
        }

    }
}
