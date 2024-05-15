<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class DezurstvoUTokuController extends Controller
{
    public function show($grupa,$dezurstvoId){
        $ispit = DB::table('predmetna_grupa_postoji_u_roku')
        ->selectRaw('rokovi.naziv as rok, predmeti.naziv as predmet_naziv,predmeti.sifra as sifra_predmeta')
        ->where('predmetna_grupa_postoji_u_roku.id', $grupa)
        ->join('rokovi', 'rokovi.id', '=', 'predmetna_grupa_postoji_u_roku.id_rok')
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        ->get();
        $ispitne_prijave = DB::table('ispitne_prijave')
        ->selectRaw('ispitne_prijave.id as id_prijave, users.ime as ime, users.prezime as prezime, studenti.indeks as indeks, ispitne_prijave.prisustvo as prisutan')
        ->where('id_grupe_u_roku', $grupa)
        ->join('upisi','upisi.id','=','ispitne_prijave.id_upis')
        ->join('studenti','studenti.id_korisnika','=','upisi.id_student')
        ->join('users','users.id','=','upisi.id_student')
        ->get();
        return view("zaposleni.zapoceto_dezurstvo", ['ispitne_prijave'=>$ispitne_prijave,'grupa'=>$grupa,'ispit'=>$ispit[0],'dezurstvo'=>$dezurstvoId]);
    }
}
