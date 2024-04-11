<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrganizacionaAktivnost extends Model
{
    use HasFactory;

    public static function uToku($naziv_aktivnosti){
        $danas = Carbon::now()->format('Y-m-d h:i');
        $rezultat = DB::table('organizacione_aktivnosti')->where('naziv', $naziv_aktivnosti)->where('pocetak','<', $danas)->where('kraj','>',$danas)->first();
        if($rezultat==null) return false;
        else return true;
    }
    public static function tekuceAktivnosti(){
        $danas = Carbon::now()->format('Y-m-d h:i');
        $rezultat = DB::table('organizacione_aktivnosti')->where('pocetak','<', $danas)->where('kraj','>',$danas)->get();
        return $rezultat;
    }
}
