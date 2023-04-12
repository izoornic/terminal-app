<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaParametarTerminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'licenca_distributer_terminalId',
        'licenca_parametarId'
    ];
}
