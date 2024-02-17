<?php

namespace App\Http\Livewire\Distributer;

use App\Models\KursEvra;
use App\Models\LicencaNaplata;
use App\Models\TerminalLokacija;
use App\Models\LicencaParametar;
use App\Models\LicenceZaTerminal;
use App\Models\DistLicencaNaplata;
use App\Models\DistributerUserIndex;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaParametarTerminal;
use App\Models\LicencaDistributerTerminal;

use App\Http\Helpers;

use App\Ivan\CryptoSign;
use App\Ivan\CenaLicence;
use App\Ivan\SelectedTerminalInfo;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Query\Builder;

class DistLicence extends Component
{
    use WithPagination;

    //set on MOUNT
    public $distId;
    public $modelId;
    public $ditributer_info;
    public $br_terminala;

    //SEARCH MAIN
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;

    //DODAJ LICENCU MODAL
    public $dodajLicencuModalVisible;
    public $licence_dodate_terminalu = [];
    public $distrib_terminal_id;
    public $licence_za_dodavanje = [];
    public $dani_trajanja;
    public $datum_kraja_licence;
    public $datum_pocetka_licence;
    public $datum_pocetak_error;

    //PREGLED LICENCE MODAL
    public $pregledLicencaShowModal;
    public $podaci_licence;
    public $naplata_podaci_licence;
    public $razduzi_iznos;
    public $razduzi_datum;
    public $razduzi_iznos_error;
    public $licenca_ima_parametre;
    public $licenca_moze_da_se_brise;
    public $mnth_diff;
    public $lic_nenaplativa;

    //BRISANJE LICENCE
    public $modalConfirmDeleteVisible;
    public $licencaDeleteInfo;
    public $canDelete;

    //PARAMETRI LICENCE MODAL
    public $parametriModalVisible;
    public $pm_licenca_tip_id;
    //niz sa globalno dodeljenim parametrima za licencu
    public $licenca_tip_parametri;
    public $pm_licenca_naziv;

    //cene licenci Zeta i Distributer
    public $cene_licenci;
    public $unete_cene_licenci;
    public $unete_cene_error;
    public $kurs_evra;

    //PRODUZENJE LICENCE
    public $produziLicModalVisible;
    public $produzenje_cene;
    public $licenca_distributer_cena_id;
    public $produzenje_unete_cene_error;
    public $produzenje_cena_licence;
    public $naziv_licence;
    public $produzenje_tip_licence;

