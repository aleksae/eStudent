<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upis;
use App\Models\SkolskaGodina;

class Student extends Model
{
    use HasFactory;
    protected $table = 'studenti';

    public static function poslednji_upis($student){
        return Upis::where('id_sk', SkolskaGodina::tekuca()->id)->where('id_student', $student)->first();
    }
    public static function upisi($student){
        $upisi = Upis::where('id_student', $student)->get();
        $id = [];
        foreach($upisi as $upis){
            $id[] = $upis->id;
        }
        return $id;
    }

}
