<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dezurstva extends Model
{
    use HasFactory;
    protected $table = 'dezurstva';
    protected $fillable = ['status'];
    protected $primaryKey = 'id_dezurstva';
    
    public $timestamps = false;
}
