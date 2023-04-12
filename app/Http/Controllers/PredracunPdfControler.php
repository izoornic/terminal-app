<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LicencaNaplata;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaMesec;
use App\Models\LicencaDistributerMesec;
 
use PDF;
use File;
use Illuminate\Support\Facades\Storage;
use Response;


class PredracunPdfControler extends Controller
{

    //
    public $mid;
    public $did;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->did = request()->query('did');
        $this->mid = request()->query('mid');
        
        //******************  CUVANJE PDF FAJLA    */
        $pdf = PDF::loadView('pdf/testPdf', ['data' => $this->read(), 'distributerrow' => $this->distributer(), 'mesecrow' => $this->mesecrow(), 'zaduzenjerow' => $this->zaduzenjerow()]); 
        //$pdf->save(base_path().'/public/predracuni/predracun.pdf');
       
        return $pdf->stream('predracun.pdf');
        

        //$pdf = PDF::LoadFile('http://localhost/predracuni/resume3.pdf');

        
        
        //Storage::disk('public')->put('blacklist.txt', $blaclist_file_content);

        //$pdf->save(base_path().'/public/predracuni/resume.pdf');
        //File::copy(base_path().'/storage/app/public/resume.pdf', base_path().'/public/predracuni/resume.pdf');
        //Storage::disk('public')->get('/predracuni/resume.pdf');

        //******************  PRIKAZ PDF FAJLA    */
        //$ff = Storage::disk('public')->get('resume.pdf');
        //dd(base_path().'/predracuni/resume.pdf');
        //$pdf = PDF::LoadFile('http://localhost/predracuni/resume.pdf');

        //File::copy(base_path().'/storage/app/public/resume.pdf', base_path().'/public/predracuni/resume.pdf');
        
        //File::delete(base_path().'/public/predracuni/resume.pdf');
        
        //return $pdf->stream();
        
        //return redirect('/predracuni/resume3.pdf');


        //return Response::make(Storage::disk('public')->get('resume2.pdf'));
        //dd(Storage::disk('public')->get('resume2.pdf'));
        //return view('pdf.pdfView', ['pddf' => Storage::disk('public')->get('resume2.pdf')]);
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaNaplata::select(
                        'terminal_lokacijas.id', 
                        'terminals.sn', 
                        'lokacijas.l_naziv', 
                        'lokacijas.mesto', 
                        'lokacijas.adresa',
                        'licenca_naplatas.broj_dana',
                        'licenca_naplatas.zaduzeno',
                        'licenca_naplatas.datum_pocetka_licence', 
                        'licenca_naplatas.datum_kraj_licence', 
                        'licenca_naplatas.datum_isteka_prekoracenja', 
                        'licenca_naplatas.licenca_distributer_cenaId',
                        'licenca_tips.licenca_naziv', 
                        'licenca_tips.id as ltid',
                        )
                        ->leftJoin('terminal_lokacijas', 'licenca_naplatas.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
                        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                        ->leftJoin('licenca_distributer_cenas', 'licenca_naplatas.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
                        ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                        ->where('licenca_naplatas.distributerId', '=', $this->did)
                        ->where('licenca_naplatas.mesecId', '=', $this->mid)
                        ->orderBy('terminal_lokacijas.id')
                        ->orderBy('licenca_distributer_cenas.licenca_tipId')
                        ->get();
    }

    public function distributer()
    {
        return LicencaDistributerTip::find($this->did)->first();
    }
    public function mesecrow()
    {
        return LicencaMesec::find($this->mid)->first();
    }
    public function zaduzenjerow()
    {
        return LicencaDistributerMesec::where('distributerId', '=', $this->did)->where('mesecId', '=', $this->mid)->first();
    }
}
