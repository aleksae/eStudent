<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Predmet;
use App\Models\SlusanjeStudent;

class RasporedCasovaController extends Controller
{
    public function index(){
        $poslednji_upis = Student::poslednji_upis(Auth::user()->id);
        $rokovi = DB::table('rokovi')->where('kraj_roka','<',Carbon::now())->get();
        $predmeti = SlusanjeStudent::
        selectRaw('slusanje.*, drze_se.*, predmeti.*, (SELECT broj FROM grupe_za_predmete GP WHERE GP.id = slusanje.grupa_predavanja) as grupa_predavanja,
        (SELECT broj FROM grupe_za_predmete GP WHERE GP.id = slusanje.grupa_vezbe) as grupa_vezbe,
        (SELECT broj FROM grupe_za_predmete GP WHERE GP.id = slusanje.grupa_don) as grupa_don,
        slusanje.grupa_predavanja as og_g_predavanja, slusanje.grupa_vezbe as og_g_vezbe, slusanje.grupa_don as og_g_don')
        ->where('id_upis', Student::poslednji_upis(Auth::user()->id)->id)
        ->join('drze_se', 'drze_se.id', '=', 'slusanje.id_drzanje')
        ->join('predmeti', 'predmeti.sifra', '=', 'drze_se.sifra_predmeta')
        ->get();

        $sifre = $predmeti->pluck('sifra_predmeta');
        $termini = DB::table('raspored_casova')
        ->selectRaw('raspored_casova.*, predmeti.naziv, prostorije.skraceni_naziv as prostorija')
        ->join('predmeti', 'predmeti.sifra','=','raspored_casova.sifra_predmeta')
        ->join('prostorije', 'prostorije.id','=','id_prostorije')
        ->whereIn('sifra_predmeta', $sifre)
        ->get();

        $sifre_termina = $termini->pluck('id_termina_u_rasporedu');

        $nastavnici = DB::table('nastavnik_drzi_termin_u_rasporedu')
        ->selectRaw('nastavnik_drzi_termin_u_rasporedu.*,  CONCAT(users.ime, " ", users.prezime) as ime')
        ->join('users', 'users.id','=','id_nastavnika')
        ->whereIn('id_termina_u_rasporedu', $sifre_termina)
        ->get();

        
        foreach($termini as $termin){
            //print_r($termin);
            //print_r(implode(", ",$nastavnici->where('id_termina_u_rasporedu', $termin->id_termina_u_rasporedu)->pluck('ime')->toArray()));
            //print_r(implode(", ",$nastavnici->where('id_termina_u_rasporedu', $termin->id_termina_u_rasporedu)->pluck('ime')->toArray()));
            //print_r("<br>");
        }
        
        return view('student.raspored_casova', ['termini_rasp'=>$termini, 'nastavnici'=>$nastavnici]);
    }
}
