<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\User;
use App\Models\user_games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        foreach($Users as $userKey => $userValue){
            $Users[$userKey]['clientes'] = client_bots::where('id_user', $userValue->id)->count();
            $Users[$userKey]['games'] =  user_games::where('id_user', $userValue->id)->count();
            $Users[$userKey]['webhooks'] =  user_games::where('id_user', $userValue->id)->count();


        }
        return view('users.index', [
            'users' => $Users,
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('users.index');
    }
    public function show(Request $request,$id){
        $usuario  = User::find($id);
        return $usuario;
    }
    public function clientes(Request $request,$id){
        $usuario  = client_bots::where('id_user', $id)->get();
        return $usuario;

    }
    public function webhooks(Request $request,$id){
        $usuario  = User::find($id);
    }
    public function games(Request $request,$id){
        $usuario  = User::find($id);
    }
}
