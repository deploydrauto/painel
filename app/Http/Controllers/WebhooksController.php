<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
use App\Models\game_bots;
use App\Models\historico_clientes;
use App\Models\plans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhooksController extends Controller
{
    public function index($method, $game, $iduser, Request $request)
    {
         
        switch ($method) {
            case 'kiwify':
                self::kiwify($game, $iduser, $request);
                break;
            case 'doppus':
                self::doppus($game, $iduser, $request);

                break;
            case 'braip':
                self::braip($game, $iduser, $request);

                break;
            case 'eduzz':
                self::eduzz($game, $iduser, $request);

                break;
            case 'mercadolivre':
                self::mercadolivre($game, $iduser, $request);

                break;
            case 'paypal':
                self::paypal($game, $iduser, $request);

                break;
            case 'hotmart':
                self::hotmart($game, $iduser, $request);

                break;
            default:
                # code...
                break;
        }
    }
    public static function kiwify($game, $iduser, $request)
    {

        $game_id = game_bots::where('name', $game)->first()->id;

        $object = $request;
        $product_name = $object['Product']['product_name'];

        $nome = $object['Customer']['full_name'];

        $numero = $object['Customer']['mobile'];

        $email = $object['Customer']['email'];

        $status = $object['order_status'];

        $subscr = $object['Subscription']['status'];

        $data = $object['approved_date'];

        if ($status == 'paid') { //status ==  2 -> pagamento aprovado

            if (strpos(strtolower($product_name), "mensal") !== false) {

                $plano = 1;

            } else if (strpos(strtolower($product_name), "trimestral") !== false) {

                $plano = 3;

            } else if (strpos(strtolower($product_name), "semestral") !== false) {

                $plano = 6;

            } else if (strpos(strtolower($product_name), "anual") !== false) {

                $plano = 12;

            } else {

                $plano = 0;

            }

            $plano = plans::where('value', $plano)->first();

            DB::beginTransaction();
            try {
                $client = new client_bots();
                $client->nome = $nome;
                $client->telefone = $numero;
                $client->email = $email;
                $client->id_user = $iduser;
                $client->plano_id = $plano->id;
                $client->game_id = $game_id;
                $client->meio = 'braip';

                self::liberaAcesso($client, $plano->periodicy);
                DB::commit();
            } catch (\Throwable$th) {
                DB::rollBack();
            }

            // }else if($status == 3){//stautos de pagamento cancelado

            //     remove_acesso($pdo, $email);

        } else if ($status == 'refunded') { //chargeback

            self::removeAcesso($game_id, $iduser, $email);

        } else if ($subscr == 'waiting_payment') {

            self::removeAcesso($game_id, $iduser, $email);

        }
    }
    public static function doppus($game, $iduser, $request)
    {

    }
    public static function braip($game, $iduser, $request)
    {
        $game_id = game_bots::where('name', $game)->first()->id;

        $obj = $request;
        $product_name = $obj['product_name'];

        $nome = $obj['client_name'];

        $numero = $obj['client_cel'];

        $email = $obj['client_email'];

        $status = $obj['trans_status_code'];

        $data = $obj['trans_payment_date'];

        if ($status == 2) { //status ==  2 -> pagamento aprovado

            if (strpos(strtolower($product_name), "mensal") !== false) {

                $plano = 1;

            } else if (strpos(strtolower($product_name), "trimestral") !== false) {

                $plano = 3;

            } else if (strpos(strtolower($product_name), "semestral") !== false) {

                $plano = 6;

            } else if (strpos(strtolower($product_name), "anual") !== false) {

                $plano = 12;

            } else {

                $plano = 0;

            }

            $plano = plans::where('value', $plano)->first();

            DB::beginTransaction();
            try {
                $client = new client_bots();
                $client->nome = $nome;
                $client->telefone = $numero;
                $client->email = $email;
                $client->id_user = $iduser;
                $client->plano_id = $plano->id;
                $client->game_id = $game_id;
                $client->meio = 'braip';

                self::liberaAcesso($client, $plano->periodicy);
                DB::commit();
            } catch (\Throwable$th) {
                DB::rollBack();
            }

        } else if ($status == 3) { //stautos de pagamento cancelado

            self::removeAcesso($game_id, $iduser, $email);

        } else if ($status == 4) { //chargeback

            self::removeAcesso($game_id, $iduser, $email);

        } else if ($status == 5) {

            self::removeAcesso($game_id, $iduser, $email);

        }
    }
    public static function eduzz($game, $iduser, $request)
    {
        $game_id = game_bots::where('name', $game)->first()->id;

        $trans_status = $request['trans_status'];
        switch ($trans_status) {
            case '3':
                if (strpos(strtolower($request['product_name']), "mensal") !== false) {

                    $plano = 1;

                } else if (strpos(strtolower($request['product_name']), "trimestral") !== false) {

                    $plano = 3;

                } else if (strpos(strtolower($request['product_name']), "semestral") !== false) {

                    $plano = 6;

                } else if (strpos(strtolower($request['product_name']), "anual") !== false) {

                    $plano = 12;

                } else {

                    $plano = 0;

                }
                $plano = plans::where('value', $plano)->first();

                DB::beginTransaction();
                try {
                    $client = new client_bots();
                    $client->nome = $request['cus_name'];
                    $client->telefone = $request['cus_cel'];
                    $client->email = $request['cus_email'];
                    $client->id_user = $iduser;
                    $client->plano_id = $plano->id;
                    $client->game_id = $game_id;
                    $client->meio = 'eduzz';

                    self::liberaAcesso($client, $plano->periodicy);
                    DB::commit();
                } catch (\Throwable$th) {
                    DB::rollBack();
                }

                break;
            case '6':

                break;
            case '7':

                break;
            default:
                # code...
                break;
        }

    }
    public static function mercadolivre($game, $iduser, $request)
    {

    }
    public static function paypal($game, $iduser, $request)
    {

    }
    public static function hotmart($game, $iduser, $request)
    {

    }
    public static function liberaAcesso(client_bots $client_bots, $dias)
    {
        $exist  = client_bots::where('email', $client_bots->email)->where('game_id', $client_bots->game_id)->where('id_user', $client_bots->id_user);
        // carbon add $dias to $client_bot->termino
        $client_bots->status = 1;
        $client_bots->data_atv = date('Y-m-d H:i:s');
        $client_bots->inicio = date('Y-m-d H:i:s');
        $client_bots->termino = date('Y-m-d H:i:s', strtotime("+$dias days"));
        $client_bots->created_at = date('Y-m-d H:i:s');
        $client_bots->updated_at = date('Y-m-d H:i:s');
        $client_bots->remain = $dias;
        if($exist->count() > 0 ){
                    $client = find($exist->first()->id);
                    $client->status = 1;
                    $client->data_atv = date('Y-m-d H:i:s');
                    $client->inicio = date('Y-m-d H:i:s');
                    $client->termino = date('Y-m-d H:i:s', strtotime("+$dias days"));
                    $client->created_at = date('Y-m-d H:i:s');
                    $client->updated_at = date('Y-m-d H:i:s');
                    $client->remain = $dias;
            client_bots->save();
            
        }else {
             $client_bots->save();
        }
       
        //TODO : Salvar no historico do usuario

    }
    public static function removeAcesso($game_id, $iduser, $email)
    {
        // add to historico
        $historico = new historico_clientes();
        $historico->info = $email;
        $historico->plano_id = 0;
        $historico->inicio = date('Y-m-d H:i:s');
        $historico->termino = date('Y-m-d H:i:s');
        $historico->created_at = date('Y-m-d H:i:s');
        $historico->updated_at = date('Y-m-d H:i:s');
        $historico->save();
         

        $client = client_bots::where('email', $email)->where('game_id', $game_id)->where('id_user', $iduser)->first();
        $client->status = 0;
        $client->remain = 0;
        $client->save();


        //TODO: Salvar em um historico do usuario
    }
}
