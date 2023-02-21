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
        $pathToPrivateKey = base_path().'/storage/app/lickey/lic_private';
        //(new KeyPair())->generate($key_path."lic_private", $key_path."lic_public");
        //
        $terminal = Terminal::where('sn', $snn) -> first();
        $cdata = json_encode([  'status' => true,
                                'tdata' => $terminal ]);

        $privateKey = PrivateKey::fromFile($pathToPrivateKey);
        $encryptedData = $privateKey->encrypt($cdata);

        //dd($encryptedData);

        /* return response()->json([
            'status' => true,
            'data'  => "'".$encryptedData."'"
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE); */
        
        return $encryptedData;
    }
}
