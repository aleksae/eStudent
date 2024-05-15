<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrijavaIspita extends Model
{
    protected $table = 'ispitne_prijave';
    use HasFactory;
    protected $fillable = ['prisustvo'];
}
