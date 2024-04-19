<?php

namespace App\Http\Livewire;

use App\Models\LicencaMesec;
use App\Models\LicencaNaplata;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerMesec;
//use App\Models\LicencaDistributerTerminal;

use Livewire\Component;
use Livewire\WithPagination;

use App\Http\Helpers;

use App\Ivan\CenaLicence;

use App\Helpers\PaginationHelper;

use Illuminate\Support\Facades\Config;

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
    public $mesecRow;
    public $srednjiKurs;
    public $distributer_info;

    //SEARCH
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;

    //Confirm zaduzenje modal
    public $zaduzenjeConfirmVisible;

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
        $this->mesecRow = LicencaMesec::where('id', '=', $this->mid)->first();

        $this->distributer_info = LicencaDistributerTip::where('id', '=', $this->did)->first();

        //$this->prepareData();
    }
    
    /**
     * Set licenci cene za zaduzenje
     *
     * @return void
     */
    public function ceneLicenciDistributera($sr_kurs)
    {
        $retval = [];
        $cene = LicencaDistributerCena::select('licenca_distributer_cenas.licenca_zeta_cena', 'licenca_distributer_cenas.licenca_tipId')
                                    ->where('distributerId', '=', $this->did)
                                    ->pluck('licenca_distributer_cenas.licenca_zeta_cena', 'licenca_distributer_cenas.licenca_tipId');
        foreach($cene as $key => $value){
            $retval[$key] = $value * $sr_kurs;
        }
        return  $retval;
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
        $this->dataAll = LicencaNaplata::select(
                        'terminal_lokacijas.id', 
                        'terminals.sn', 
                        'lokacijas.l_naziv', 
                        'lokacijas.mesto', 
                        'lokacijas.adresa', 
                        'licenca_naplatas.id as lnid', 
                        'licenca_naplatas.datum_pocetka_licence', 
                        'licenca_naplatas.datum_kraj_licence',
                        'licenca_naplatas.nenaplativ',
                        'licenca_tips.licenca_naziv', 
                        'licenca_tips.id as ltid',
                        //'licenca_distributer_terminals.licenca_broj_dana',
                        'licenca_naplatas.licenca_distributer_cenaId',
                        'licenca_distributer_cenas.id as ldcid',
                        'licenca_naplatas.dist_zaduzeno'
                        )
                //->leftJoin('licenca_naplatas', 'licenca_naplatas.licenca_dist_terminalId', '=', 'licenca_distributer_terminals.id')
                ->leftJoin('terminal_lokacijas', 'licenca_naplatas.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
                ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                ->leftJoin('licenca_distributer_cenas', 'licenca_naplatas.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
                ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                ->whereNull('licenca_naplatas.zaduzeno')
                ->where('licenca_naplatas.distributerId', '=', $this->did)
                ->where('licenca_naplatas.nenaplativ', '<', 1)
                //->whereNotNull('licenca_distributer_terminals.licenca_distributer_cenaId')
                ->orderBy('terminal_lokacijas.id')
                ->orderBy('licenca_distributer_cenas.licenca_tipId')
                ->get();

                //dd($this->dataAll);
        
        //############################## EACH ITEM CHECK #######################################//
        $this->dataAll->each(function ($item, $key) {

            $item->iskljucen = false;

            //ISKJUCEN rucno
            if(in_array($item->lnid, $this->ne_zaduzuju_se)){
                $item->iskljucen = true;
                $item->cenaLicence = 0;
            }else{
                $cena_obj = new CenaLicence($item->ldcid, $item->datum_pocetak, $item->datum_kraj, $this->srednjiKurs);
                $item->cenaLicence = $cena_obj->zeta_cena_din;
                $item->cenaLicenceEur = $cena_obj->zeta_cena_eur;
            }

            $this->ukupno_zaduzenje += $item->cenaLicence;            
        });

    }

    /**
     * Zaduzenje Modal VISIBLE
     *
     * @return [type]
     * 
     */
    public function showZaduzenjeConfirmModal()
    {
        $this->zaduzenjeConfirmVisible = true;
    }

    /**
     * Zaduzi Distributera 
     *
     * @return [type]
     * 
     */
    public function zaduziDistributera()
    {
        $datum_zaduzenja = Helpers::datumKalendarNow();
        $this->prepareData();

        $this->dataAll->each(function ($item, $key)use($datum_zaduzenja){
            if(!in_array($item->lnid, $this->ne_zaduzuju_se) && $item->cenaLicence > 0){ 
                $model_data = [
                    'mesecId'           => $this->mid,
                    //'broj_dana'         => $item->licenca_broj_dana,
                    'zaduzeno'          => $item->cenaLicence,
                    'datum_zaduzenja'   => $datum_zaduzenja
                ];
                LicencaNaplata::where('id', '=', $item->lnid)->update($model_data);
            }/* elseif(in_array($item->lnid, $this->ne_zaduzuju_se)){
                LicencaDistributerTerminal::find($item->ldtid)->update(['nenaplativ' => 1]);
            } */

        });

        //ins
        $ldm_model = [
            'distributerId'     => $this->did,
            'mesecId'           => $this->mid,
            'sum_zaduzeno'      => $this->ukupno_zaduzenje,
            'datum_zaduzenja'   => $datum_zaduzenja,
            'srednji_kurs'      => $this->srednjiKurs,
            'predracun_pdf'     => 'n/a'
        ];
        LicencaDistributerMesec::create($ldm_model);
        
       return redirect('/zaduzenje-pregled?id='.$this->did.'&mid='.$this->mid.'&acc=ins');
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
            'data' => $this->read()
        ]);
    }
}