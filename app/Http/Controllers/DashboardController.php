<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\game_bots;
use App\Models\plans;
use App\Models\User;
use App\Models\user_games;
use App\Http\Controllers\UserManagement as UserManagement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){

        // get

        // get id of loged user
        $user = auth()->user()->id;
        $array = ['error' => ''];
        $Users = User::where('id', $user)->get();
        $games = UserManagement::getUserGames($user);
        $plans = plans::all();

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
            $game_select[$i] = ['label' => $gameValue->name, 'value' => $gameValue->id];
            $i++;
        }
        $plans_select = [];
        $index = 0;

        foreach ($plans as $planKey => $planValue) {
            $plans_select[$index] = ['label' => $planValue->description, 'value' => $planValue->id];
            $index++;
        }

        return view('users.dashboard' ,  [
            'users' => $Users,
            'games' => $game_select,
            'plans' => $plans_select,
        ]);
    }
}
