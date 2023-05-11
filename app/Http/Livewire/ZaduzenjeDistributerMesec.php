<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerTerminal;
use App\Models\LicencaDistributerMesec;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaNaplata;
use App\Models\LicencaMesec;

use Livewire\WithPagination;
use Livewire\Component;

use Illuminate\Support\Facades\Config;
use App\Helpers\PaginationHelper;
use App\Http\Helpers;


class ZaduzenjeDistributerMesec extends Component
{
    use WithPagination;

    /**
     * Public properties
     */
    private $dataAll;
    private $nenaplativi;
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
    public $dnevneCeneLicenci;

    //SEARCH
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;

    //SEARCH NENAPLATIVE
    public $searchTerminalSnNpl;
    public $searchMestoNpl;
    public $searchTipLicenceNpl;

    //Confirm zaduzenje modal
    public $zaduzenjeConfirmVisible;

    //Promena datuma MODAL
    public $changeDatesShowModal;
    public $licencaRow;
    public $p_datumPocetak;
    public $p_datumKraj;
    public $brojDana;

    //Nenaplativ MODAL
    public $nenaplativRow;
    public $neModalVisible;

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
        $this->dnevneCeneLicenci = $this->dnevneCeneLicenciDistributera($this->mesecRow->m_broj_dana);

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
     * Set dnevnu cenu licenci za zaduzenje
     *
     * @return void
     */
    public function dnevneCeneLicenciDistributera($brojDana)
    {
        $retval = [];
        foreach($this->ceneLicenci as $key => $value){
            $retval[$key] = $value / $brojDana;
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
     * Dodaje cene licenci u objekat ivuzen iz baze koristeci each metodu Laravel collection-a
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
                        'licenca_distributer_terminals.nenaplativ',
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
                ->where('licenca_distributer_terminals.nenaplativ', '<', 1)
                ->whereNotNull('licenca_distributer_terminals.licenca_distributer_cenaId')
                ->orderBy('terminal_lokacijas.id')
                ->orderBy('licenca_distributer_cenas.licenca_tipId')
                ->get();
        
        //############################## EACH ITEM CHECK #######################################//
        $nextMounth = Helpers::addMonthsToDate($this->mesecRow->mesec_datum, 1);

        $this->dataAll->each(function ($item, $key)use($nextMounth) {

            $cena = $this->ceneLicenci[$item->ltid];
            $cena_dnevno = $this->dnevneCeneLicenci[$item->ltid];

            $item->iskljucen = false;
            $markPocetak = 'ok';
            $markKraj = 'ok';

            //ISKJUCEN rucno
            if(in_array($item->ldtid, $this->ne_zaduzuju_se)){
                $item->iskljucen = true;
                $cena = 0;
                $markPocetak = 'Cecked';
            }else{
                $pocetak_licence = Helpers::equalGraterOrLessThan($item->datum_pocetak, $this->mesecRow->mesec_datum);
                //provera datuma pocetka licence
                switch ($pocetak_licence){
                    case 'eq' :
                        // equal all ok
                        $markPocetak = 'ok';
                    break;
                    case 'gt' :
                        // veci od pocetka meseca
                        //mora provera dali je licenca iz tog meseca
                        $p_diff = Helpers::equalGraterOrLessThan($item->datum_pocetak, $nextMounth);
                        if($p_diff == 'gt' || $p_diff ==  'eq'){
                            //licenca pocinje sledeceg meseca
                            $markPocetak = 'errGt';
                            $cena = 0;
                        }else{
                            //cena broj dana koliko je zaduzen
                            $markPocetak = 'lessDays';
                            $cena = round($cena_dnevno * $item->licenca_broj_dana, 2);
                        }
                    break;
                    case 'lt' :
                        //less than 
                        // licenca iz meseca ranije
                        $item->licenca_broj_dana = Helpers::numberOfDaysBettwen($item->datum_pocetak, $nextMounth);
                        $cena = round($cena_dnevno * $item->licenca_broj_dana, 2);
                        $markPocetak = 'errLt';
                    break;
                    case 'err' :
                        $markPocetak = 'errDt';
                        $cena = 0;
                    break;
                }

                //kraj LICENCE
                $kraj_licence = Helpers::equalGraterOrLessThan($item->datum_kraj, $nextMounth);
                
                switch($kraj_licence){
                    case 'eq' :
                        // equal all ok
                        $markKraj = 'ok';
                    break;
                    case 'gt' :
                        // kraj licence veci od pocetka sledeceg meseca
                        $markKraj = 'errGt';
                        if($markPocetak != 'errGt') $cena = round($cena_dnevno * $item->licenca_broj_dana, 2);
                    break;
                    case 'lt' :
                        //less than 
                        // licenca se zavrsava pre kraja meseca
                        //produzuje se do kraja meseca
                        $item->datum_kraj = $nextMounth;
                        $item->licenca_broj_dana = Helpers::numberOfDaysBettwen($item->datum_pocetak, $nextMounth);

                        $cena = round($cena_dnevno * $item->licenca_broj_dana, 2);
                        $markKraj = 'errLt';
                    break;
                    case 'err' :
                        $markKraj = 'errDt';
                        $cena = 0;
                    break;
                }
            }
            $item->markKraj = $markKraj;
            $item->markPocetak = $markPocetak;
            $item->cenaLicence = $cena;

            $this->ukupno_zaduzenje += $cena;            
        });

    }

    public function readNenaplative()
    {
        $filter = [
            'searchTerminalSnNpl'   =>  $this->searchTerminalSnNpl,
            'searchMestoNpl'        =>  $this->searchMestoNpl,
            'searchTipLicenceNpl'   =>  $this->searchTipLicenceNpl
        ];

        return LicencaDistributerTerminal::nenaplativeLicenceDistributera($this->did, $filter);
    }

    public function showZaduzenjeConfirmModal()
    {
        $this->zaduzenjeConfirmVisible = true;
    }

    public function zaduziDistributera()
    {
        $datum_zaduzenja = Helpers::datumKalendarNow();
        $this->prepareData();

        $this->dataAll->each(function ($item, $key){
            if(!in_array($item->ldtid, $this->ne_zaduzuju_se) && $item->cenaLicence > 0){ 
                $model_data = [
                    'terminal_lokacijaId' => $item->id,
                    'distributerId' => $this->did,
                    'licenca_distributer_cenaId' => $item->licenca_distributer_cenaId,
                    'mesecId' => $this->mid,
                    'broj_dana' => $item->licenca_broj_dana,
                    'zaduzeno' => $item->cenaLicence,
                    'datum_pocetka_licence' => $item->datum_pocetak,
                    'datum_kraj_licence' => $item->datum_kraj,
                    'datum_isteka_prekoracenja' => Helpers::addDaysToDate($item->datum_kraj, $this->distributer_info->dani_prekoracenja_licence)
                ];
                LicencaNaplata::create($model_data);
            }elseif(in_array($item->ldtid, $this->ne_zaduzuju_se)){
                LicencaDistributerTerminal::find($item->ldtid)->update(['nenaplativ' => 1]);
            }

        });

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

    public function nenaplativShovModal($ldtid)
    {
        
        $this->nenaplativRow = $ldtid;
       $this->neModalVisible = true;
    }

    public function promeniStatusNenaplativojLicenci()
    {
        $neVal = LicencaDistributerTerminal::where('licenca_distributer_terminals.id', '=', $this->nenaplativRow['ldtid'])->first()->nenaplativ;
        $neNew = ($neVal) ? 0 : 1;
        LicencaDistributerTerminal::where('licenca_distributer_terminals.id', '=', $this->nenaplativRow['ldtid'])->update(['nenaplativ' => $neNew]);
        $this->neModalVisible = false;
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
        if($this->neModalVisible){
            $this->nenaplativaRow = $this->singleLicenceInfo();
        }
    }

    /**
     * Prikaz kolekcije sa filterima
     *
     * @return collection
     * 
     */
    public function displayData()
    {
        $retval = $this->dataAll->filter(function ($value, $key) {
            return $this->filterFields($value->sn, $value->mesto, $value->licenca_distributer_cenaId);
        });

        return $retval;
    }

    /**
     * Rucno napravljeni filteri na starnici
     *
     * @param mixed $sn
     * @param mixed $mesto
     * @param mixed $licenca
     * 
     * @return boolean
     * 
     */
    private function filterFields($sn, $mesto, $licenca)
    {
        $filter_sn = ($this->searchTerminalSn != '') ? true : false;
        $filter_mesto = ($this->searchMesto != '') ? true : false;
        $filter_licenca = ($this->searchTipLicence > 0) ? true : false;

        $sn_retval = true;
        $mest_retval = true;
        $lic_retval = true;
        
        if($filter_sn){
            $sn_retval = preg_match("/".$this->searchTerminalSn."/i", $sn);
        }
        if($filter_mesto){
            $mest_retval = preg_match("/".$this->searchMesto."/i", $mesto);
        }
        if($filter_licenca){
            $lic_retval = ($this->searchTipLicence == $licenca) ? true : false;
        }

        return ($sn_retval && $mest_retval &&  $lic_retval) ? true : false;
    }

    /**
     * The read function.
     *
     * @return collection
     */
    public function read()
    {
        $this->prepareData();
        return PaginationHelper::paginate($this->displayData(), Config::get('global.paginate'));
    }

    public function render()
    {
        return view('livewire.zaduzenje-distributer-mesec', [
            'data' => $this->read(), 
            'ndata' => $this->readNenaplative(),
            'br_terminala' => $this->prebrojTerminaleDistributera(),
        ]);
    }
}