<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Predmet;
use App\Models\SlusanjeStudent;
use App\Models\OrganizacionaAktivnost;
use Auth;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Models\SkolskaGodina;

class PredmetiController extends Controller
{

    /*
    vraca sve predmete
    */
    public function index(){
        
        $predmeti = SlusanjeStudent::selectRaw('slusanje.*, drze_se.*, predmeti.*, upisi.id_sk, skolska_godina.naziv as sk, (SELECT broj FROM grupe_za_predmete GP WHERE GP.id = slusanje.grupa_predavanja) as grupa_predavanja,
        (SELECT broj FROM grupe_za_predmete GP WHERE GP.id = slusanje.grupa_vezbe) as grupa_vezbe,
        (SELECT broj FROM grupe_za_predmete GP WHERE GP.id = slusanje.grupa_don) as grupa_don')->whereIn('id_upis', Student::upisi(Auth::user()->id))->join('drze_se', 'drze_se.id', '=', 'slusanje.id_drzanje')->join('predmeti', 'predmeti.sifra', '=', 'drze_se.sifra_predmeta')->join('upisi', 'upisi.id', '=', 'slusanje.id_upis')->join('skolska_godina', 'skolska_godina.id', '=', 'upisi.id_sk')->get();
        
        return view('student.predmeti_svi', ['predmeti'=>$predmeti]);

    }

    /*
    */
    private function getSemestri($pu){
        $semestri=[];
        $val = $pu->godina;
        $br_puta_tekuce_godine = (DB::table('upisi')
        ->selectRaw("COUNT(*) as cnt")
        ->where('id_student', Auth::user()->id)
        ->where('godina', $pu->godina)
        ->first())->cnt;
        switch($val){
            case 1:
                $semestri[] = 1;
                $semestri[] = 2;
                break;
            case 2:
                $semestri[] = 3;
                $semestri[] = 4;
                break;
            case 3:
                $semestri[] = 5;
                $semestri[] = 6;
                break;
            case 4:
                $semestri[] = 7;
                $semestri[] = 8;
                break;
        }
        $br_nepolozenih_prva = 60-PredmetiController::getBrojPolozenih(1);
        $br_nepolozenih_druga = 60-PredmetiController::getBrojPolozenih(2);
        $br_nepolozenih_treca = 60-PredmetiController::getBrojPolozenih(3);
        
        if($br_nepolozenih_prva && $val!=1){
            if(!in_array(1, $semestri))$semestri[] = 1;
            if(!in_array(2, $semestri))$semestri[] = 2;
        }
        if($br_nepolozenih_druga && $val>2){
            if(!in_array(3, $semestri))$semestri[] = 3;
            if(!in_array(4, $semestri))$semestri[] = 4;
        }
        if($br_nepolozenih_treca && $val>3){
            if(!in_array(5, $semestri))$semestri[] = 5;
            if(!in_array(6, $semestri))$semestri[] = 6;
        }
        if($val==1){
            if($br_puta_tekuce_godine>1){
                if(!in_array(3, $semestri))$semestri[] = 3;
                if(!in_array(4, $semestri))$semestri[] = 4;
            }
        }else if($val==2){
            if($br_nepolozenih_prva<=6 && $br_puta_tekuce_godine==1){
                if(!in_array(5, $semestri))$semestri[] = 5;
                if(!in_array(6, $semestri))$semestri[] = 6;
            }
            else if(($br_nepolozenih_prva+$br_nepolozenih_druga)<46){
                if(!in_array(7, $semestri))$semestri[] = 7;
                if(!in_array(8, $semestri))$semestri[] = 8;
            }
        }
        else if($val==3){
            if(($br_nepolozenih_prva+$br_nepolozenih_druga+$br_nepolozenih_treca)<60){
                if(!in_array(7, $semestri))$semestri[] = 7;
                if(!in_array(8, $semestri))$semestri[] = 8;
            }
        }

        return $semestri;
    }
    private function getPredmetiBezGrupe($poslednji_upis, $semestri){
        return DB::table('drze_se')
        ->selectRaw("drze_se.*, drze_se.id as id_drzanje, predmeti.*, (SELECT id FROM slusanje WHERE id_drzanje = drze_se.id AND id_upis=".$poslednji_upis->id.") as id_slusanje")
        ->join('predmeti', 'predmeti.sifra', '=', 'drze_se.sifra_predmeta')
        ->whereNotIn('drze_se.id',function($query) {

            $query->select('id_drzanje')->from('predmet_pripada_grupi_za_biranje');
         
         })
        ->where('id_program',$poslednji_upis->id_program)
        ->whereIn('semestar', $semestri)
        ->orderBy('semestar', 'asc')
        ->orderBy('espb', 'desc')
        ->orderBy('sifra_predmeta', 'asc')
        ->get();
    }
    public function getPredmetiSaZavisnomGrupom($poslednji_upis, $semestri){
        return DB::table('drze_se')
        ->selectRaw("drze_se.*, predmeti.*, drze_se.id as id_drzanje, predmet_pripada_grupi_za_biranje.*, (SELECT id FROM slusanje WHERE id_drzanje = drze_se.id AND id_upis=".$poslednji_upis->id.") as id_slusanje")
        ->join('predmeti', 'predmeti.sifra', '=', 'drze_se.sifra_predmeta')
        ->whereIn('drze_se.id',function($query) {

            $query->select('id_drzanje')->from('predmet_pripada_grupi_za_biranje');
         
         })
        ->where('id_program',$poslednji_upis->id_program)
        ->whereIn('semestar', $semestri)
        ->join('predmet_pripada_grupi_za_biranje', 'predmet_pripada_grupi_za_biranje.id_drzanje', '=','drze_se.id')
        ->whereIn('predmet_pripada_grupi_za_biranje.id_grupe',function($query) {

            $query->select('grupe_za_biranje_predmeta.id')->from('grupe_za_biranje_predmeta')->whereNotNull('natgrupa');
         
         })
       
        ->orderBy('semestar', 'asc')
        ->orderBy('espb', 'desc')
        ->orderBy('sifra_predmeta', 'asc')
        ->get();
    }

    private function getPredmetiSaNezavisnomGrupom($poslednji_upis, $semestri, $zavisni_predmeti_sifre){
        return DB::table('drze_se')
        ->selectRaw("drze_se.*, predmeti.*, predmet_pripada_grupi_za_biranje.*, (SELECT id FROM slusanje WHERE id_drzanje = drze_se.id AND id_upis=".$poslednji_upis->id.") as id_slusanje")
        ->join('predmeti', 'predmeti.sifra', '=', 'drze_se.sifra_predmeta')
        ->whereIn('drze_se.id',function($query) {

            $query->select('id_drzanje')->from('predmet_pripada_grupi_za_biranje');
         
         })
        ->whereNotIn('sifra_predmeta', $zavisni_predmeti_sifre)
        ->where('id_program',$poslednji_upis->id_program)
        ->whereIn('semestar', $semestri)
        ->join('predmet_pripada_grupi_za_biranje', 'predmet_pripada_grupi_za_biranje.id_drzanje', '=','drze_se.id')
        ->whereIn('predmet_pripada_grupi_za_biranje.id_grupe',function($query) {

            $query->select('grupe_za_biranje_predmeta.id')->from('grupe_za_biranje_predmeta')->whereNull('natgrupa');
         
         })
        ->orderBy('semestar', 'asc')
        ->orderBy('espb', 'desc')
        ->orderBy('sifra_predmeta', 'asc')
        ->get();
    }
    private function getGrupeNezavisne($poslednji_upis, $semestri, $za_prikaz=false){
        return DB::table('drze_se')
        ->selectRaw('DISTINCT grupe_za_biranje_predmeta.id, grupe_za_biranje_predmeta.naziv as grupa, grupe_za_biranje_predmeta.min, grupe_za_biranje_predmeta.maks, grupe_za_biranje_predmeta.poruka, grupe_za_biranje_predmeta.semestar_grupe, semestar')
        ->where('id_program',$poslednji_upis->id_program)
        ->whereIn('semestar', $semestri)
        ->whereNull('natgrupa')
        ->join('predmet_pripada_grupi_za_biranje', 'predmet_pripada_grupi_za_biranje.id_drzanje', '=','drze_se.id')
        ->join('grupe_za_biranje_predmeta', 'grupe_za_biranje_predmeta.id', '=', 'predmet_pripada_grupi_za_biranje.id_grupe')
        ->orderBy('semestar', 'asc')
        ->orderBy('status', 'desc')
        ->orderBy('id', 'asc')
        ->get();
    }
    private function getGrupeZavisne($poslednji_upis, $semestri, $za_prikaz=false){
        return DB::table('drze_se')
        ->selectRaw('DISTINCT grupe_za_biranje_predmeta.id, grupe_za_biranje_predmeta.*, semestar')
        ->where('id_program',$poslednji_upis->id_program)
        ->whereIn('semestar', $semestri)
        ->whereNotNull('natgrupa')
        ->join('predmet_pripada_grupi_za_biranje', 'predmet_pripada_grupi_za_biranje.id_drzanje', '=','drze_se.id')
        ->join('grupe_za_biranje_predmeta', 'grupe_za_biranje_predmeta.id', '=', 'predmet_pripada_grupi_za_biranje.id_grupe')
        ->orderBy('semestar', 'asc')
        ->orderBy('status', 'desc')
        ->orderBy('id', 'asc')
        ->get();
    }
    public function create(){
        if(!OrganizacionaAktivnost::uToku('Бирање предмета')) return redirect()->route('home')->withErrors(["грешка_бирање_предмета" => "Активност <strong>Бирање предмета</strong> није у току!"]);
        $poslednji_upis = Student::poslednji_upis(Auth::user()->id);
        
        $semestri=PredmetiController::getSemestri($poslednji_upis);
        $predmeti_bez_grupe = PredmetiController::getPredmetiBezGrupe($poslednji_upis, $semestri);
        $predmeti_sa_zavisnom_grupom = PredmetiController::getPredmetiSaZavisnomGrupom($poslednji_upis, $semestri);
        $zavisni_predmeti_sifre = $predmeti_sa_zavisnom_grupom->pluck('sifra_predmeta');
        $predmeti_sa_nezavisnom_grupom = PredmetiController::getPredmetiSaNezavisnomGrupom($poslednji_upis, $semestri, $zavisni_predmeti_sifre);
        
        
        $grupe_nezavisne = PredmetiController::getGrupeNezavisne($poslednji_upis, $semestri);
        $grupe_zavisne = PredmetiController::getGrupeZavisne($poslednji_upis, $semestri);
        
       
        
        $polozeni = DB::table('ispitne_prijave')->where('id_upis', $poslednji_upis->id)->orderBy('created_at')->where('zakljucana', 1)->where('ocena', '>=', 6)->get();
        $brojevi = DB::table('slusanje')
        ->selectRaw('drze_se.sifra_predmeta, count(*) as cnt')
        ->join('upisi', 'upisi.id','=','id_upis')
        ->join('drze_se', 'drze_se.id','=', 'id_drzanje')
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->groupBy('drze_se.sifra_predmeta')
        ->get();
        return view('student.biranje_predmeta', ['semestri'=>$semestri, 'predmeti_bez_grupe'=>$predmeti_bez_grupe, 'predmeti_sa_zavisnom_grupom'=>$predmeti_sa_zavisnom_grupom, 'predmeti_sa_nezavisnom_grupom'=>$predmeti_sa_nezavisnom_grupom, 'grupe_zavisne'=>$grupe_zavisne, 'grupe_nezavisne'=>$grupe_nezavisne, 'polozeni'=>$polozeni, 'brojevi'=>$brojevi]);
    }
        
    /*
    vraca predmete iz tekuce skolske godine
    */
    public function show(){
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
        

        $id_drzanja = $predmeti->pluck('sifra_predmeta');

        
        $predmetne_obaveze = DB::table('predmetne_obaveze')
        ->selectRaw('predmetne_obaveze.id, id_grupe_predmeta, naziv, maks_broj_poena, procenat_u_ukupnoj_oceni, broj_prilika_za_polaganje, opis_pravila, jeste_ispit, ima_drugi_deo')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->whereIn('id_predmeta', $id_drzanja)
        ->groupByRaw('id_grupe_predmeta, predmetne_obaveze.id, naziv, maks_broj_poena, procenat_u_ukupnoj_oceni, broj_prilika_za_polaganje, opis_pravila, jeste_ispit, ima_drugi_deo')
        ->get();
        
        $angazovani = array();
        
        foreach($predmeti as $predmet){
   
            $angazovani[$predmet->sifra_predmeta] = DB::table('nastavnici_drze_grupe_predmeta')
            ->selectRaw("users.id, users.ime, users.prezime, users.email, grupe_za_predmete.tip, grupe_za_predmete.broj,zvanja.naziv_zvanja, izbori_u_zvanje.id_zvanja, izbori_u_zvanje.strucno_zvanje")
            ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'nastavnici_drze_grupe_predmeta.id_grupe_predmeta')
            ->where('grupe_za_predmete.id_predmeta', $predmet->sifra_predmeta)
            /*->where(function($q) use ($predmet){
                $q->whereRAW('(tip = "П" AND broj = '.$predmet->grupa_predavanja.')')
                ->orWhere('tip', '<>', 'П');
            })*/
            ->join('nastavnici', 'nastavnici.id_korisnik', '=', 'nastavnici_drze_grupe_predmeta.id_nastavnika')
            ->join('users', 'users.id', '=', 'nastavnici.id_korisnik')
            ->join('izbori_u_zvanje', 'izbori_u_zvanje.id', '=', 'nastavnici.id_poslednjeg_izbora')
            ->join('zvanja', 'zvanja.id', '=', 'id_zvanja')
            ->groupbyraw('users.id, users.ime, users.prezime, users.email, grupe_za_predmete.tip, grupe_za_predmete.broj, zvanja.naziv_zvanja, izbori_u_zvanje.id_zvanja, izbori_u_zvanje.strucno_zvanje')
            ->get(); 
                 
        }
        
        
        
        return view('student.predmeti_tekuca', ['predmeti'=>$predmeti, 'angazovani'=>$angazovani, 'predmetne_obaveze'=>$predmetne_obaveze]);
        
    }
    
