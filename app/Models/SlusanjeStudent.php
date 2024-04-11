<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlusanjeStudent extends Model
{
    use HasFactory;
    protected $table="slusanje";
    protected $fillable=['id_drzanje', 'id_upis', 'put', 'grupa_predavanja', 'grupa_vezbe', 'grupa_don'];
    
}
