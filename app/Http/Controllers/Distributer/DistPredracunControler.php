<?php

namespace App\Http\Controllers\Distributer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Helpers;

use App\Models\LicencaNaplata;
use App\Models\TerminalLokacija;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerTerminal;

use PDF;
use Response;

class DistPredracunControler extends Controller
{

    //
    public $terminal_lokacija_id;
    public $licenca_distributer_terminal_id;
    public $did;
    public $vrsta;

    public $lic_naplata_row;
    public $lokacija_row;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //poziv stranice bez get varijabli
        if(request()->query('ldtid') == null || request()->query('tip') == null){
            abort(403, 'Unauthorized action 203.');
        }
        if(!in_array(request()->query('tip'), ['p', 'r'])){
            abort(403, 'Unauthorized action 204.');
        }

        $this->vrsta = $this->vrstaDokumenta(request()->query('tip'));
        
        $this->did = LicencaDistributerTip::distributerIdByUserId(auth()->user()->id);
        $distributerrow = LicencaDistributerTip::where('id', '=', $this->did)->first();

        
        $this->licenca_distributer_terminal_id = request()->query('ldtid');
        $licenca_distributer_terminal_row = LicencaDistributerTerminal::where('id', '=', $this->licenca_distributer_terminal_id)->first();

        $this->terminal_lokacija_id = $licenca_distributer_terminal_row->terminal_lokacijaId;

        //provera dali du get vars autenticne
        $this->lic_naplata_row = LicencaNaplata::where('licenca_dist_terminalId', '=', $this->licenca_distributer_terminal_id)
                        ->where('distributerId', '=', $this->did)
                        ->first();
        
        $this->lokacija_row = TerminalLokacija::select('lokacijas.*', 'terminals.sn')
                        ->leftJoin('lokacijas', 'lokacijas.id', '=','terminal_lokacijas.lokacijaId')
                        ->leftJoin('terminals', 'terminals.id', '=', 'terminal_lokacijas.terminalId')
                        ->where('terminal_lokacijas.id', '=', $this->terminal_lokacija_id)
                        ->where('terminal_lokacijas.distributerId', '=', $this->did)
                        ->first();

        $naziv_lic = LicencaDistributerCena::select('licenca_tips.licenca_naziv')
                            ->leftJoin('licenca_tips', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
                            ->where('licenca_distributer_cenas.id', '=', $this->lic_naplata_row->licenca_distributer_cenaId)
                            ->first();
                            //->licenca_naziv;
        
        $this->lic_naplata_row->naziv_licence = $naziv_lic->licenca_naziv;
                                                                    
        if(!isset($this->lic_naplata_row->dist_zaduzeno) || !isset($this->lokacija_row->l_naziv)){
            abort(403, 'Unauthorized action 204.');
        }

        $dospece_date = Helpers::addDaysToDate(Helpers::firstDayOfMounth(Helpers::addMonthsToDate($this->lic_naplata_row->dist_datum_zaduzenja, 1)), $distributerrow->dani_prekoracenja_licence);
        $poziv_na_broj = $this->lic_naplata_row->id;
        $broj_racuna =  Helpers::yearNumber($this->lic_naplata_row->dist_datum_zaduzenja).' / '.$poziv_na_broj;
        
        $distributerrow->datum_dospeca = Helpers::datumFormatDanFullYear($dospece_date);
        $distributerrow->poziv_na_broj = $poziv_na_broj;
        $distributerrow->broj_racuna = $broj_racuna;

        $distributerrow->datum_placanja = Helpers::datumFormatDanFullYear($distributerrow->dist_datum_razduzenja);

        //******************  CUVANJE PDF FAJLA    */
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf ->loadView('pdf/distPredracunPdf', ['distributerrow' => $distributerrow, 'lokacija_row' => $this->lokacija_row, 'naplata_row' => $this->lic_naplata_row, 'doc_vrsta' => $this->vrsta]); 
 
        return $pdf->stream('predracun.pdf');
    }

    private function vrstaDokumenta($tip)
    {
        $p = ($tip=='p') ? true : false;
        $retval = new class{};
        $retval->tip = $tip;
        $retval->naslov = ($p) ? 'Predračun':'Račun';
        $retval->placanje = ($p) ? 'Za uplatu' : 'Ukupno';
        $retval->datum = ($p) ? 'Datum dospeća:' : 'Datum:'; 
        return $retval;
    }
}