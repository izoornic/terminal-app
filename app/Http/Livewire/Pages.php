<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $modelId;
    public $slug;
    public $title;
    public $content;
    
    /**
     * Validation rules
     * Primenjuje validation rules pozivom f-je validate u create f-ji
     *
     * @return void
     */
    public function rules()
    {
        return[
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')->ignore($this->modelId)],
            'content' => 'required'
        ];
    }
        
    /**
     * Livewire mount function 
     * runes first when page is loaded
     *
     * @return void
     */
    public function mount()
    {
        //Reset pagination after reloading page
        $this->resetPage();
    }

    /**
     * RUn every tme title 
     * variable is updated
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->genrateSlug($value);
    }

    /**
     * Create function
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
         /*$this->modalFormVisible = false;
        $this->resetVars(); */
    }
    
    /**
     * The read function
     *
     * @return void
     */
    public function read()
    {
        return Page::paginate(5);
    }

    public function update()
    {
        $this->validate();
        Page::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

/**
 * Delete page form DB
 *
 * @return void
 */
public function delete()
{
    Page::destroy($this->modelId);
    $this->modalConfirmDeleteVisible = false;
    $this->resetPage();
}

    /**
     * Shows the form modal
     * of the create function
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }
        
    /**
     * Shows the form modal
     * in update mode
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }
    
    /**
     * Shows Modal delete popup
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
        $this->loadModel();
    }
    
    /**
     * Load the model data
     * of thia component
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }

    /**
     * The data for the model mapped 
     * in this component
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content
        ];
    }
    
    /**
     * Reserts all variables 
     * to null
     *
     * @return void
     */
    public function resetVars()
    {
        $this->modelId = null;
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }
    
    /**
     * Generate a url slug 
     * based on title 
     *
     * @param  mixed $value
     * @return void
     */
    private function genrateSlug($value)
    {
        $process1 = str_replace(' ','-', $value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
    }

    /**
     * The livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'data' => $this->read(),
        ]);
    }
}