    public function mount()
    {
        $this->distId = DistributerUserIndex::select('licenca_distributer_tipsId')->where('userId', '=', auth()->user()->id)->first()->licenca_distributer_tipsId;
        $this->ditributer_info = LicencaDistributerTip::where('id', '=', $this->distId)->first();
        $this->br_terminala = TerminalLokacija::select()->where('distributerId', '=', $this->distId)->count();
        foreach(LicencaDistributerCena::idLicenciDistributera($this->distId) as $key){
            $this->unete_cene_licenci[$key] = 0;
            $this->unete_cene_error[$key] = '';
        }
        $this->kurs_evra = KursEvra::latest()->first();
        $this->produzenje_cene = [];
        //$this->kurs_evra->preuzeti_datum = 'op';
        //dd($this->kurs_evra);
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'datum_pocetka_licence' => ['required', 'date_format:"Y-m-d"'],
            'datum_kraja_licence' => ['required', 'date_format:"Y-m-d"']       
        ];
    }

    /**
     * [Description for pregledLicenceShovModal]
     *
     * @param mixed $tre_loc_id - TerminalLokacija ID
     * @param mixed $ldtidd - LicencaDistributerTerminal ID
     * 
     * @return [type]
     * 
     */
    public function pregledLicenceShovModal($tre_loc_id, $ldtidd, $mnth_diff)
    {
        
        $this->resetTerm();
        $this->distrib_terminal_id = $ldtidd;
        $this->modelId = $tre_loc_id;
        //$this->licence_dodate_terminalu = $this->licenceDodateTerminalu();
        $this->podaci_licence = $this->licencaInfo();
        $this->naplata_podaci_licence = LicencaNaplata::where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)->first();
        $this->razduzi_datum = Helpers::datumKalendarNow();
        $this->licenca_ima_parametre = $this->licencaImaParametre($this->podaci_licence->licenca_tipId);
        $this->licenca_moze_da_se_brise = $this->canDeleteLcence();
        $this->mnth_diff = $mnth_diff;
        $this->lic_nenaplativa = LicencaDistributerTerminal::where('id', '=', $this->distrib_terminal_id)->first()->nenaplativ;

        $this->pregledLicencaShowModal = true;
    }

    public function produziLicencuShovModal($tre_loc_id, $ldtidd)
    {
        $this->pregledLicencaShowModal = false;

        $this->resetTerm();
        $this->distrib_terminal_id = $ldtidd;
        $this->modelId = $tre_loc_id;
        $this->podaci_licence = $this->licencaInfo();
        $this->naziv_licence = $this->podaci_licence->licenca_naziv;
        $this->produzenje_tip_licence = $this->podaci_licence->licenca_tipId;
        $this->licenca_distributer_cena_id = $this->podaci_licence->ldcid;
        $this->naplata_podaci_licence = LicencaNaplata::where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)->first();
        $this->datum_pocetka_licence = $this->naplata_podaci_licence->datum_kraj_licence;
        $this->datum_kraja_licence = Helpers::firstDayOfMounth(Helpers::addMonthsToDate($this->datum_pocetka_licence, 1));
        $this->produzenje_cene[0] = new CenaLicence($this->licenca_distributer_cena_id, $this->datum_pocetka_licence, $this->datum_kraja_licence);
        
        //PARAMETI ZA IZABRANU LICENCU
        $this->parametri = LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $this->distrib_terminal_id)->pluck('licenca_parametarId')->all();
        //GLOBALNO DODELJENI parametri za tip licence
        $this->licenca_tip_parametri = LicencaParametar::where('licenca_tipId', '=', $this->produzenje_tip_licence)->pluck('id')->all();
        
        $this->produziLicModalVisible = true;
    }

    public function produziLicencu()
    {
        $this->updated();
        if($this->produzenje_cena_licence <= 0 || !is_numeric($this->produzenje_cena_licence)){
            $this->produzenje_unete_cene_error = 'Greška! Cena licence mora biti broj veći od 0!';
            return;
        }
        $this->produzenje_unete_cene_error = '';
        $this->dani_trajanja = Helpers::numberOfDaysBettwen($this->datum_pocetka_licence, $this->datum_kraja_licence);
        if($this->dani_trajanja < 1) return;

        $this->updateParametre();

        $model_data = [
            'datum_pocetak' => $this->datum_pocetka_licence,
            'datum_kraj' => $this->datum_kraja_licence,
            'licenca_broj_dana' => $this->dani_trajanja,
        ];
        
        LicencaDistributerTerminal::where('id', '=', $this->distrib_terminal_id)->update($model_data);

        $datum_prekoracenja = Helpers::addDaysToDate($this->datum_kraja_licence, $this->ditributer_info->dani_prekoracenja_licence);
        //dodaj licence terminalu za prezimanje
        $key_arr = [
            'terminal_lokacijaId' => $this->modelId,
            'distributerId' => $this->distId,
            'licenca_distributer_cenaId' => $this->licenca_distributer_cena_id,
        ];
        //niz samo za API tabelu
        $terminal_info = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);
        $kraj_licence_za_api = Helpers::firstDayOfMounth(Helpers::addMonthsToDate($this->datum_pocetka_licence, 1));
        $vals_ins = [
            'mesecId'=> 0,
            'terminal_sn' => $terminal_info->sn,
            'datum_pocetak' => $this->datum_pocetka_licence,
            'datum_kraj' =>  $kraj_licence_za_api,
            'datum_prekoracenja' => Helpers::addDaysToDate($kraj_licence_za_api, $this->ditributer_info->dani_prekoracenja_licence),
            'naziv_licence' => $this->naziv_licence
        ];
        $this->AddToLicenceZaTerminal($key_arr, $vals_ins);

        //oslobodi stari zapis u tabelu 'licenca_naplatas'
        LicencaNaplata::where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)->update(['licenca_dist_terminalId' => 0]);

        //dodaj red u tabelu 'licenca_naplatas'
        $model_lic_nap = [
        'licenca_dist_terminalId' => $this->distrib_terminal_id,
        'datum_pocetka_licence' => $this->datum_pocetka_licence,
        'datum_kraj_licence'  => $this->datum_kraja_licence,
        'datum_isteka_prekoracenja' => $datum_prekoracenja,
        'dist_zaduzeno' => $this->produzenje_cena_licence,
        'dist_datum_zaduzenja' => Helpers::datumKalendarNow()
        ];
        foreach($key_arr as $key=>$val){
            $model_lic_nap[$key] = $val;
        }
        LicencaNaplata::create($model_lic_nap);

        $this->produziLicModalVisible = false;
    }

    public function dodajIzPregledaLicenceShovModal($tre_loc_id, $ldtidd)
    {
        $this->pregledLicencaShowModal = false;
        $this->dodajLicencaShowModal($tre_loc_id, $ldtidd);
    }

    public function parametriIzPregledaLicenceShovModal($ldtidd)
    {
        $this->pregledLicencaShowModal = false;
        $this->parametriLicenceShowModal($ldtidd);
    }

    public function deleteIzPregledaLicencuShowModal($tre_loc_id, $ldtidd)
    {
        $this->pregledLicencaShowModal = false;
        $this->deleteLicencuShowModal($tre_loc_id, $ldtidd);
    }
    /**
     * Koliko terminala ima distributer function.
     *
     * @return object
     */
    public function prebrojLicenceDistributera()
    {
        return LicencaDistributerTerminal::select()->where('distributerId', '=', $this->distId)->count();
    }

        /**
     * Shows dodaj Licenca modal.
     *
     * @return void
     */
    public function dodajLicencaShowModal($tre_loc_id, $ldtidd)
    {
        $this->resetTerm();
        $this->distrib_terminal_id = $ldtidd;
        $this->modelId = $tre_loc_id;
        $this->licence_dodate_terminalu = $this->licenceDodateTerminalu();
        //if ($this->licence_dodate_terminalu[0] == null) $this->licence_dodate_terminalu = [];
        $this->dodajLicencuModalVisible = true;
    }

    private function licenceDodateTerminalu()
    {
        return LicencaDistributerTerminal::where('terminal_lokacijaId', '=', $this->modelId)
                    ->pluck('licenca_distributer_cenaId')->all();
    }

    /**
     * The reset form for new teminal
     *
     * @return void
     */
    public function resetTerm()
    {
        $this->datum_pocetka_licence = Helpers::datumKalendarNow();
        $this->datum_kraja_licence = Helpers::firstDayOfMounth(Helpers::addMonthsToDate($this->datum_pocetka_licence, 1));
        $this->licence_za_dodavanje = [];
         $this->distrib_terminal_id = 0;
        $this->dani_trajanja = Helpers::numberOfDaysBettwen($this->datum_pocetka_licence, $this->datum_kraja_licence);
        $this->parametri = [];
        foreach($this->unete_cene_error as $key => $value){
            $this->unete_cene_error[$key] = '';
        }
        foreach($this->unete_cene_licenci as $key => $value){
            $this->unete_cene_licenci[$key] = 0;
        }
        $this->razduzi_iznos = 0;
        $this->razduzi_iznos_error = '';
        $this->mnth_diff = 1;
        $this->produzenje_cene = [];
        $this->produzenje_unete_cene_error = '';
        $this->produzenje_cena_licence = 0;
        $this->naziv_licence = '';
        $this->produzenje_tip_licence = 0;
        $this->datum_pocetak_error = '';
        $this->lic_nenaplativa = 0;
    }
    
    /**
     * Dodaj licence function.
     *
     * @return void
     */
    public function dodajLicenceTerminalu()
    {
        $this->validate();
        $this->updated();

        if(Helpers::numberOfDaysBettwen(Helpers::datumKalendarNow(), $this->datum_pocetka_licence) > 10){
            $this->datum_pocetak_error = 'Greška! Datum počteka licence ne može biti više od 10 dana od današnje dana';
            return;
        }
        $this->datum_pocetak_error = '';
        //provera da li je uneo cenu za svaku licencu
        foreach($this->unete_cene_licenci as $key => $value){
            if(in_array($key, $this->licence_za_dodavanje)){
                //dd($value, floatval($value));
                if($value <= 0 || !is_numeric($value)){
                    $this->unete_cene_error[$key] = 'Greška! Cena licence mora biti broj veći od 0!';
                    return;
                }
                $this->unete_cene_error[$key] = '';
                $this->unete_cene_licenci[$key] = floatval($value);
            }
        } 

        $this->dani_trajanja = Helpers::numberOfDaysBettwen($this->datum_pocetka_licence, $this->datum_kraja_licence);
        if($this->dani_trajanja < 1) return;
        //dd($this->unete_cene_error);     
        //parametri
        $parametriAll = $this->parametersAll();

        $terminal_info = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);

        if(count($this->licence_za_dodavanje)){
            $model_data = [
                'distributerId' => $this->distId,
                'terminal_lokacijaId' => $this->modelId,
                'datum_pocetak' => $this->datum_pocetka_licence,
                'datum_kraj' => $this->datum_kraja_licence,
                'licenca_broj_dana' => $this->dani_trajanja
            ];
            
            foreach($this->licence_za_dodavanje as $lc){
                $licenca_tip_id = LicencaDistributerCena::where('id', '=', $lc)->first()->licenca_tipId;

                $model_data['licenca_distributer_cenaId'] = $lc;
                $nazivLicence = LicencaDistributerCena::nazivLicence($lc);

                $new_licence = LicencaDistributerTerminal::create($model_data)->id;

                $this->addParametersToLicence($new_licence, $parametriAll, $licenca_tip_id);
                $datum_prekoracenja = Helpers::addDaysToDate($this->datum_kraja_licence, $this->ditributer_info->dani_prekoracenja_licence);
                //dodaj licence terminalu za prezimanje
                $key_arr = [
                    'terminal_lokacijaId' => $this->modelId,
                    'distributerId' => $this->distId,
                    'licenca_distributer_cenaId' => $lc,
                ];
                //niz samo za API tabelu
                $kraj_licence_za_api = Helpers::firstDayOfMounth(Helpers::addMonthsToDate($this->datum_pocetka_licence, 1));
                $vals_ins = [
                    'mesecId'=> 0,
                    'terminal_sn' => $terminal_info->sn,
                    'datum_pocetak' => $this->datum_pocetka_licence,
                    'datum_kraj' =>  $kraj_licence_za_api,
                    'datum_prekoracenja' => Helpers::addDaysToDate($kraj_licence_za_api, $this->ditributer_info->dani_prekoracenja_licence),
                    'naziv_licence' => $nazivLicence
                ];
                $this->AddToLicenceZaTerminal($key_arr, $vals_ins);

                //dodaj red u tabelu 'licenca_naplatas'
                $model_lic_nap = [
                'licenca_dist_terminalId' => $new_licence,
                'datum_pocetka_licence' => $this->datum_pocetka_licence,
                'datum_kraj_licence'  => $this->datum_kraja_licence,
                'datum_isteka_prekoracenja' => $datum_prekoracenja,
                'dist_zaduzeno' => $this->unete_cene_licenci[$lc],
                'dist_datum_zaduzenja' => Helpers::datumKalendarNow()
                ];
                foreach($key_arr as $key=>$val){
                    $model_lic_nap[$key] = $val;
                }
                LicencaNaplata::create($model_lic_nap);
            }
        }
        $this->resetTerm();
        $this->dodajLicencuModalVisible = false;
        $this->resetPage();    
    }

    /**
     * update or create zapis u tabeli licenca_terminas 
     *
     * @param mixed $key_arr
     * @param mixed $vals_ins
     * 
     * @return [type]
     * 
     */
    private function AddToLicenceZaTerminal($key_arr, $vals_ins)
    {
        $signature_cripted =  CryptoSign::criptSignature($vals_ins);
        $vals_ins['signature'] = $signature_cripted;

        LicenceZaTerminal::updateOrCreate( $key_arr, $vals_ins );
    }

    private function licencaImaParametre($licenca_tip_id)
    {
        return (LicencaParametar::where('licenca_tipId', '=', $licenca_tip_id)->first()) ? true : false;
    }

    /**
     * Spakuje sve parametre izabranih licenci u niz da bi posle 
     * odabrane parametre upisao u licencu
     *
     * @return [type]
     * 
     */
    private function parametersAll()
    {
        $parametriAll = [];
        foreach ($this->licence_za_dodavanje as $licencaa_id){
            $licenca_tip_id = LicencaDistributerCena::where('id', '=', $licencaa_id)->first()->licenca_tipId;
            $parametri_licence = LicencaParametar::where('licenca_tipId', '=', $licenca_tip_id)->pluck('id')->all();
            $parametriAll[$licenca_tip_id] = $parametri_licence;
        }
        return $parametriAll;
    }

    /**
     * Dodaje parametre novoj licenci
     *
     * @param mixed $lic_dist_termId
     * @param mixed $parametriAll
     * @param mixed $licenca_tip_id
     * 
     * @return [type]
     * 
     */
    private function addParametersToLicence($lic_dist_termId, $parametriAll, $licenca_tip_id)
    {
        foreach($parametriAll[$licenca_tip_id] as $parametarJedneLicence){
            if(in_array($parametarJedneLicence, $this->parametri)){
                LicencaParametarTerminal::create(['licenca_distributer_terminalId' => $lic_dist_termId, 'licenca_parametarId' => $parametarJedneLicence]);
            }
        }
        $this->updateBrojParametaraLicence($lic_dist_termId);
    }

    /**
     * Update polje sa brojem parametara za neku licencu
     *
     * @param mixed $lic_dist_termId
     * 
     * @return [type]
     * 
     */
    private function updateBrojParametaraLicence($lic_dist_termId)
    {
        $br_parametara = LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $lic_dist_termId)->count();
        LicencaDistributerTerminal::find($lic_dist_termId)->update(['broj_parametara' => $br_parametara]);
    }

    /**
     * Modal za brisanje licence
     *
     * @param mixed $tre_loc_id
     * @param mixed $ldtidd
     * 
     * @return [type]
     * 
     */
    public function deleteLicencuShowModal($tre_loc_id, $ldtidd)
    {
        $this->licence_dodate_terminalu = $this->licenceDodateTerminalu();
        $this->modelId = $tre_loc_id;
        $this->distrib_terminal_id = $ldtidd;
        $this->licencaDeleteInfo = $this->licencaInfo();
        $this->canDelete = $this->canDeleteLcence();
        $this->modalConfirmDeleteVisible = true;
    }

    public function delteLicenca()
    {
        DB::transaction(function(){
            $licenca_row = $this->licencaInfo();
            $naplata_row = LicencaNaplata::where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)->first();
            LicencaDistributerTerminal::destroy($this->distrib_terminal_id);
            LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $this->distrib_terminal_id)->delete();
            LicenceZaTerminal::where('terminal_lokacijaId', '=', $licenca_row->terminal_lokacijaId)
                        ->where('distributerId', '=', $licenca_row->distributerId)
                        ->where('licenca_distributer_cenaId', '=', $licenca_row->licenca_distributer_cenaId)
                        ->delete();
            if(!isset($naplata_row->zaduzeno)) LicencaNaplata::where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)->delete();
            else LicencaNaplata::where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)->update(['licenca_dist_terminalId' => NULL]);
        });
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    private function canDeleteLcence()
    {
        $licence_details = LicencaNaplata::select('*')
            ->where('licenca_dist_terminalId', '=', $this->distrib_terminal_id)
            ->orderBy('id', 'desc')
            ->first();
        $expire = Helpers::monthDifference($licence_details->datum_kraj_licence);
        //ako Zeta nije zaduzila i distributer nije naplatio ditributera moze da brise
        if(!isset($licence_details->zaduzeno) && !isset($licence_details->dist_razduzeno)) return true;
        //ako je Zeta razduzila distributera i licenca je istekla moze da brise
        if(isset($licence_details->razduzeno) && $expire < 1) return true;
        //u svim ostalim slucajevima ne moze
        return false;  
    }
    private function licencaInfo()
    {
        return LicencaDistributerTerminal::select('licenca_tips.licenca_naziv','licenca_distributer_terminals.distributerId', 'licenca_distributer_terminals.terminal_lokacijaId', 'licenca_distributer_terminals.licenca_distributer_cenaId', 'licenca_distributer_cenas.licenca_tipId', 'licenca_distributer_cenas.id as ldcid')
            ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_cenas.id', '=', 'licenca_distributer_terminals.licenca_distributer_cenaId')
            ->leftJoin('licenca_tips', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
            ->where('licenca_distributer_terminals.id', '=', $this->distrib_terminal_id)
            ->first();
    }

    /**
     * Parametri Licence
     *
     * @param mixed $licencaDistributerTerminalid
     * @param mixed $naziv
     * 
     * @return [type]
     * 
     */
    public function parametriLicenceShowModal($licencaDistributerTerminalid)
    {
        $this->resetTerm();
        $this->distrib_terminal_id = $licencaDistributerTerminalid;
        $lic_info = $this->licencaInfo();
        $this->pm_licenca_tip_id = $lic_info->licenca_tipId;
        $this->pm_licenca_naziv = $lic_info->licenca_naziv;
        
        //PARAMETI ZA IZABRANU LICENCU
        $this->parametri = LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $this->distrib_terminal_id)->pluck('licenca_parametarId')->all();
        //GLOBALNO DODELJENI parametri za tip licence
        $this->licenca_tip_parametri = LicencaParametar::where('licenca_tipId', '=', $this->pm_licenca_tip_id)->pluck('id')->all();
        
        $this->parametriModalVisible = true;
    }

    public function updateParametreLicence()
    {
        $this->updateParametre();
        $this->parametriModalVisible = false;
    }

    /**
     * Update parametara iz dve funkcije
     * updateParametreLicence()
     * produziLicencu()
     *
     * @return [type]
     * 
     */
    private function updateParametre()
    {
        LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $this->distrib_terminal_id)->delete();
        foreach($this->parametri as $parametarId){
            if(in_array($parametarId, $this->licenca_tip_parametri)){
                LicencaParametarTerminal::create(['licenca_distributer_terminalId' => $this->distrib_terminal_id, 'licenca_parametarId' => $parametarId]);
            }  
        }
    }

    public function razduziUplatu()
    {
        if($this->razduzi_iznos <= 0 || !is_numeric($this->razduzi_iznos)){
            $this->razduzi_iznos_error = 'Greška! Cena licence mora biti broj veći od 0!';
            return;
        }
        $this->razduzi_iznos_error = '';
        $this->razduzi_iznos = floatval($this->razduzi_iznos);
        LicencaNaplata::where('id', '=', $this->naplata_podaci_licence->id)->update(['dist_razduzeno' => $this->razduzi_iznos, 'dist_datum_razduzenja' => $this->razduzi_datum]);
        
        $this->pregledLicencaShowModal = false;
    }

    /**
     * The read function. searchTipLicence
     *
     * @return void
     */
    public function read()
    {
        return TerminalLokacija::select(
                            'terminal_lokacijas.id as tmlokId', 
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
                            'licenca_tips.broj_parametara_licence',
                            'licenca_naplatas.dist_zaduzeno',
                            'licenca_naplatas.dist_razduzeno',
                            'licenca_naplatas.zaduzeno',
                            'licenca_naplatas.razduzeno'
                    )
                    ->leftJoin('licenca_distributer_terminals', 'licenca_distributer_terminals.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_terminals.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
                    ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                    ->leftJoin('licenca_naplatas', 'licenca_naplatas.licenca_dist_terminalId', '=', 'licenca_distributer_terminals.id')
                    ->where('terminal_lokacijas.distributerId', '=', $this->distId)
                    ->where('terminals.sn', 'like', '%'.$this->searchTerminalSn.'%')
                    ->where('lokacijas.mesto', 'like', '%'.$this->searchMesto.'%')
                    ->when($this->searchTipLicence > 0, function ($rtval){
                        return $rtval->where('licenca_distributer_cenas.id', '=', ($this->searchTipLicence == 1000) ? null : $this->searchTipLicence);
                    })
                    ->orderBy(\DB::raw("COALESCE(licenca_distributer_terminals.datum_kraj, '9999-12-31')", 'ASC'))
                    ->orderBy('terminal_lokacijas.id')
                    ->orderBy('licenca_distributer_cenas.licenca_tipId')
                    ->paginate(Config::get('terminal_paginate'), ['*'], 'terminali');
    }

    /**
     * updated
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function updated()
    {
        //setuje kraj licnece na prvi dan u izabranom mesecu
        if($this->dodajLicencuModalVisible){
            $this->datum_kraja_licence = Helpers::firstDayOfMounth($this->datum_kraja_licence);
            //cene licenci
            if(count($this->licence_za_dodavanje)){
                $this->cene_licenci = [];
                foreach($this->licence_za_dodavanje as $lc){
                    $this->cene_licenci[$lc] = new CenaLicence($lc, $this->datum_pocetka_licence, $this->datum_kraja_licence);
                    //$this->unete_cene_licenci[$lc] = $this->cene_licenci[$lc]->dist_cena_din;
                }

            }
        }
        //prodizetak licence
        if($this->produziLicModalVisible){
            $this->datum_kraja_licence = Helpers::firstDayOfMounth($this->datum_kraja_licence);
            $this->produzenje_cene[0] = new CenaLicence($this->licenca_distributer_cena_id, $this->datum_pocetka_licence, $this->datum_kraja_licence);
        }
    }
    public function render()
    {
        return view('livewire.distributer.dist-licence', [
            'data' => $this->read(), 'br_licenci' => $this->prebrojLicenceDistributera(),
        ]);
    }
}
