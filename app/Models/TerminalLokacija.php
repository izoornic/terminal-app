<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class TerminalLokacija extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'terminalId',
        'lokacijaId',
        'terminal_statusId',
        'korisnikId',
        'korisnikIme',
        'updated_at',
        'blacklist',
        'distributerId'
    ];

    public static function brojTerminalaNalokaciji($id)
    {
       return TerminalLokacija::select('lokacijaId')
                ->where('lokacijaId', '=', $id)
                ->get()
                ->count();
    }
}
