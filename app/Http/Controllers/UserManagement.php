<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\game_bots;
use App\Models\plans;
use App\Models\User;
use App\Models\user_games;
use App\Models\user_webhooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
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
        $gam = [];
        foreach ($games as $gameKey => $gameValue) {
            $game_select[$i] = ['label' => $gameValue->name, 'value' => $gameValue->id];
            $games[$gamekey]['id_game'] = $gameValue->id;
        }
        $plans_select = [];
        $index = 0;
        foreach ($games as $key => $row){
            $game[$key]['id_game'] = $row->id;
        }
        foreach ($plans as $planKey => $planValue) {
            $plans_select[$index] = ['label' => $planValue->description, 'value' => $planValue->id];
            $index++;
        }

        return view('users.index', [
            'users' => $Users,
            'games' => $games,
            'plans' => $plans,
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
    public function editUser(Request $request){

        $request->validate([
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_email' => ['required', 'string', 'email', 'max:255'],
            'edit_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $id = $request->edit_user_id;
        $usuario = User::find($id);

        $usuario->password = Hash::make($request->edit_password);
        $usuario->name = $request->edit_name;
        $usuario->email = $request->edit_email;
        $usuario->save();

        return redirect()->route('users.index');

    }
    public function clientes(Request $request, $id)
    {
        $usuario = DB::table('client_bots')
            ->leftJoin('game_bots', 'client_bots.game_id', '=', 'game_bots.id')
            ->where('id_user', $id)
            ->select('client_bots.*', 'game_bots.name')
            ->get();

        return $usuario;

    }
    public function webhooks(Request $request, $id)
    {
        $usuario = User::find($id);
    }
    public function getGamesofUserNoHave($id)
    {
        $usuario = DB::table('game_bots')
            ->select('game_bots.*')
            ->get();

        return $usuario;
    }
    public function games(Request $request, $id)
    {
        $usuario = self::getUserGames($id);
        return $usuario;
    }
    public static function getUserGames($id)
    {
        $usuario = DB::table('user_games')
            ->leftJoin('game_bots', 'user_games.id_game', '=', 'game_bots.id')
            ->where('id_user', $id)
            ->select('user_games.*', 'game_bots.name')
            ->get();

        return $usuario;
    }
    const STATUS = [
        '0' => 'Inativo',
        '1' => 'Ativo',
    ];
    public function storeGameToUser(Request $request)
    {
        $array = ['error' => ''];
        $request->validate([
            'id_user' => ['required', 'integer'],
            'id_game' => ['required', 'integer'],
        ]);
        // check have cadastrades
        $userGame = user_games::where('id_user', $request->id_user)->where('id_game', $request->id_game)->count();
        if ($userGame > 0) {
            $array['error'] = 'Jogo já cadastrado';
            return $array;
        } else {
            $game = game_bots::where('id', $request->id_game)->first();
            $userGame = new user_games();
            $userGame->id_user = $request->id_user;
            $userGame->id_game = $request->id_game;
            $userGame->url = user_webhooks::URLHOOK . "login/" . $game['name'] . "/" . $request->id_user . "?email=";
            $userGame->status = 1;
            $userGame->created_at = date('Y-m-d H:i:s');
            $userGame->save();

            return $array;
        }

    }
    public function deleteGameToUser(Request $request, $id)
    {
        $array = ['error' => ''];
        $userGame = user_games::find($id);
        $userGame->delete();
        return $array;
    }
    public function getWebHooks($id)
    {
        $usuario = DB::table('user_webhooks')
            ->leftJoin('game_bots', 'user_webhooks.id_game', '=', 'game_bots.id')
            ->leftJoin('users', 'user_webhooks.id_user', '=', 'users.id')
            ->where('id_user', $id)
            ->select('user_webhooks.*', 'game_bots.name as game_name', 'users.name as user_name')
            ->get();

        return $usuario;
    }
    public function deleteWebHook($id)
    {
        $array = ['error' => ''];
        $userWebHook = user_webhooks::find($id);
        $userWebHook->delete();
        return $array;
    }
    public function storeWebHook(Request $request)
    {
        $array = ['error' => ''];
        $request->validate([
            'id_user' => ['required', 'integer'],
            'id_game' => ['required', 'integer'],
            'method' => ['required', 'string']]);
        // check have cadastrades
        if (user_webhooks::where('id_game', $request->id_game)->where('id_user', $request->id_user)->count() > 0) {

            $array['error'] = 'Webhook já cadastrado';
        } else {
            $game = game_bots::where('id', $request->id_game)->get();
            $userWebHook = new user_webhooks();
            $userWebHook->id_user = $request->id_user;
            $userWebHook->id_game = $request->id_game;
            $userWebHook->method = $request->method;
            $userWebHook->url = user_webhooks::URLHOOK . $request->method . "/" . $game[0]['name'] . "/" . $request->id_user;
            $userWebHook->status = 1;
            $userWebHook->created_at = date('Y-m-d H:i:s');
            $userWebHook->save();

            return $array;
        }
    }
    public function desactiveCliente(Request $request, $id)
    {
        $array = ['error' => ''];
        $user = client_bots::find($id);
        $user->status = 0;
        $user->termino = date('Y-m-d H:i:s');
        $user->save();

        //TODO : colocar historico de desativação

        return $array;
    }
    public function activeCliente(Request $request, $id)
    {
        $array = ['error' => ''];

        $user = client_bots::find($id);
        $days = plans::where('id',$user->plano_id)->first()->periodicy;
        $start = Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d');
        $end = Carbon::parse($start)->addDays($days)->format('Y-m-d');
        $user->status = 1;
        $user->inicio = $start;
        $user->data_atv = $start;
        $user->termino =  $end;
        $user->save();


        //TODO : colocar historico de desativação

        return $array;
    }
   

}
