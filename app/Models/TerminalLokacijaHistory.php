<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalLokacijaHistory extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'terminal_lokacijaId',
        'terminalId',
        'lokacijaId',
        'terminal_statusId',
        'korisnikId',
        'korisnikIme',
        'created_at',
        'updated_at',
        'blacklist',
        'distributerId'
    ];
}