    public function store(Request $request){
        if(!OrganizacionaAktivnost::uToku('Бирање предмета')) {
            return redirect()->back()->withErrors(["грешка_бирање_предмета" => "Активност <strong>Бирање предмета</strong> није у току!"]);
        }
        $poslednji_upis = Student::poslednji_upis(Auth::user()->id);
        
        $semestri=PredmetiController::getSemestri($poslednji_upis);
        $predmeti_bez_grupe = PredmetiController::getPredmetiBezGrupe($poslednji_upis, $semestri);
        $predmeti_sa_zavisnom_grupom = PredmetiController::getPredmetiSaZavisnomGrupom($poslednji_upis, $semestri);
        $zavisni_predmeti_sifre = $predmeti_sa_zavisnom_grupom->pluck('sifra_predmeta');
        $predmeti_sa_nezavisnom_grupom = PredmetiController::getPredmetiSaNezavisnomGrupom($poslednji_upis, $semestri, $zavisni_predmeti_sifre);
        $grupe_nezavisne = PredmetiController::getGrupeNezavisne($poslednji_upis, $semestri);
        $grupe_zavisne = PredmetiController::getGrupeZavisne($poslednji_upis, $semestri);

        $polozeni = DB::table('ispitne_prijave')->orderBy('created_at')->where('zakljucana', 1)->where('ocena', '>=', 6)->get();

       
        //**************rad********************

        DB::beginTransaction();

        DB::table('slusanje')
        ->where('id_upis', $poslednji_upis->id)
        ->join('drze_se', 'drze_se.id', '=', 'id_drzanje')
        ->whereNotIn('sifra_predmeta', $polozeni->pluck('sifra_predmeta'))
        ->delete();

        $espb_total = 0;
        $min_espb = 0;
        //obrada obaveznih
        foreach($semestri as $semestar){
            $naziv = "obavezni".$semestar;
            if($request->input($naziv)){
                foreach($request->input($naziv) as $obavezni){
                    if($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first() && ($polozeni->pluck('sifra_predmeta'))->contains($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())){
                        $gp = DB::table('grupe_za_predmete')
                        ->where('id_predmeta', ($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->sifra)
                        ->where('tip', "П")
                        ->where('broj', 1)
                        ->where('id_sk', SkolskaGodina::tekuca()->id)
                        ->first();
                        $gv = DB::table('grupe_za_predmete')
                        ->where('id_predmeta', ($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->sifra)
                        ->where('tip', "В")
                        ->where('broj', 1)
                        ->where('id_sk', SkolskaGodina::tekuca()->id)
                        ->first();
                        $gd =DB::table('grupe_za_predmete')
                        ->where('id_predmeta', ($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->sifra)
                        ->where('tip', "Л")
                        ->where('broj', 1)
                        ->where('id_sk', SkolskaGodina::tekuca()->id)
                        ->first();
                        try{
                            SlusanjeStudent::firstOrCreate([
                                'id_drzanje'=>$obavezni,
                                'id_upis'=>$poslednji_upis->id,
                                'put'=>(DB::table('slusanje')
                                ->selectRaw('COUNT(slusanje.id) as cnt')
                                ->join('upisi', 'upisi.id', '=','id_upis')
                                ->join('drze_se', 'drze_se.id', '=', 'id_drzanje')
                                ->where('id_student', Auth::user()->id)
                                ->where('sifra_predmeta', ($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->sifra)
                                ->first()
                                )->cnt+1,
                                'grupa_predavanja' => isset($gp->id) ? $gp->id : null,
                                'grupa_vezbe' => isset($gv->id) ? $gp->id : null,
                                'grupa_don' => isset($gd->id) ? $gp->id : null
                            ]);
                            $espb_total += ($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->espb;
                            if(($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->espb<$min_espb) $min_espb = ($predmeti_bez_grupe->where('id_drzanje', $obavezni)->first())->espb;
                        }catch(\Illuminate\Database\QueryException $e) {
                            DB::rollBack();
                            $db_error_txt = 'Дошло је до грешке! Молимо пробајте поново. Уколико се грешка настави, контактирајте студентски одсек!';
                            //echo $e->get_class;
                            return redirect()->back()->withErrors(['DB error'=>$db_error_txt, 'error_details'=>$e->getMessage()])->withInput();
                        }
                    }

                }
            } 
        }
        
        //obrada izbornih
        foreach($semestri as $semestar){
            foreach($grupe_nezavisne as $grupa){
    
                $grupa_sum = 0;
                if($grupa->semestar_grupe==$semestar){
                    $naziv = $semestar."|".$grupa->id;
                    if($request->input($naziv)){
                        foreach($request->input($naziv) as $izborni){
                            if(($polozeni->pluck('sifra_predmeta'))->contains(($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)){
                            
                            }else{
                                $gp = DB::table('grupe_za_predmete')
                                ->where('id_predmeta', ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                ->where('tip', "П")
                                ->where('broj', 1)
                                ->where('id_sk', SkolskaGodina::tekuca()->id)
                                ->first();
                                $gv = DB::table('grupe_za_predmete')
                                ->where('id_predmeta', ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                ->where('tip', "В")
                                ->where('broj', 1)
                                ->where('id_sk', SkolskaGodina::tekuca()->id)
                                ->first();
                                $gd =DB::table('grupe_za_predmete')
                                ->where('id_predmeta', ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                ->where('tip', "Л")
                                ->where('broj', 1)
                                ->where('id_sk', SkolskaGodina::tekuca()->id)
                                ->first();

                                try{
                                    SlusanjeStudent::firstOrCreate([
                                        'id_drzanje'=>$izborni,
                                        'id_upis'=>$poslednji_upis->id,
                                        'put'=>(DB::table('slusanje')
                                        ->selectRaw('COUNT(slusanje.id) as cnt')
                                        ->join('upisi', 'upisi.id', '=','id_upis')
                                        ->join('drze_se', 'drze_se.id', '=', 'id_drzanje')
                                        ->where('id_student', Auth::user()->id)
                                        ->where('sifra_predmeta', ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                        ->first()
                                        )->cnt+1,
                                        'grupa_predavanja' => isset($gp->id) ? $gp->id : null,
                                        'grupa_vezbe' => isset($gv->id) ? $gp->id : null,
                                        'grupa_don' => isset($gd->id) ? $gp->id : null
                                    ]);
                                    $espb_total += ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                    $grupa_sum += ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                    if(($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->espb<$min_espb) $min_espb = ($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                    if($grupa_sum>$grupa->maks){
                                        DB::rollBack();
                                        return redirect()->back()->withErrors(['check'=>"Премашили сте број ЕСПБ за групу ".$grupa->grupa.": ".$grupa->poruka])->withInput();
                                    }

                                    
                                }catch(\Illuminate\Database\QueryException $e) {
                                    DB::rollBack();
                                    //print_r("errrrorrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr");
                                    return redirect()->back()->withErrors(['DB error'=>'Дошло је до грешке! Молимо пробајте поново. Уколико се грешка настави, контактирајте студентски одсек!'])->withInput();
                                }
                            }
                        }
                    }
                
                    foreach($grupe_zavisne as $gr){
                        $gr_total = 0;
                        if($gr->natgrupa == $grupa->id){
                            $naziv = $semestar."|".$grupa->id."|".$gr->id;
                            if($request->input($naziv)){
                                foreach($request->input($naziv) as $izborni){
                                    if(($polozeni->pluck('sifra_predmeta'))->contains(($predmeti_sa_nezavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)){
                            
                                    }else{
                                        $gp = DB::table('grupe_za_predmete')
                                        ->where('id_predmeta', ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                        ->where('tip', "П")
                                        ->where('broj', 1)
                                        ->where('id_sk', SkolskaGodina::tekuca()->id)
                                        ->first();
                                        $gv = DB::table('grupe_za_predmete')
                                        ->where('id_predmeta', ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                        ->where('tip', "В")
                                        ->where('broj', 1)
                                        ->where('id_sk', SkolskaGodina::tekuca()->id)
                                        ->first();
                                        $gd =DB::table('grupe_za_predmete')
                                        ->where('id_predmeta', ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                        ->where('tip', "Л")
                                        ->where('broj', 1)
                                        ->where('id_sk', SkolskaGodina::tekuca()->id)
                                        ->first();
                                        try{
                                            
                                            SlusanjeStudent::firstOrCreate([
                                                'id_drzanje'=>$izborni,
                                                'id_upis'=>$poslednji_upis->id,
                                                'put'=>(DB::table('slusanje')
                                                ->selectRaw('COUNT(slusanje.id) as cnt')
                                                ->join('upisi', 'upisi.id', '=','id_upis')
                                                ->join('drze_se', 'drze_se.id', '=', 'id_drzanje')
                                                ->where('id_student', Auth::user()->id)
                                                ->where('sifra_predmeta', ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->sifra)
                                                ->first()
                                                )->cnt+1,
                                                'grupa_predavanja' => isset($gp->id) ? $gp->id : null,
                                                'grupa_vezbe' => isset($gv->id) ? $gp->id : null,
                                                'grupa_don' => isset($gd->id) ? $gp->id : null
                                            ]);
                                            $espb_total += ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                            $grupa_sum += ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                            $gr_total += ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                            if(($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->espb<$min_espb) $min_espb = ($predmeti_sa_zavisnom_grupom->where('id_drzanje', $izborni)->first())->espb;
                                            if($gr_total>$gr->maks){
                                                DB::rollBack();
                                                
                                                return redirect()->back()->withErrors(['check'=>"Премашили сте број ЕСПБ за групу ".$gr->naziv.": ".$gr->poruka])->withInput();
                                            }
                                            if($grupa_sum>$grupa->maks){
                                                DB::rollBack();
                                                
                                                return redirect()->back()->withErrors(['check'=>"Премашили сте број ЕСПБ за групу ".$grupa->grupa.": ".$grupa->poruka])->withInput();
                                            }
                                        }catch(\Illuminate\Database\QueryException $e) {
                                            DB::rollBack();
                                            print_r($e);
                                            //return redirect()->back()->withErrors(['DB error'=>'Дошло је до грешке! Молимо пробајте поново. Уколико се грешка настави, контактирајте студентски одсек!'])->withInput();
                                        }
                                    }
                                }
                            }

                        }
                        if(!($gr_total == 0 && $gr->min==0) && $gr_total<$gr->min){

                            DB::rollBack();
                            return redirect()->back()->withErrors(['check'=>"Нисте пријавили довољан минималан број ЕСПБ за групу ".$gr->naziv.": ".$gr->poruka])->withInput();
                        }
                    }
              
                    if(!($grupa_sum>=$grupa->min)){
                        DB::rollBack();
                        return redirect()->back()->withErrors(['check'=>"Нисте пријавили довољан минималан број ЕСПБ за групу ".$grupa->grupa.": ".$grupa->poruka])->withInput();
                    }
                }
            }
        }
       
        //provera espb
        $res = PredmetiController::checkESPB($espb_total, $poslednji_upis, $min_espb);
        if(is_array($res)){
            DB::rollBack();
            return redirect()->back()->withErrors($res)->withInput();
        }
        DB::commit();
        return redirect()->route('predmeti_tekuca')->with('success', 'Успешно су пријављени предмети!');
     
    }
    private function getBrojPolozenih($godina){
        return (DB::table('ispitne_prijave')
        ->selectRaw('COUNT(*) as br')
        ->where('zakljucana', 1)
        ->where('ocena', '>=', 6)
        ->join('upisi', 'upisi.id', '=', 'id_upis')
        ->where('godina', $godina)
        ->where('id_student', Auth::user()->id)
        ->first())->br;
    }
    private function checkESPB($espb, $poslednji_upis, $min){
        $br_puta_tekuce_godine = DB::table('upisi')
        ->selectRaw("COUNT(*) as cnt")
        ->where('id_student', Auth::user()->id)
        ->where('godina', $poslednji_upis->godina)
        ->first();
        $broj_nepolozenih_prva_godina = 60 -(PredmetiController::getBrojPolozenih(1));
        $broj_nepolozenih_druga_godina = 60 -(PredmetiController::getBrojPolozenih(2));
        $broj_nepolozenih_treca_godina = 60 -(PredmetiController::getBrojPolozenih(3));
        
        if($poslednji_upis->godina == 1 && $br_puta_tekuce_godine->cnt==1){
            if($espb>60){
                return ['check'=>'Морате пријавити тачно 60 ЕСПБ!'];
            }
        }
        else{
            if($poslednji_upis->status=="budzet"){
                if(($espb-$min)> (($poslednji_upis->godina==3 && ($br_nepolozenih_prva+$br_nepolozenih_druga)==0) ? 72 : 66)){
                    return ['check'=>'Пријавили сте '.($espb-$min).' а дозвољено је 66'];
                }
            }else{
                if(($espb-$min)>36){
                    return ['check'=>'Пријавили сте '.($espb-$min).' а дозвољено је 36'];
                }
            }
        }
    }
}
