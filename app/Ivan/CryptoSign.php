<?php
namespace App\Ivan;

use Spatie\Crypto\Rsa\PrivateKey;

class CryptoSign 
{
    /**
     * [Description for criptSignature]
     *
     * @param array $vals_ins
     * 
     * $vals_ins = [
     *      'mesecId'=> 'int',
     *      'terminal_sn' => 'string',
     *      'datum_pocetak' => 'Y-m-d',
     *      'datum_kraj' => 'Y-m-d',
     *      'datum_prekoracenja' =>'Y-m-d'];
     *      'naziv_licence' => 'string'
     * 
     * @return string
     * 
     */
    public static function criptSignature($vals_ins)
    {
        
        $string_signature = $vals_ins['naziv_licence'].'-'.$vals_ins['terminal_sn'].'-'.$vals_ins['datum_kraj'].'-'.$vals_ins['datum_prekoracenja'];
        $pathToPrivateKey = base_path().'/storage/app/lickey/lic_private';
        return PrivateKey::fromFile($pathToPrivateKey)->sign($string_signature);
    }

        //$key_path = base_path().'/storage/app/lickey/';
        //(new KeyPair())->generate($key_path."lic_private", $key_path."lic_public");
        //
        /* $terminal = Terminal::where('sn', $snn) -> first();
        $str_to_sign = 'zeta-epos-2023-02-22';
       
        $pathToPrivateKey = base_path().'/storage/app/lickey/lic_private';
        $signature = PrivateKey::fromFile($pathToPrivateKey)->sign($str_to_sign); */

}
