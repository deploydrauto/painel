<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\game_bots;
use App\Models\plans;
use App\Models\User;
use App\Models\user_games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = ['error' => ''];
        $Users = User::all();
        $games = game_bots::all();
        $plans = plans::all();

        foreach ($Users as $userKey => $userValue) {
            $Users[$userKey]['clientes'] = client_bots::where('id_user', $userValue->id)->count();
            $Users[$userKey]['games'] = user_games::where('id_user', $userValue->id)->count();
            $Users[$userKey]['webhooks'] = user_games::where('id_user', $userValue->id)->count();

        }
        $game_select = [];
        $i = 0;

        foreach ($games as $gameKey => $gameValue) {
            $game_select[$i] =  [ 'label' => $gameValue->name , 'value' => $gameValue->id ] ;
            $i++;
        }
        $plans_select = [];
        $index = 0;

        foreach ($plans as $planKey => $planValue) {
            $plans_select[$index] =  [ 'label' => $planValue->description , 'value' => $planValue->id ] ;
            $index++;
        }

        return view('users.index', [
            'users' => $Users,
            'games' => $game_select,
            'plans' => $plans_select
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('users.index');
    }
    public function show(Request $request, $id)
    {
        $usuario = User::find($id);
        return $usuario;
    }
    public function clientes(Request $request, $id)
    {
        $usuario = DB::table('client_bots')
            ->leftJoin('game_bots', 'client_bots.game_id', '=', 'game_bots.id')
            ->where('id_user', $id)
            ->select('client_bots.*', 'game_bots.name' )
            ->get();

        return $usuario;

    }
    public function webhooks(Request $request, $id)
    {
        $usuario = User::find($id);
    }
    public function games(Request $request, $id)
    {
        $usuario = User::find($id);
    }
}
