<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class LivewireCostumCroudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud 
        {nameOfTheClass? : The name of the class.}, 
        {nameOfTheModelClass? : The name of the model class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerates a custom livewire CRUD';
    
    /**
     * class properties here!
     *
     * @var mixed
     */
    protected $nameOfTheClass;
    protected $nameOfTheModelClass;
    protected $file;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$this->info('Oplaaaaa MILE');

        //Gather all parameters
        $this->gatherParameters();
        
        //Generate the Livewire Class File
        $this->generateLivewireCrudClassfile();

        //Generate Livewire View File
        $this->generateLivewireCrudViewFile();
    }
    
    /**
     * Gather all necessary parameters
     *
     * @return void
     */
    protected function gatherParameters()
    {
        // info f=ja vraca poruku u terminal
        /* $this->info($this->argument('nameOfTheClass'));
        $this->info($this->argument('nameOfTheModelClass')); */

        $this->nameOfTheClass = $this->argument('nameOfTheClass'); 
        $this->nameOfTheModelClass = $this->argument('nameOfTheModelClass');

        //If you did not provide names
        if(!$this->nameOfTheClass){
            $this->nameOfTheClass = $this->ask('Enter class name');
        }

        if(!$this->nameOfTheModelClass){
            $this->nameOfTheModelClass = $this->ask('Enter model class name');
        }

        //convert to studly case
        $this->nameOfTheClass = Str::studly($this->nameOfTheClass);
        $this->nameOfTheModelClass =  Str::studly($this->nameOfTheModelClass);
    }
    
    /**
     * Generates the CRUD class file
     *
     * @return void
     */
    protected function generateLivewireCrudClassfile()
    {
        //set the origin and destination for liveware class file
        $fileOrigin = base_path('/stubs/custom.livewire.crud.stub');
        $fileDestination =  base_path('/app/Http/Livewire/' . $this->nameOfTheClass . '.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This class file already exists: ' . $this->nameOfTheClass . '.php');
            $this->info('Aborting class file creation.');
            return false;
        }

        //get original string content of the file
        $fileOriginalString = $this->file->get($fileOrigin);

        $replaceFileOriginalStrings = Str::replaceArray('{{}}',
        [
            $this->nameOfTheModelClass, // Name of the model class
            $this->nameOfTheClass, // Name of the class
            $this->nameOfTheModelClass, // Name of the model class
            $this->nameOfTheModelClass, // Name of the model class
            $this->nameOfTheModelClass, // Name of the model class
            $this->nameOfTheModelClass, // Name of the model class
            $this->nameOfTheModelClass, // Name of the model class
            Str::kebab($this->nameOfTheClass), // From "FooBar" to "foo-bar"
        ],
        $fileOriginalString
        );

        //put file in destination directory
        $this->file->put($fileDestination, $replaceFileOriginalStrings);

        $this->info('Livewire class file created: ' . $fileDestination);
    }

    /**
     * generateLivewireCrudViewFile
     *
     * @return void
     */
    protected function generateLivewireCrudViewFile()
    {
        // Set the origin and destination for the livewire class file
        $fileOrigin = base_path('/stubs/custom.livewire.crud.view.stub');
        //kebab  funkcija pravi 'foo-bar' od 'fooBar'
        $fileDestination = base_path('/resources/views/livewire/' . Str::kebab($this->nameOfTheClass) . '.blade.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This view file already exists: ' . Str::kebab($this->nameOfTheClass) . '.php');
            $this->info('Aborting view file creation.');
            return false;
        }

        // Copy file to destination
        $this->file->copy($fileOrigin, $fileDestination);
        $this->info('Livewire view file created: ' . $fileDestination);
    }
}
