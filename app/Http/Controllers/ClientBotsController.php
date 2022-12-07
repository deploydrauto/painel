<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
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
    public function store(Request $request)
    {
        //
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
