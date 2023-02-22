<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Spatie\Crypto\Rsa\PrivateKey;

class LicenceController extends Controller
{
    //
     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $terminal = Terminal::where('sn', 'A26-12RB-1K12746') -> first();
        return response()->json([
            'status' => true,
            'tdata' => $terminal
        ]);
    }
    //
     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($snn)
    {
        //$key_path = base_path().'/storage/app/lickey/';
        //(new KeyPair())->generate($key_path."lic_private", $key_path."lic_public");
        //
        $terminal = Terminal::where('sn', $snn) -> first();
        $str_to_sign = 'zeta-epos-2023-02-22';

        $pathToPrivateKey = base_path().'/storage/app/lickey/lic_private';
        $signature = PrivateKey::fromFile($pathToPrivateKey)->sign($str_to_sign);

        //dd($encryptedData);

        return response()->json([
            'status' => true,
            'signature' => $signature,
            'data'  => $terminal
        ]);
        
        return $encryptedData;
    }
}
