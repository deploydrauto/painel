<?php

namespace App\Http\Controllers;

use App\Models\game_bots;
use App\Models\clients_per_game;
use App\Models\user_games;
use Illuminate\Http\Request;

class GameBotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = ['error' => ''];
        $listGames = game_bots::all();
        foreach($listGames as $gameKey => $gameValue){
            $listGames[$gameKey]['clientes'] = clients_per_game::where('id_game', $gameValue->id)->count();
            $listGames[$gameKey]['admins'] = user_games::where('id_game', $gameValue->id)->count();

        }
        return view('games.index', [
            'games' => $listGames,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if($validated)
        {
            $game = new game_bots();
            $game->name = $request->input('name');
            $game->created_at = now();
            $game->status = 1;
            $game->save();
            return redirect()->route('games.index');
        }else {
            return redirect()->route('games.index', ['error' => 'Dados inválidos']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\game_bots  $game_bots
     * @return \Illuminate\Http\Response
     */
    public function show(game_bots $game_bots)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\game_bots  $game_bots
     * @return \Illuminate\Http\Response
     */
    public function edit(game_bots $game_bots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\game_bots  $game_bots
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, game_bots $game_bots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\game_bots  $game_bots
     * @return \Illuminate\Http\Response
     */
    public function destroy(game_bots $game_bots)
    {
        //
    }
}
