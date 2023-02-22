<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Crypto\Rsa\PublicKey;

class ApiDataController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
     public function index()
     {
         //$response = Http::get('https://servis.epos.rs/api/licenca/A26-12RB-1K12746');
         $response = Http::get('http://localhost/api/licenca/A26-12RB-1K12658');
         $pathToPublicKey = base_path().'/storage/app/lickey/lic_public';
         $publicKey = PublicKey::fromFile($pathToPublicKey);

         $apiData = json_decode($request->getContent(), true);

         //$decryptedData = $publicKey->decrypt($response);

        //$jsonData = $response->json();
         dd($apiData);
 
     }
}
