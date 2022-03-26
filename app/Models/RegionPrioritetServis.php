<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionPrioritetServis extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'regionId',
        'lokacija_p1Id',
        'lokacija_p2Id',
        'lokacija_p3Id',
    ];
}
