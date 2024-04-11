<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upis;
use Illuminate\Support\Facades\DB;
use Auth;

class IspitiController extends Controller
{
    
    public function polozeni(){
        $prolazna_ocena = 6;


        $upisi = Upis::where('id_student', Auth::user()->id)->get();
        $upisi = $upisi->pluck('id');
        $polozeni_ispiti = DB::table('ispitne_prijave')
        ->selectRaw('ispitne_prijave.ocena, predmetna_grupa_postoji_u_roku.datum, rokovi.naziv_skraceno, predmeti.naziv, predmeti.sifra, predmeti.espb, users.ime, users.prezime')
        ->whereIn('id_upis', $upisi)
        ->where('ocena','>=',$prolazna_ocena)
        ->where('zakljucana',1)
        ->where('ispitne_prijave.grupa_obaveza', 0)
        ->join('predmetna_grupa_postoji_u_roku', 'ispitne_prijave.id_grupe_u_roku', '=', 'predmetna_grupa_postoji_u_roku.id')
        ->join('rokovi', 'rokovi.id', '=', 'predmetna_grupa_postoji_u_roku.id_rok')
        ->join('predmeti', 'predmeti.sifra','=', 'ispitne_prijave.sifra_predmet')
        ->join('users', 'users.id','=','ispitne_prijave.potpisao')
        ->orderBy('rokovi.id', 'desc')
        ->orderBy('predmetna_grupa_postoji_u_roku.datum', 'asc')
        ->orderBy('predmeti.sifra', 'asc')
        ->get();

        $polozeni_ispiti_2 = DB::table('ispitne_prijave')
        ->selectRaw('ispitne_prijave.ocena, grupe_predmetnih_grupa_u_roku.datum, rokovi.naziv_skraceno, predmeti.naziv, predmeti.sifra, predmeti.espb, users.ime, users.prezime')
        ->whereIn('id_upis', $upisi)
        ->where('ocena','>=',$prolazna_ocena)
        ->where('zakljucana',1)
        ->where('ispitne_prijave.grupa_obaveza', 1)
        ->join('grupe_predmetnih_grupa_u_roku', 'ispitne_prijave.id_grupe_u_roku', '=', 'grupe_predmetnih_grupa_u_roku.id')
        ->join('rokovi', 'rokovi.id', '=', 'grupe_predmetnih_grupa_u_roku.id_rok')
        ->join('predmeti', 'predmeti.sifra','=', 'ispitne_prijave.sifra_predmet')
        ->join('users', 'users.id','=','ispitne_prijave.potpisao')
        ->orderBy('rokovi.id', 'desc')
        ->orderBy('grupe_predmetnih_grupa_u_roku.datum', 'asc')
        ->orderBy('predmeti.sifra', 'asc')
        ->get();

        $polozeni_ispiti = $polozeni_ispiti->merge($polozeni_ispiti_2);
        return view('student.polozeni_ispiti',['polozeni_ispiti'=>$polozeni_ispiti]);
    }

    public function neuspesna(){

        $prolazna_ocena = 6;


        $upisi = Upis::where('id_student', Auth::user()->id)->get();
        $upisi = $upisi->pluck('id');
        $polaganja = DB::table('ispitne_prijave')
        ->selectRaw('ispitne_prijave.ocena, predmetna_grupa_postoji_u_roku.datum, rokovi.naziv_skraceno, predmeti.naziv, predmeti.sifra, predmeti.espb, users.ime, users.prezime')
        ->whereIn('id_upis', $upisi)
        ->where('ocena','<',$prolazna_ocena)
        ->where('zakljucana',1)
        ->join('predmetna_grupa_postoji_u_roku', 'ispitne_prijave.id_grupe_u_roku', '=', 'predmetna_grupa_postoji_u_roku.id')
        ->join('rokovi', 'rokovi.id', '=', 'predmetna_grupa_postoji_u_roku.id_rok')
        ->join('predmeti', 'predmeti.sifra','=', 'ispitne_prijave.sifra_predmet')
        ->join('users', 'users.id','=','ispitne_prijave.potpisao')
        ->orderBy('rokovi.id', 'desc')
        ->orderBy('predmetna_grupa_postoji_u_roku.datum', 'asc')
        ->orderBy('predmeti.sifra', 'asc')
        ->get();
        return view('student.neuspesna_polaganja',['neuspesna'=>$polaganja]);
    }

   
}
