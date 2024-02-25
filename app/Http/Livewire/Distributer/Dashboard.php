<?php

namespace App\Http\Livewire\Distributer;

use Livewire\Component;

use App\Models\TerminalLokacija;
use App\Models\DistributerUserIndex;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerTerminal;

use Illuminate\Support\Facades\Config;


class Dashboard extends Component
{
    public $distId;
    public $ditributerData;

    //LICENCA PROMENA CENE MODAL
    public $modelId;
    public $modalLicencaFormVisible;
    public $l_naziv;
    public $licenca_zeta_cena;
    public $licenca_dist_cena;

    //DISTRIBUTER PODACI MODAL
    public $modalDistributerInfoFormVisible;
    public $distributer_naziv;
    public $distributer_adresa;
    public $distributer_zip;
    public $distributer_mesto;
    public $distributer_email;
    public $distributer_pib;
    public $distributer_mb;
    public $distributer_tr;
    public $distributer_banka;
    public $distributer_tel;

    public $is_user_zeta;
    public $testUserDistributer;
    public $promeniDitributeraModalVisible;


    public function mount()
    {
        $this->distId = DistributerUserIndex::select('licenca_distributer_tipsId')->where('userId', '=', auth()->user()->id)->first()->licenca_distributer_tipsId;
        $this->ditributerData = LicencaDistributerTip::where('id', '=', $this->distId)->first();
        $this->is_user_zeta = auth()->user()->id == 29 ? true : false;
    }

    /**
     * Modal koji menja distributera test useru
     *
     * @param mixed $id
     * 
     * @return [type]
     * 
     */
    public function promeniDistirbuteraShowModal()
    {
        $this->testUserDistributer = DistributerUserIndex::where('userId', '=', auth()->user()->id)->first()->licenca_distributer_tipsId;
        $this->promeniDitributeraModalVisible = true;
    }

    public function promeniDistributera()
    {
        DistributerUserIndex::where('userId', '=', auth()->user()->id)->update(['licenca_distributer_tipsId' => $this->testUserDistributer] );
        $this->promeniDitributeraModalVisible = false;
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        if($this->modalDistributerInfoFormVisible){
          return [
            'distributer_naziv' => ['required'],
            'distributer_adresa'  => ['required'],
            'distributer_zip'  => ['required'],
            'distributer_mesto'  => ['required'],
            'distributer_pib'  => ['required'],
            'distributer_mb'  => ['required']
          ];  
        }
        elseif($this->modalLicencaFormVisible){
            return [  
            'licenca_dist_cena' => ['required', 'numeric']
        ];
        }
    }

    /**
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateCenuLicenceShowModal($id, $naziv)
    {
        $this->l_naziv = $naziv;
        $this->modelId = $id;
        $licencaCenaRow = LicencaDistributerCena::find($id);
        $this->licenca_zeta_cena = $licencaCenaRow->licenca_zeta_cena;
        $this->licenca_dist_cena = $licencaCenaRow->licenca_dist_cena;

        $this->modalLicencaFormVisible = true; 
    }

    public function updateCenaLicence()
    {
        $this->validate();
        LicencaDistributerCena::find($this->modelId)->update(['licenca_dist_cena' => $this->licenca_dist_cena]);
        $this->modalLicencaFormVisible = false;
    }

    /**
     * [Description for editDistributerInfoShowModal]
     *
     * @return [type]
     * 
     */
    public function editDistributerInfoShowModal()
    {
        $this->ditributerModelData();

        $this->modalDistributerInfoFormVisible = true;
    }

    public function distributerInfoSave()
    {
        $this->validate();
        LicencaDistributerTip::where('id', '=', $this->distId)->update($this->loadModel());
        $this->ditributerData = LicencaDistributerTip::where('id', '=', $this->distId)->first();
        $this->modalDistributerInfoFormVisible = false;
    }
    
    private function ditributerModelData()
    {
        //return $this->ditributerModelData->attributesToArray();
        $this->distributer_naziv =  $this->ditributerData->distributer_naziv;
        $this->distributer_adresa = $this->ditributerData->distributer_adresa;
        $this->distributer_zip =    $this->ditributerData->distributer_zip;
        $this->distributer_mesto =  $this->ditributerData->distributer_mesto;
        $this->distributer_email =  $this->ditributerData->distributer_email;
        $this->distributer_pib =    $this->ditributerData->distributer_pib;
        $this->distributer_mb =     $this->ditributerData->distributer_mb;
        $this->distributer_tr =     $this->ditributerData->distributer_tr;
        $this->distributer_banka =  $this->ditributerData->distributer_banka;
        $this->distributer_tel =    $this->ditributerData->distributer_tel;
    }

    private function loadModel()
    {
        return [
            'distributer_naziv'     => ($this->distributer_naziv !=  $this->ditributerData->distributer_naziv) ? $this->distributer_naziv : $this->ditributerData->distributer_naziv,
            'distributer_adresa'    => ($this->distributer_adresa != $this->ditributerData->distributer_adresa) ? $this->distributer_adresa : $this->ditributerData->distributer_adresa,
            'distributer_zip'       => ($this->distributer_zip != $this->ditributerData->distributer_zip) ? $this->distributer_zip : $this->ditributerData->distributer_zip,
            'distributer_mesto'     => ($this->distributer_mesto != $this->ditributerData->distributer_mesto) ? $this->distributer_mesto :  $this->ditributerData->distributer_mesto,
            'distributer_email'     => ($this->distributer_email !=  $this->ditributerData->distributer_email) ? $this->distributer_email : $this->ditributerData->distributer_email,
            'distributer_pib'       => ($this->distributer_pib != $this->ditributerData->distributer_pib) ? $this->distributer_pib : $this->ditributerData->distributer_pib,
            'distributer_mb'        => ($this->distributer_mb != $this->ditributerData->distributer_mb) ? $this->distributer_mb : $this->ditributerData->distributer_mb,
            'distributer_tr'        => ($this->distributer_tr != $this->ditributerData->distributer_tr) ? $this->distributer_tr : $this->ditributerData->distributer_tr,
            'distributer_banka'     => ($this->distributer_banka != $this->ditributerData->distributer_banka) ? $this->distributer_banka : $this->ditributerData->distributer_banka,
            'distributer_tel'       => ($this->distributer_tel != $this->ditributerData->distributer_tel) ? $this->distributer_tel : $this->ditributerData->distributer_tel
        ];
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function readLicence()
    {
        return LicencaDistributerCena::select('licenca_distributer_cenas.*', 'licenca_tips.licenca_naziv', 'licenca_tips.licenca_opis')
                ->leftJoin('licenca_tips', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
                ->where('licenca_distributer_cenas.distributerId', '=', $this->distId)
                ->paginate(Config::get('global.paginate'), ['*'], 'lokacije'); 
    }

    /**
     * Koliko terminala ima distributer function.
     *
     * @return object
     */
    private function prebrojLicenceITerminaleDistributera()
    {
        return [
            'br_licenci' => LicencaDistributerTerminal::select()->where('distributerId', '=', $this->distId)->count(),
            'br_terminala' => TerminalLokacija::select()->where('distributerId', '=', $this->distId)->count()
        ];
    }

    public function render()
    { 
        return view('livewire.distributer.dashboard', [
            'licenceData' => $this->readLicence(),
            'licence_terminali' => $this->prebrojLicenceITerminaleDistributera()
        ]);
    }
}