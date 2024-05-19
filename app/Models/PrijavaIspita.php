<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrijavaIspita extends Model
{
    use HasFactory;

    protected $table = 'ispitne_prijave';


    protected $fillable = [
        'id_upis',
        'broj_poena',
        'ocena',
        'zakljucana',
        'potpisao',

    ];
}
