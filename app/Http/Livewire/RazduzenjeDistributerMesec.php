<?php

namespace App\Http\Livewire;

use App\Models\LicencaMesec;
use App\Models\LicencaNaplata;
use App\Models\LicenceZaTerminal;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerMesec;
use App\Models\LicencaDistributerTerminal;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Http\Helpers;
use App\Helpers\PaginationHelper;

use App\Ivan\CryptoSign;

class RazduzenjeDistributerMesec extends Component
{
    use WithPagination;
    
    //MOUNT
    public $did;
    public $mid;

    public $ne_razduzuju_se = [];
    public $ukupno_zaduzenje;

    //READ
    private $dataAll;

    //INFO
    public $distributer_info;

    //SEARCH
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;

    //modal
    public $razduzenjeModalVisible;
    public $mesecRow;
    public $datumUplate;


     /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->did = request()->query('id');
        $this->mid = request()->query('mid');
        $this->distributer_info = LicencaDistributerTip::where('id', '=', $this->did)->first();
        $this->zaduzenjeMesecDistributerRow = LicencaDistributerMesec::where('distributerId', '=', $this->did)->where('mesecId', '=', $this->mid)->first();
        $this->mesecRow = LicencaMesec::where('id', '=', $this->mid)->first();
    }


    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [  
            'datumUplate' => ['required', 'date_format:"Y-m-d"']          
        ];
    }

    public function showRazduzenjeConfirmModal()
    {
        $this->datumUplate = Helpers::datumKalendarNow();
        $this->razduzenjeModalVisible = true;
    }

    public function razduziDistributera()
    {
        $this->validate();
        $update_model = [
            'datum_pocetak' => Helpers::addMonthsToDate($this->mesecRow->mesec_datum, 1), 
            'datum_kraj' => Helpers::addMonthsToDate($this->mesecRow->mesec_datum, 2),
            'licenca_broj_dana' =>  Helpers::noOfDaysInMounth(Helpers::addMonthsToDate($this->mesecRow->mesec_datum, 1))
        ];
        $datum_prekoracenja = Helpers::addDaysToDate( $update_model['datum_kraj'], $this->distributer_info->dani_prekoracenja_licence);
        $this->prepareData();

        //FOREACH
        $this->dataAll->each(function ($item, $key)use($update_model, $datum_prekoracenja){
            //naziv licence
            $item->nazivLicence = LicencaDistributerCena::nazivLicence($item->licenca_distributer_cenaId);

            //LICENCE KOJE SE NE RAZDUZUJU
            if(in_array($item->id, $this->ne_razduzuju_se)){
                DB::transaction(function()use($item){
                    LicencaNaplata::where('id', '=', $item->id)
                            ->update(['razduzeno' => 0]);
                    LicencaDistributerTerminal::where('distributerId', '=', $this->did)
                            ->where('terminal_lokacijaId', '=', $item->terminal_lokacijaId)
                            ->where('licenca_distributer_cenaId', '=', $item->licenca_distributer_cenaId)
                            ->update(['nenaplativ' => 1]);
                });
            }else{
                //RAZDUZENJE
                DB::transaction(function()use($item, $update_model, $datum_prekoracenja){
                    $pretplata = false;
                    if(Helpers::dateGratherOrEqualThan($item->datum_kraj_licence , $update_model['datum_kraj'])){
                        //LICENCA ZADUZENA U PREDPLATI ili ti PLACEN MESEC UNAPRED
                        //pomeram datume za mesec unapred
                        $pretplata = true;
                        $p_pocetak_nove_licence = $item->datum_kraj_licence;
                        $p_kraj_nove_licence = Helpers::addMonthsToDate($p_pocetak_nove_licence, 1);
                        
                        $p_update_model = [
                            'datum_pocetak' => $p_pocetak_nove_licence,
                            'datum_kraj' => $p_kraj_nove_licence, 
                            'licenca_broj_dana' => Helpers::numberOfDaysBettwen($p_pocetak_nove_licence, $item->datum_kraj_licence)
                        ];
                        $p_datum_prekoracenja = Helpers::addDaysToDate(  $p_update_model['datum_kraj'], $this->distributer_info->dani_prekoracenja_licence);
                    }

                    LicencaNaplata::where('id', '=', $item->id)
                            ->update(['razduzeno' => $item->zaduzeno]);
                    LicencaDistributerTerminal::where('distributerId', '=', $this->did)
                            ->where('terminal_lokacijaId', '=', $item->terminal_lokacijaId)
                            ->where('licenca_distributer_cenaId', '=', $item->licenca_distributer_cenaId)
                            ->update(($pretplata) ? $p_update_model : $update_model);
                    
                    //update or create zapis u tabeli licenca_terminas 
                    $key_arr = [
                        'terminal_lokacijaId' => $item->terminal_lokacijaId,
                        'distributerId' => $this->did,
                        'licenca_distributer_cenaId' => $item->licenca_distributer_cenaId,
                    ];

                    $vals_ins = [
                        'mesecId'=> $this->mid,
                        'terminal_sn' => $item->sn,
                        'datum_pocetak' => ($pretplata) ? $p_update_model['datum_pocetak'] : $update_model['datum_pocetak'],
                        'datum_kraj' => ($pretplata) ? $p_update_model['datum_kraj'] : $update_model['datum_kraj'],
                        'datum_prekoracenja' =>($pretplata) ? $p_datum_prekoracenja : $datum_prekoracenja,
                        'naziv_licence' => $item->nazivLicence
                    ];

                    $signature_cripted =  CryptoSign::criptSignature($vals_ins);
                    $vals_ins['signature'] = $signature_cripted;

                    LicenceZaTerminal::updateOrCreate( $key_arr, $vals_ins );

                });
            }
        });
        LicencaDistributerMesec::where('distributerId', '=', $this->did)->where('mesecId', '=', $this->mid)->update(['sum_razaduzeno' => $this->ukupno_zaduzenje, 'datum_razaduzenja' => $this->datumUplate]);
        $this->razduzenjeModalVisible = false;
        return redirect('/razduzenje-pregled?id='.$this->did.'&mid='.$this->mid.'&acc=ras');
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
        $this->dataAll = LicencaNaplata::select(
            'licenca_naplatas.id',
            'licenca_naplatas.broj_dana',
            'licenca_naplatas.datum_pocetka_licence',
            'licenca_naplatas.datum_kraj_licence',
            'licenca_naplatas.datum_isteka_prekoracenja',
            'licenca_naplatas.zaduzeno',
            'licenca_naplatas.licenca_distributer_cenaId',
            'licenca_naplatas.terminal_lokacijaId', 
            'terminals.sn', 
            'lokacijas.l_naziv', 
            'lokacijas.mesto', 
            'lokacijas.adresa', 
            'licenca_tips.licenca_naziv', 
            'licenca_tips.id as ltid'
        )
        ->leftJoin('terminal_lokacijas', 'licenca_naplatas.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
        ->leftJoin('licenca_distributer_cenas', 'licenca_naplatas.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
        ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
        ->where('licenca_naplatas.distributerId', '=', $this->did)
        ->where('licenca_naplatas.mesecId', '=', $this->mid)
        ->get();
    
        $this->dataAll->each(function ($item, $key){
            if(in_array($item->id, $this->ne_razduzuju_se)){
                $item->iskljucen = true;
                $item->zaduzeno = 0;
            }else{
                $item->iskljucen = false;
            }
            $this->ukupno_zaduzenje += $item->zaduzeno;
        });
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
     * @return void
     */
    public function read()
    {
        $this->prepareData();
        return PaginationHelper::paginate($this->displayData(), Config::get('global.paginate'));
    }

    

    public function render()
    {
        return view('livewire.razduzenje-distributer-mesec', [
            'data' => $this->read(),
        ]);
    }
}