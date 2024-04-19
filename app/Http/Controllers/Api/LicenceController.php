<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

//use App\Models\Terminal;
use App\Models\LicencaParametar;
use App\Models\LicenceZaTerminal;
use App\Models\LicencaParametarTerminal;
use App\Models\LicencaDistributerTerminal;

use Illuminate\Http\Request;
//use Spatie\Crypto\Rsa\PrivateKey;

class LicenceController extends Controller
{

    public $terminal_data;
    //
     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json([
            'status' => false,
            'data' => []
        ]);
    }
    //
     /**
     * Display the specified resource.
     * https://servis.epos.rs/api/licenca/A26-12RB-1K12746
     * localhost/api/licenca/A26-12RB-1K12746
     *
     * @return \Illuminate\Http\Response
     */
    public function show($snn)
    {
       // 'licence_za_terminals.mesecId',
 
        $this->terminal_data = [];

        $str_snn = strval( $snn );

        $termina_licence = LicenceZaTerminal::select(
                            'licence_za_terminals.terminal_lokacijaId',
                            'licence_za_terminals.distributerId',
                            'licence_za_terminals.licenca_distributer_cenaId',
                            'licence_za_terminals.naziv_licence',
                            'licence_za_terminals.terminal_sn',
                            'licence_za_terminals.datum_kraj',
                            'licence_za_terminals.datum_prekoracenja',
                            'licence_za_terminals.signature',
                            'licenca_tips.id as ltid'
                        )
                        ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_cenas.id', '=', 'licence_za_terminals.licenca_distributer_cenaId')
                        ->leftJoin('licenca_tips', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
                        ->where('licence_za_terminals.terminal_sn', '=', $str_snn)
                        ->get();
        $retval = [
            'status' => true, 
            'data' => []
        ];
       
        //dd($termina_licence);
        if(count($termina_licence)){
            $termina_licence->each(function ($item, $key){
                $each_data = [
                    'licenca'   => $item->naziv_licence,
                    'sn'        => $item->terminal_sn,
                    'datum_kraj'=> $item->datum_kraj,
                    'datum_prekoracenja' => $item->datum_prekoracenja,
                    'signature' => $item->signature,
                    'parametars' =>[]
                ];
                
                //$item->parametars = [];
                //da li licenca uopste ima parametre_
                if(LicencaParametar::where('id', '=', $item->ltid)->first()) {
                    //da li licenca koju trazimo ima parametre
                    $each_data['parametars'] = LicencaParametarTerminal::where('licenca_parametar_terminals.terminal_lokacijaId', '=', $item->terminal_lokacijaId)
                        ->where('licenca_parametar_terminals.distributerId', '=', $item->distributerId)
                        ->where('licenca_parametar_terminals.licenca_distributer_cenaId', '=', $item->licenca_distributer_cenaId)
                        ->leftJoin('licenca_parametars', 'licenca_parametars.id', '=', 'licenca_parametar_terminals.licenca_parametarId')
                        ->pluck('licenca_parametars.param_opis')
                        ->all();


                    /* $licenca_distibuter_terminal_row = LicencaDistributerTerminal::where('terminal_lokacijaId', '=', $item->terminal_lokacijaId)
                                                        ->where('licenca_distributer_cenaId', '=', $item->licenca_distributer_cenaId)
                                                        ->first();
                    if(isset($licenca_distibuter_terminal_row->id)){
                        $each_data['parametars'] = LicencaParametarTerminal::where('licenca_parametar_terminals.licenca_distributer_terminalId', '=', $licenca_distibuter_terminal_row->id)
                                                        ->leftJoin('licenca_parametars', 'licenca_parametars.id', '=', 'licenca_parametar_terminals.licenca_parametarId')
                                                        ->pluck('licenca_parametars.param_opis')
                                                        ->all();
                    } */
                }           

                array_push($this->terminal_data, $each_data);
            }); 
            //dd($this->terminal_data);
            $retval['data'] = $this->terminal_data;
        }else{
            $retval['status'] = false;
            $retval['data'] = [];
        }
        return response()->json($retval);
    }
}
