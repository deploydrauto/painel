<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhooksController extends Controller
{
    public function index($method,$game,$iduser, Request $request) {
    
        switch ($method) {
            case 'kiwify':
               self::kiwify($game,$iduser,$request);
                break;
            case 'doppus':
                self::doppus($game,$iduser,$request);

                break;
            case 'braip':
                self::braip($game,$iduser,$request);

                break;
            case 'eduzz':
                self::eduzz($game,$iduser,$request);

                break;
            case 'mercadolivre':
                self::mercadolivre($game,$iduser,$request);

                break;
            case 'paypal':
                self::paypal($game,$iduser,$request);

                break;
            default:
                # code...
                break;
        }
    }
    public static function kiwify($game,$iduser,$request) {

   
        
    }
    public static function doppus($game,$iduser,$request) {

   
        
    }
    public static function braip($game,$iduser,$request) {

   
        
    }
    public static function eduzz($game,$iduser,$request) {
        $trans_status = $request['trans_status'];
        switch ($trans_status) {
            case 'value':
                if(strpos(strtolower($request['product_name']), "mensal") !== false){

                    $plano = 1;

                }else if(strpos(strtolower($request['product_name']), "trimestral") !== false){

                    $plano = 3;

                }else if(strpos(strtolower($request['product_name']), "semestral") !== false){

                    $plano = 6;

                }else if(strpos(strtolower($request['product_name']), "anual") !== false){

                    $plano = 12;

                }else{

                    $plano = 0;

                }
						self::liberaAcesso($game, $iduser, $request);

                break;
            
            default:
                # code...
                break;
        }
   
        
    }
    public static function mercadolivre($game,$iduser,$request) {

   
        
    }
    public static function paypal($game,$iduser,$request) {

   
        
    }
    public static function liberaAcesso($game,$iduser,$request){

    }
}
