<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SkolskaGodina extends Model
{
    use HasFactory;

    protected $table = 'skolska_godina';

    /*
    vraca tekucu skolsku godinu
    */
    public static function tekuca(){
        $danas = Carbon::now()->format('Y-m-d');
        $sk_godina = DB::table('skolska_godina')->where('pocetak','<', $danas)->where('kraj','>',$danas)->first();
        return $sk_godina;
    }
}
