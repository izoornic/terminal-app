<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerTerminal;
use App\Models\LicencaMesec;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\PaginationHelper;
use Illuminate\Support\Facades\Config;
use App\Http\Helpers;
use App\Models\LicencaDistributerMesec;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaNaplata;

class ZaduzenjeDistributerMesec extends Component
{
    use WithPagination;

    /**
     * Public properties
     */
    private $dataAll;
    public $ukupno_zaduzenje;
    public $ne_zaduzuju_se = [];
    
    //MOUNT
    public $did;
    public $mid;
    public $osnovna_licenca_id;

    public $distributer_info;

    public $mesecRow;
    public $ceneLicenci;
    public $srednjiKurs;

    //SEARCH
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;

    //Confirm zaduzenje modal
    public $zaduzenjeConfirmVisible;

    //Promena datuma MODAL
    public $changeDatesShowModal;
    public $licencaRow;
    public $p_datumPocetak;
    public $p_datumKraj;
    public $brojDana;

     /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->did = request()->query('id');
        $this->mid = request()->query('mid');
        $this->srednjiKurs = request()->query('sk');
       
        $this->osnovna_licenca_id =  LicencaDistributerCena::OsnovnaLicencaDistributera($this->did)[0];
        $this->mesecRow = LicencaMesec::where('id', '=', $this->mid)->first();
        $this->ceneLicenci = $this->ceneLicenciDistributera($this->srednjiKurs);

