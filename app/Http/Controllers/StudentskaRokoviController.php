<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Rok;

class StudentskaRokoviController extends Controller
{
    public function index(){
        $rokovi = Rok::where('arhiviran',0)->get();
        $ispiti = DB::table('predmetna_grupa_postoji_u_roku')
        ->selectRaw('predmetna_grupa_postoji_u_roku.*, predmetna_grupa_postoji_u_roku.id as id_pred_gr, rokovi.*, rokovi.id as id_roka, predmetne_obaveze.*, predmetne_obaveze.naziv as obaveza, grupe_za_predmete.*, predmeti.naziv as predmet')
        ->join('rokovi', 'rokovi.id', '=', 'predmetna_grupa_postoji_u_roku.id_rok')
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        ->orderBy('datum')
        ->orderBy('vreme')
        ->orderBy('sifra')
        ->where('kraj_roka','>=',Carbon::now())
        ->get();

        /*foreach($rokovi as $rok){
            print_r($rok->naziv);
            print_r("<br>");
            foreach($predmeti_jedna_obaveza->where('id_rok', $rok->id) as $predmet){
                print_r($predmet->id_predmeta." ".$predmet->tip."".$predmet->broj." - ".$predmet->naziv);
                print_r("<br>");
            }
        }*/

        $ispiti_spojeno =  DB::table('grupe_predmetnih_grupa_u_roku')
        ->selectRaw('grupe_predmetnih_grupa_u_roku.*, grupe_predmetnih_grupa_u_roku.id as id_pred_gr, rokovi.*, rokovi.id as id_roka, predmeti.naziv as predmet')
        ->join('predmeti','predmeti.sifra','=','sifra_predmeta')
        ->join('rokovi', 'rokovi.id', '=', 'grupe_predmetnih_grupa_u_roku.id_rok')  
        ->where('kraj_roka','>=',Carbon::now())
        ->get();

        /*foreach($rokovi as $rok){
            print_r($rok->naziv);
            print_r("<br>");
            foreach($predmeti_grupa_obaveza>where('id_rok', $rok->id) as $predmet){
                print_r($predmet->id_predmeta." ".$predmet->tip."".$predmet->broj." - ".$predmet->naziv);
                print_r("<br>");
            }
        }*/

        $ispiti_spojeno_detalji = [];
        foreach($ispiti_spojeno as $gr){

            $temp_niz = explode(";",$gr->id_predmetnih_obaveza);
            $temp_niz_store=[];
            foreach($temp_niz as $t){
                $res = DB::table('predmetne_obaveze')
                ->selectRaw('predmetne_obaveze.*, grupe_za_predmete.broj as ngr')
                ->where('predmetne_obaveze.id', $t)
                ->join('grupe_za_predmete', 'id_grupe_predmeta', '=', 'grupe_za_predmete.id')
                ->first();
                
                $temp_niz_store[] = $res;
            }
            $ispiti_spojeno_detalji[$gr->id_pred_gr]=$temp_niz_store;
        }
        //print_r($ispiti);
        return view('ss.pregled_rokova', ['rokovi'=>$rokovi, 'ispiti'=>$ispiti, 'ispiti_spojeno'=>$ispiti_spojeno, 'ispiti_spojeno_detalji'=>$ispiti_spojeno_detalji]);
    }

    public function dodavanje_u_rok($id){
        $rok = Rok::where('id', $id)->first();
        return view('ss.dodaj_ispit', ["rok"=>$rok]);
    }
}
