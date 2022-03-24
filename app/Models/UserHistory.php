<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'korisnikId',
        'pozicija_tipId',
        'lokacijaId',
        'telegramId',
        'tel',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'current_team_id',
        'profile_photo_path',
    ];
}
