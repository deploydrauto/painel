<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\game_bots;
use App\Models\plans;
use App\Models\User;
use App\Models\user_games;
use App\Http\Controllers\UserManagement as UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as auth;

class DashboardController extends Controller
{
    public function get_meus_clientes(Request $request,$id) {
        if( auth()->user()->id == $id) {
            $user = auth()->user()->id;
            $array = ['error' => ''];
            $Users = User::where('id', $user)->get();
            $games = UserManagement::getUserGames($user);
            $plans = plans::all();
            $graphic_label = [];
            $grapnic_value = [];
            $grapnic_value_ative = [];
            $grapnic_value_inative = [];

            foreach ($Users as $userKey => $userValue) {
                $Users[$userKey]['clientes'] = client_bots::where('id_user', $user)->count();
                $Users[$userKey]['ativos'] = client_bots::where('id_user', $user)->where('status','=','1')->count();
                $Users[$userKey]['inativos'] = client_bots::where('id_user', $user)->where('status','=','0')->count();
                $Users[$userKey]['games'] = user_games::where('id_user', $user)->count();
                $Users[$userKey]['webhooks'] = user_games::where('id_user', $user)->count();

            }

            $game_select = [];

            $i = 0;

            foreach ($games as $gameKey => $gameValue) {
                $game_select[$i] = ['label' => $gameValue->name, 'value' => $gameValue->id_game];
                $user_in_game = client_bots::where('id_user', $user)->where('game_id', $gameValue->id_game)->count();
                $user_active_in_game = client_bots::where('id_user', $user)->where('game_id', $gameValue->id_game)->where('status', '1')->count();
                $user_inative_in_game = client_bots::where('id_user', $user)->where('game_id', $gameValue->id_game)->where('status', '0')->count();

                array_push($graphic_label, $gameValue->name);
                array_push($grapnic_value_ative, $user_active_in_game);
                array_push($grapnic_value_inative,  $user_inative_in_game);
                array_push($grapnic_value, $user_in_game);
                $i++;
            }
            $plans_select = [];
            $index = 0;

            foreach ($plans as $planKey => $planValue) {
                $plans_select[$index] = ['label' => $planValue->description, 'value' => $planValue->id];
                $index++;
            }

            $array['users'] = $Users;
            $array['games'] = $game_select;
            $array['plans'] = $plans_select;
            $array['graphic_label'] = $graphic_label;
            $array['grapnic_value'] = $grapnic_value;
            $array['grapnic_value_ative'] = $grapnic_value_ative;
            $array['grapnic_value_inative'] = $grapnic_value_inative;
        }
        else {
            $array = ['error' => 'Você não tem permissão para acessar essa página!'];
        }


        return $array;
    }
    public function index(Request $request){




        return view('dashboard' ,  [
            'user' => auth()->user(),


        ]);
    }
}
