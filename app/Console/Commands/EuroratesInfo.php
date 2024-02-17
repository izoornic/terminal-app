<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KursEvra;

class EuroratesInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eurorates:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preuzima kurs evra i upucava ga u tabelu kurs_evras';

    /**
     * Create a new command instance.
     * Local rucno pokrenuti
     * php artisan eurorates:info
     * Cron na servery
     * /usr/local/bin/php /home/eposrs/artisan eurorates:info
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 
     * @return int
     */
    public function handle()
    {
        $url = 'https://kurs.resenje.org/api/v1/currencies/EUR/rates/today';
        $content = file_get_contents($url);
        if (empty($content)) {
            $this->info('Greška u preuzimanju podataka');
        }else{
            KursEvra::insertDailyKurs(json_decode($content, true));
            $this->info('Kurs evra za danas dodat!');
        }
        
    }
}
