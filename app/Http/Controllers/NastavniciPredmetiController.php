<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SkolskaGodina;

class NastavniciPredmetiController extends Controller
{
    public function show(){
        $angazovanja = DB::table('nastavnici_drze_grupe_predmeta')
        ->where('id_nastavnika', Auth::user()->id)
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->join('predmeti', 'predmeti.sifra', '=', 'id_predmeta')
        ->orderBy('sifra')
        ->orderBy('tip')
        ->orderBy('broj')
        ->get();
        return view('zaposleni.angazovanja',['angazovanja'=>$angazovanja]);
    }
}
