<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Auth;
use App\Models\Upis;
use Illuminate\Support\Facades\DB;
use App\Models\Nastavnik;
use App\Models\SkolskaGodina;

class ProfileController extends Controller
{
    public function index(){
        $student = Student::where('id_korisnika', Auth::user()->id)->first();
        $upisi =  DB::table('upisi')
        ->where('id_student', Auth::user()->id)
        ->join('programi', 'upisi.id_program', '=', 'programi.id')
        ->join('skolska_godina', 'skolska_godina.id', '=', 'upisi.id_sk')
        ->join('statuti', 'programi.id_statut', '=', 'statuti.id')
        ->leftJoin('programi as PP', 'programi.natprogram', '=', 'PP.id')
        ->select('upisi.*', 'programi.naziv as program', 'skolska_godina.naziv as sk', 'statuti.naziv as statut', 'PP.naziv as natprogram')
        ->orderBy('skolska_godina.pocetak', 'desc')
        ->get();
        $upisi_ids = $upisi->pluck('id');
        $polozeno_espb = DB::table('ispitne_prijave')
        ->selectRaw('SUM(predmeti.espb) as espb, id_upis')
        ->groupby('id_upis')
        ->whereIn('id_upis', $upisi_ids)
        ->where('zakljucana', 1)
        ->where('ocena', '>=', 6)
        ->join('predmeti', 'predmeti.sifra', '=', 'sifra_predmet')
        ->get();

        return view('student.profil', ['student'=>$student, 'upisi'=>$upisi, 'polozeno_espb'=>$polozeno_espb]);
    }
    public function show($id){
        $id = explode("-",$id);
        $id = (end($id)-17)/37;
        $nastavnik = Nastavnik::where('id_korisnik',$id)
        ->join('organizacione_jedinice', 'organizacione_jedinice.id', '=', 'id_organizaciona_jedinica')
        ->join('izbori_u_zvanje', 'izbori_u_zvanje.id', '=', 'id_poslednjeg_izbora')
        ->join('zvanja', 'zvanja.id', '=', 'id_zvanja')
        ->join('users','users.id','=','id_korisnik')
        ->leftjoin('prostorije', 'prostorije.id', '=', 'id_prostorija')
        ->leftjoin('zgrade', 'zgrade.id', '=', 'id_zgrade')
        ->first();
        $izbori_u_zvanje = Nastavnik::where('id_korisnik',$id)
        ->join('izbori_u_zvanje', 'izbori_u_zvanje.id_nastavnika', '=', 'nastavnici.id_korisnik')
        ->join('zvanja', 'zvanja.id', '=', 'id_zvanja')
        ->join('organizacione_jedinice', 'organizacione_jedinice.id', '=', 'id_organizaciona_jedinica')
        ->orderByDesc('datum_izbora')
        ->get();
        $angazovanja = DB::table('nastavnici_drze_grupe_predmeta')
        ->where('id_nastavnika', $id)
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->join('predmeti', 'predmeti.sifra', '=', 'id_predmeta')
        ->orderBy('sifra')
        ->orderBy('tip')
        ->orderBy('broj')
        ->get();
        $ind = 1;

        return view('zaposleni.profil', ['nastavnik'=>$nastavnik, 'izbori_u_zvanje'=>$izbori_u_zvanje, 'angazovanja'=>$angazovanja]);
    }
}
