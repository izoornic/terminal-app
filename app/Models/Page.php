<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    
    /**
     * guarded ako je prazan sav polja su fillable
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * fillable navdis polja koja popunjavas iz appa
     *
     * @var array
    
    protected $fillable = [
        'title',
        'slug',
        'content'
    ] */
}
