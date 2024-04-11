<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class DezurstvaController extends Controller
{
    /*pregled dezurstava za nastavnika*/
    public function index(){
        $id_nastavnika = Auth::user()->id;

        $dezurstva = DB::table('dezurstva')
        ->selectRaw('dezurstva.id_dezurstva as id_dezurstva, predmeti.naziv as predmet, predmeti.sifra as sifra, predmetne_obaveze.naziv as obaveza, predmetne_obaveze.jeste_ispit, rokovi.id as id_rok, rokovi.naziv_skraceno as rok, predmetna_grupa_postoji_u_roku.datum, predmetna_grupa_postoji_u_roku.vreme, 
        predmetna_grupa_postoji_u_roku.poruka, predmetna_grupa_postoji_u_roku.id_zbornog_mesta as zborno_mesto, prostorije.*, zgrade.*')
        ->where('id_nastavnika', $id_nastavnika)
        
        ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id', '=', 'dezurstva.id_predmetne_grupe_u_roku')
        ->join('rokovi', 'rokovi.id', '=', 'id_rok')
        ->where('rokovi.arhiviran',0)
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        
        ->leftjoin('prostorije', 'prostorije.id', '=', 'sala')
        ->leftjoin('zgrade', 'zgrade.id', '=', 'id_zgrade')
        ->orderBy('predmetna_grupa_postoji_u_roku.datum')
        ->orderBy('predmetna_grupa_postoji_u_roku.vreme')
        ->get();
        
        foreach($dezurstva as $dezurstvo){
            $res = DB::table('prostorije')
            ->where('prostorije.id', $dezurstvo->zborno_mesto)
            ->join('zgrade', 'zgrade.id', '=', 'id_zgrade')
            ->first();
            
            $dezurstvo->zborno_mesto = "<strong>".$res->pun_naziv."</strong> - ".$res->lokacija.", ".$res->naziv_zgrade;
        }
        return view("zaposleni.dezurstva", ['dezurstva'=>$dezurstva]);
    }
}
