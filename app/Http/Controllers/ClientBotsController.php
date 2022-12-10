<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\historico_clientes;
use App\Models\plans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientBotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = ['error' => ''];
        $clients = client_bots::all();
        return view('clientes.index', [
            'clientes' => $clients,
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
    const ATIVO = 1;
    const MEIO_PAINEL = 'painel';

    public function store(Request $request)
    {
         $newclient = $request->all();
        // return $newclient;
            $days = plans::where('id',$newclient['body']['id_plan'])->first()->periodicy;
            $start = Carbon::parse($newclient['body']['client_inicio']);
            $end = substr($start->addDays($days),0,10) ;

            $cliente = new client_bots();
            $cliente->nome = $newclient['body']['nome'];
            $cliente->email = $newclient['body']['email'];
            $cliente->telefone = $newclient['body']['telefone'];
            $cliente->status = self::ATIVO;
            $cliente->meio = self::MEIO_PAINEL;

            $cliente->id_user = $newclient['body']['id_user'];
            $cliente->inicio = $newclient['body']['client_inicio'];
            $cliente->termino = $end;
            $cliente->remain = $days;

            $cliente->data_atv = $newclient['body']['client_inicio'];
            $cliente->game_id = $newclient['body']['id_game'];
            $cliente->plano_id = $newclient['body']['id_plan'];
            $cliente->save();


            $historico = new historico_clientes();
            $historico->client_id = $cliente->id;
            $historico->plano_id = $newclient['body']['id_plan'];
            $historico->user_id = $newclient['body']['id_user'];
            $historico->periodo = $days;
            $historico->metodo = self::MEIO_PAINEL;
            $historico->inicio = $newclient['body']['client_inicio'];
            $historico->termino = $end;
            $historico->save();

        return client_bots::where('id_user',$newclient['body']['id_user'])->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client_bots  $client_bots
     * @return \Illuminate\Http\Response
     */
    public function show(client_bots $client_bots)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\client_bots  $client_bots
     * @return \Illuminate\Http\Response
     */
    public function edit(client_bots $client_bots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client_bots  $client_bots
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client_bots $client_bots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client_bots  $client_bots
     * @return \Illuminate\Http\Response
     */
    public function destroy(client_bots $client_bots)
    {
        //
    }
}
