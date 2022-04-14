<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KorisnikRadniOdnosHistory extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'korisnik_radni_odnosId',
        'korisnikId',
        'radni_odnosId',
        'created_at',
        'updated_at'
    ];
}
