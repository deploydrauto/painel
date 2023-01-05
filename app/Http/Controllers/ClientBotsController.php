<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\client_bots_trash;
use App\Models\historico_clientes;
use App\Models\plans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientBotsController extends Controller
{
    const TESTES_ID = 5;

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
        if ($newclient['body']['id_plan'] == self::TESTES_ID) {
            $days = $newclient['body']['testedays'];
        } else {
            $days = plans::where('id', $newclient['body']['id_plan'])->first()->periodicy;
        }

        $date = str_replace('/', '-', $newclient['body']['client_inicio']);
        $newDate = date('Y-m-d', strtotime($date));

        $start = Carbon::parse($newDate)->format('Y-m-d');

        // add days to start date copilot start fi
        $end = Carbon::parse($start)->addDays($days)->format('Y-m-d');

        // $end = substr($start->addDays($days),0,10) ;

        $cliente = new client_bots();
        $cliente->nome = $newclient['body']['nome'];
        $cliente->email = $newclient['body']['email'];
        $cliente->telefone = $newclient['body']['telefone'];
        $cliente->status = self::ATIVO;
        $cliente->meio = self::MEIO_PAINEL;

        $cliente->id_user = $newclient['body']['id_user'];
        $cliente->inicio = $start;
        $cliente->termino = $end;
        $cliente->remain = $days;

        $cliente->data_atv = $start;
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

        return client_bots::where('id_user', $newclient['body']['id_user'])->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client_bots  $client_bots
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $array = ['error' => ''];
        $cliente = client_bots::where('id', $id)->first();
        return $cliente;
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
    public function delete(Request $request, $id)
    {
        $soft = client_bots::find($id);
        $store = new client_bots_trash();
        $store->real_id = $soft->id;
        $store->nome = $soft->nome;
        $store->email = $soft->email;
        $store->telefone = $soft->telefone;
        $store->status = $soft->status;
        $store->meio = $soft->meio;
        $store->id_user = $soft->id_user;
        $store->inicio = $soft->inicio;
        $store->termino = $soft->termino;
        $store->remain = $soft->remain;
        $store->data_atv = $soft->data_atv;
        $store->game_id = $soft->game_id;
        $store->plano_id = $soft->plano_id;
        $store->deleted_by = $request->user()->id;
        $store->deleted_at = Carbon::now();
        $store->save();

        $soft->delete();

        return ['error' => '', 'result' => 'Cliente deletado com sucesso'];
    }
    public function editClient(Request $request)
    {
        $newclient = $request->all();

        if ($newclient['body']['id_plan'] == self::TESTES_ID) {
            $days = $newclient['body']['testedays'];
        } else {
            $days = plans::where('id', $newclient['body']['id_plan'])->first()->periodicy;
        }

        $id = $newclient['body']['id'];
        $date = str_replace('/', '-', $newclient['body']['client_inicio']);
        $newDate = date('Y-m-d', strtotime($date));

        $start = Carbon::parse($newDate)->format('Y-m-d');

        // add days to start date copilot start fi
        $end = Carbon::parse($start)->addDays($days)->format('Y-m-d');

        $cliente = client_bots::find($id);
        $cliente->nome = $newclient['body']['nome'];
        $cliente->email = $newclient['body']['email'];
        $cliente->telefone = $newclient['body']['telefone'];
        $cliente->status = self::ATIVO;
        $cliente->meio = self::MEIO_PAINEL;

        $cliente->id_user = $newclient['body']['id_user'];
        $cliente->inicio = $start;
        $cliente->termino = $end;
        $cliente->remain = $days;

        $cliente->data_atv = $start;
        $cliente->game_id = $newclient['body']['id_game'];
        $cliente->plano_id = $newclient['body']['id_plan'];
        $cliente->save();

        $historico = new historico_clientes();
        $historico->client_id = $id;
        $historico->plano_id = $newclient['body']['id_plan'];
        $historico->user_id = $newclient['body']['id_user'];
        $historico->periodo = $days;
        $historico->metodo = self::MEIO_PAINEL;
        $historico->inicio = $newclient['body']['client_inicio'];
        $historico->termino = $end;
        $historico->save();

        return ['error' => '', 'result' => 'Cliente editado com sucesso'];
    }
}