        $this->distributer_info = LicencaDistributerTip::where('id', '=', $this->did)->first();
        //dd($this->ceneLicenci);
        $this->prepareData();
    }
    
     /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'p_datumPocetak' => ['required', 'date_format:"Y-m-d"'],
            'p_datumKraj' => ['required', 'date_format:"Y-m-d"']       
        ];
    }

    /**
     * Set licenci cene za zaduzenje
     *
     * @return void
     */
    public function ceneLicenciDistributera($sr_kurs)
    {
        $retval = [];
        $cene = LicencaDistributerCena::select('licenca_distributer_cenas.licenca_cena', 'licenca_distributer_cenas.licenca_tipId')
                                    ->where('distributerId', '=', $this->did)
                                    ->pluck('licenca_distributer_cenas.licenca_cena', 'licenca_distributer_cenas.licenca_tipId');
        foreach($cene as $key => $value){
            $retval[$key] = $value * $sr_kurs;
        }
        return  $retval;
    }

    /**
     * Koliko terminala ima distributer function.
     *
     * @return object
     */
    public function prebrojTerminaleDistributera()
    {
        return LicencaDistributerTerminal::select()
        ->where('distributerId', '=', $this->did)
        ->distinct('terminal_lokacijaId')
        ->count();
    }

    /**
     * Priprema podatke za prikaz.
     * Dodaje cene licenci u objekat ivu;en iz baze
     *
     * @return void
     */
    private function prepareData()
    {
        $this->ukupno_zaduzenje = 0;
        $this->dataAll = LicencaDistributerTerminal::select(
                        'terminal_lokacijas.id', 
                        'terminals.sn', 
                        'lokacijas.l_naziv', 
                        'lokacijas.mesto', 
                        'lokacijas.adresa', 
                        'licenca_distributer_terminals.id as ldtid', 
                        'licenca_distributer_terminals.datum_pocetak', 
                        'licenca_distributer_terminals.datum_kraj', 
                        'licenca_tips.licenca_naziv', 
                        'licenca_tips.id as ltid',
                        'licenca_distributer_terminals.licenca_broj_dana',
                        'licenca_distributer_terminals.licenca_distributer_cenaId'
                        )
                ->leftJoin('terminal_lokacijas', 'licenca_distributer_terminals.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
                ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_terminals.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
                ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                ->where('licenca_distributer_terminals.distributerId', '=', $this->did)
                ->whereNotNull('licenca_distributer_terminals.licenca_distributer_cenaId')
                ->where('terminals.sn', 'like', '%'.$this->searchTerminalSn.'%')
                ->where('lokacijas.mesto', 'like', '%'.$this->searchMesto.'%')
                ->when($this->searchTipLicence > 0, function ($rtval){
                    return $rtval->where('licenca_distributer_cenas.id', '=', $this->searchTipLicence);
                } )
                ->orderBy('terminal_lokacijas.id')
                ->orderBy('licenca_distributer_cenas.licenca_tipId')
                ->get();
        
        $counter = 0;
        
        $nextMounth = Helpers::addMonthsToDate($this->mesecRow->mesec_datum, 1);

        foreach($this->dataAll as $row){

            $cena = $this->ceneLicenci[$row->ltid];
            $this->dataAll[$counter]->iskljucen = false;
            $markKraj = 'ok';

            if(in_array($this->dataAll[$counter]->ldtid, $this->ne_zaduzuju_se)){
                $this->dataAll[$counter]->iskljucen = true;
                $cena = 0;
                $markPocetak = 'Cecked';
            }else{
                $pocetak_licence = Helpers::equalGraterOrLessThan($row->datum_pocetak, $this->mesecRow->mesec_datum);
                //provera datuma licence
                switch ($pocetak_licence){
                    case 'eq' :
                        // equal all ok
                        $markPocetak = 'ok';
                    break;
                    case 'gt' :
                        // veci od pocetka meseca
                        //mora provera dali je licenca iz tog meseca
                        $p_diff = Helpers::equalGraterOrLessThan($row->datum_pocetak, $nextMounth);
                        //dd($row->datum_pocetak, $nextMounth, $p_diff);
                        if($p_diff == 'gt' || $p_diff ==  'eq'){
                            //licenca pocinje sledeceg meseca
                            $markPocetak = 'errGt';
                            $cena = 0;
                        }else{
                            //cena broj dana koliko je zaduzen
                            $markPocetak = 'lessDays';
                            $cena = round(($cena / $this->mesecRow->m_broj_dana) * $row->licenca_broj_dana, 2);
                        }
                    break;
                    case 'lt' :
                        //less than 
                        // licenca iz meseca ranije
                        
                        $row->licenca_broj_dana = Helpers::numberOfDaysBettwen($row->datum_pocetak, $nextMounth);
                        $cena = round(($cena / $this->mesecRow->m_broj_dana) * $row->licenca_broj_dana, 2);
                        $this->dataAll[$counter]->licenca_broj_dana = $row->licenca_broj_dana;
                        $markPocetak = 'errLt';
                    break;
                    case 'err' :
                        $markPocetak = 'errDt';
                        $cena = 0;
                    break;
                }

                //kraj LICENCE
                $kraj_licence = Helpers::equalGraterOrLessThan($row->datum_kraj, $nextMounth);
                
                switch($kraj_licence){
                    case 'eq' :
                        // equal all ok
                        $markKraj = 'ok';
                    break;
                    case 'gt' :
                        // kraj licence veci od pocetka sledeceg meseca
                        $markKraj = 'errGt';
                    break;
                    case 'lt' :
                        //less than 
                        // licenca se zavrsava pre kraja meseca
                        //produzuje se do kraja meseca
                        $this->dataAll[$counter]->datum_kraj = $nextMounth;
                        $row->licenca_broj_dana = Helpers::numberOfDaysBettwen($row->datum_pocetak, $nextMounth);

                        $cena = round(($cena / $this->mesecRow->m_broj_dana) * $row->licenca_broj_dana, 2);
                        $this->dataAll[$counter]->licenca_broj_dana = $row->licenca_broj_dana;

                        $markKraj = 'errLt';
                    break;
                    case 'err' :
                        $markKraj = 'errDt';
                        $cena = 0;
                    break;

                }


            }
            $this->dataAll[$counter]->markKraj = $markKraj;
            $this->dataAll[$counter]->markPocetak = $markPocetak;
            $this->dataAll[$counter]->cenaLicence =  $cena;

            $this->ukupno_zaduzenje += $cena;
            

            $counter ++;
        }

    }

    public function showZaduzenjeConfirmModal()
    {
        $this->zaduzenjeConfirmVisible = true;
    }

    public function zaduziDistributera()
    {
        $datum_zaduzenja = Helpers::datumKalendarNow();
        $this->prepareData();
        $counter = 0;
        foreach($this->dataAll as $row){
            if(!in_array($this->dataAll[$counter]->ldtid, $this->ne_zaduzuju_se) && $row->cenaLicence > 0){ 
                $model_data = [
                    'terminal_lokacijaId' => $row->id,
                    'distributerId' => $this->did,
                    'licenca_distributer_cenaId' => $row->licenca_distributer_cenaId,
                    'mesecId' => $this->mid,
                    'broj_dana' => $row->licenca_broj_dana,
                    'zaduzeno' => $row->cenaLicence,
                    'datum_pocetka_licence' => $row->datum_pocetak,
                    'datum_kraj_licence' => $row->datum_kraj,
                    'datum_isteka_prekoracenja' => Helpers::addDaysToDate($row->datum_kraj, $this->distributer_info->dani_prekoracenja_licence)
                ];
                LicencaNaplata::create($model_data);
            }
            $counter ++;
        }

        //ins
        $ldm_model = [
            'distributerId' => $this->did,
            'mesecId' => $this->mid,
            'sum_zaduzeno' => $this->ukupno_zaduzenje,
            'datum_zaduzenja' => $datum_zaduzenja,
            'srednji_kurs' => $this->srednjiKurs,
            'predracun_pdf' => 'n/a'
        ];
        LicencaDistributerMesec::create($ldm_model);
        
        

       return redirect('/zaduzenje-pregled?id='.$this->did.'&mid='.$this->mid.'&acc=ins');
    }

    public function changeDatesVisible($ldtid){
        $this->brojDana = 1;
        $this->resetValidation();
        $this->licencaRow = LicencaDistributerTerminal::where('id', '=', $ldtid)->first();
        $this->p_datumPocetak = $this->licencaRow->datum_pocetak;
        $this->p_datumKraj = $this->licencaRow->datum_kraj;

        $this->changeDatesShowModal = true;
    }

    public function changeDates()
    {
        $this->validate();
        $licencaTerminalId = $this->licencaRow->id;
        $this->brojDana = Helpers::numberOfDaysBettwen($this->p_datumPocetak, $this->p_datumKraj);
        if($this->brojDana){
            LicencaDistributerTerminal::find($licencaTerminalId)->update(['datum_pocetak' => $this->p_datumPocetak, 'datum_kraj' => $this->p_datumKraj, 'licenca_broj_dana' =>$this->brojDana]);
            $this->changeDatesShowModal = false;
        }
    }

    /**
     * The update function
     *
     * @return void
     */
    public function updated()
    {
        if($this->changeDatesShowModal){
            $this->p_datumKraj = Helpers::firstDayOfMounth($this->p_datumKraj);
        }
        
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        $this->prepareData();
        return PaginationHelper::paginate($this->dataAll, Config::get('global.paginate')); //$this->dataAll; //->paginate(Config::get('terminal_paginate'), ['*'], 'terminali');
    }

    public function render()
    {
        return view('livewire.zaduzenje-distributer-mesec', [
            'data' => $this->read(), 
            'br_terminala' => $this->prebrojTerminaleDistributera(),
        ]);
    }
}