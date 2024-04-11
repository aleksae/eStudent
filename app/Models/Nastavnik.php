<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nastavnik extends Model
{
    use HasFactory;
    protected $table = "nastavnici";
    public static function formatiraj_ime($ime, $prezime,$id_zvanje, $zvanje, $strucno_zvanje){
        $ret = "";
        if($id_zvanje==1 || $id_zvanje==2 || $id_zvanje==3 || $id_zvanje==4) $ret .= "др ";
        if(str_contains($strucno_zvanje, "мастер")) $ret .= " мс. ";
        $ret .= $ime." ".$prezime.", ";
        $ret .= $zvanje;
        return $ret;
        
    }
}
