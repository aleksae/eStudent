<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nastavnik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Predmet;
use App\Models\SkolskaGodina;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class UpravljajAngazovanjimaController extends Controller
{
    public function index(){
        $id_org_jed = (Nastavnik::where('id_korisnik', Auth::user()->id)->first())->id_organizaciona_jedinica;
        $organizaciona_jedinica = DB::table('organizacione_jedinice')->where('id', $id_org_jed)->first();
        $predmeti = Predmet::where('id_katedre', $id_org_jed)
        ->selectRaw('predmeti.sifra, predmeti.naziv, predmeti.tip_studija, programi.naziv as program, drze_se.semestar, drze_se.status, programi.skracenica')
        ->join('drze_se', 'drze_se.sifra_predmeta', '=', 'sifra')
        ->join('programi','programi.id', '=', 'id_program')
        ->orderBy('semestar')
        ->orderBy('sifra')
        ->get();
        $predmeti_sifre = $predmeti->unique('sifra')->pluck('sifra');
        $grupe = DB::table('grupe_za_predmete')
        ->whereIn('id_predmeta', $predmeti_sifre)
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->get();
        $angazovani=[];
        foreach($predmeti as $predmet){
            $angazovani[$predmet->sifra] = DB::table('nastavnici_drze_grupe_predmeta')
                ->selectRaw("users.id, users.ime, users.prezime, users.email, grupe_za_predmete.tip, grupe_za_predmete.broj,zvanja.naziv_zvanja, izbori_u_zvanje.id_zvanja, izbori_u_zvanje.strucno_zvanje")
                ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'nastavnici_drze_grupe_predmeta.id_grupe_predmeta')
                ->where('grupe_za_predmete.id_predmeta', $predmet->sifra)
                ->where('id_sk', SkolskaGodina::tekuca()->id)
                /*->where(function($q) use ($predmet){
                    $q->whereRAW('(tip = "П" AND broj = '.$predmet->grupa_predavanja.')')
                    ->orWhere('tip', '<>', 'П');
                })*/
                ->join('nastavnici', 'nastavnici.id_korisnik', '=', 'nastavnici_drze_grupe_predmeta.id_nastavnika')
                ->join('users', 'users.id', '=', 'nastavnici.id_korisnik')
                ->join('izbori_u_zvanje', 'izbori_u_zvanje.id', '=', 'nastavnici.id_poslednjeg_izbora')
                ->join('zvanja', 'zvanja.id', '=', 'id_zvanja')
                ->groupbyraw('users.id, users.ime, users.prezime, users.email, grupe_za_predmete.tip, grupe_za_predmete.broj, zvanja.naziv_zvanja, izbori_u_zvanje.id_zvanja, izbori_u_zvanje.strucno_zvanje')
                ->orderBy('users.ime')
                ->orderBy('users.prezime')
                ->get(); 
        }
        return view('zaposleni.upravljaj_angazovanjima', ['organizaciona_jedinica'=> $organizaciona_jedinica, 'predmeti'=>$predmeti, 'grupe'=>$grupe, 'angazovani'=>$angazovani]);
    }
    public function show($sifra){
        $id_org_jed = (Nastavnik::where('id_korisnik', Auth::user()->id)->first())->id_organizaciona_jedinica;
        $predmet = Predmet::where('id_katedre', $id_org_jed)
        ->selectRaw('predmeti.sifra, predmeti.naziv, predmeti.tip_studija, programi.naziv as program, drze_se.semestar, drze_se.status, programi.skracenica')
        ->join('drze_se', 'drze_se.sifra_predmeta', '=', 'predmeti.sifra')
        ->join('programi','programi.id', '=', 'id_program')
        ->where('predmeti.sifra', $sifra)
        ->first();
        $grupe = DB::table('grupe_za_predmete')
        ->where('id_predmeta', $predmet->sifra)
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->get();
        $nastavnici = Nastavnik::where('id_organizaciona_jedinica', $id_org_jed)
        ->join('users', 'users.id', '=', 'id_korisnik')
        ->join('izbori_u_zvanje', 'id_poslednjeg_izbora', '=', 'izbori_u_zvanje.id')
        ->join('zvanja', 'id_zvanja', '=', 'zvanja.id')
        ->orderBy('users.ime')
        ->orderBy('users.prezime')
        ->get();
        $angazovani = DB::table('nastavnici_drze_grupe_predmeta')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->where('id_predmeta', $sifra)
        ->get();
       
        //print_r($grupe);
        return view('zaposleni.upravljaj_angazovanjima_predmet', ['predmet'=>$predmet, 'grupe'=>$grupe, 'nastavnici'=>$nastavnici,'angazovani'=>$angazovani]);
    }
    public function store(Request $request, $sifra){

        DB::beginTransaction();
        try{
            DB::table('nastavnici_drze_grupe_predmeta')
            ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
            ->where('id_sk', SkolskaGodina::tekuca()->id)
            ->where('id_predmeta', $sifra)
            ->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return redirect()->back()->withErros(['dberror'=>"Дошло је до грешке, молимо покушајте поново."]);
        }
        $id_org_jed = (Nastavnik::where('id_korisnik', Auth::user()->id)->first())->id_organizaciona_jedinica;
        $predmet = Predmet::where('id_katedre', $id_org_jed)
        ->selectRaw('predmeti.sifra, predmeti.naziv, predmeti.tip_studija, programi.naziv as program, drze_se.semestar, drze_se.status, programi.skracenica')
        ->join('drze_se', 'drze_se.sifra_predmeta', '=', 'predmeti.sifra')
        ->join('programi','programi.id', '=', 'id_program')
        ->where('predmeti.sifra', $sifra)
        ->first();
        $grupe = DB::table('grupe_za_predmete')
        ->where('id_predmeta', $predmet->sifra)
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->get();
        foreach($grupe->where('tip', 'П') as $g){
            $naziv = 'predavanja'.$g->id;
            if($request->$naziv){
                try{
                    foreach($request->$naziv as $n){
                        DB::table('nastavnici_drze_grupe_predmeta')
                        ->insert([
                            'id_grupe_predmeta'=>$g->id,
                            'id_nastavnika'=>$n
                        ]);
                    }

                }catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    return redirect()->back()->withErros(['dberror'=>"Дошло је до грешке, молимо покушајте поново."]);
                }
            }
        }
        foreach($grupe->where('tip', 'В') as $g){
            $naziv = 'vezbe'.$g->id;
            if($request->$naziv){
                try{
                    foreach($request->$naziv as $n){
                        DB::table('nastavnici_drze_grupe_predmeta')
                        ->insert([
                            'id_grupe_predmeta'=>$g->id,
                            'id_nastavnika'=>$n
                        ]);
                    }

                }catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    return redirect()->back()->withErros(['dberror'=>"Дошло је до грешке, молимо покушајте поново."]);
                }
            }
        }
        foreach($grupe->where('tip', 'Л') as $g){
            $naziv = 'don'.$g->id;
            if($request->$naziv){
                try{
                    foreach($request->$naziv as $n){
                        DB::table('nastavnici_drze_grupe_predmeta')
                        ->insert([
                            'id_grupe_predmeta'=>$g->id,
                            'id_nastavnika'=>$n
                        ]);
                    }

                }catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    return redirect()->back()->withErros(['dberror'=>"Дошло је до грешке, молимо покушајте поново."]);
                }
            }
        }
        DB::commit();
        return redirect()->route('zap.upr.ang.sef.katedre')->with('success', 'Успешно сте додали ангажоване на предмет '.$sifra);

    }
    /*
    provera odobrenja za uredjivanje predmeta
    */
    public function chech_approval($sifra, $id_org_jed){
        $predmeti = Predmet::where('id_katedre', $id_org_jed)
        ->selectRaw('predmeti.sifra, predmeti.naziv, predmeti.tip_studija, programi.naziv as program, drze_se.semestar, drze_se.status, programi.skracenica')
        ->join('drze_se', 'drze_se.sifra_predmeta', '=', 'sifra')
        ->join('programi','programi.id', '=', 'id_program')
        ->get();
        return $predmeti->contains('sifra', $sifra);
    }
    public function add_group(Request $request, $sifra){
        $this->validate($request,[
            'tip'=>'required|string',
            'broj'=>'required|integer',
            'tip'=> Rule::in(['Л',  'В', 'П']),
        ], [
            'tip.required' => 'Обавезно је изабрати тип!',
            'broj.required' => 'Обавезно је унети број групе!',
            'broj.integer' => 'Број групе мора бити целобројна вредност!',
            'tip.string' => 'Недозвољен тип наставе!'
        ]);
        $grupe = DB::table('grupe_za_predmete')
        ->where('id_predmeta', $sifra)
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->get();
        $id_org_jed = (Nastavnik::where('id_korisnik', Auth::user()->id)->first())->id_organizaciona_jedinica;
        
        
        if(count($grupe->where('id_predmeta', $sifra)->where('tip', $request->tip)->where('broj', $request->broj)->where('id_sk', SkolskaGodina::tekuca()->id))){
            //print_r('greska'." ".$request->tip." ".$request->broj);
            return redirect()->back()->withErrors(['ponavljanje'=>"Покушали сте да унесете постојећу групу"]);
        }else if(!$this->chech_approval($sifra, $id_org_jed)){
            return redirect()->back()->withErrors(['greska_odobrenje'=>"Немате дозволу да уређујете овај предмет!"]);
        }else{
            DB::table('grupe_za_predmete')
            ->insert([
                'id_predmeta'=>$sifra,
                'tip'=>$request->tip,
                'broj'=>$request->broj,
                'id_sk'=>SkolskaGodina::tekuca()->id
            ]);
        }
        return redirect()->back()->with('success', 'Група успешно додата!');
    }

    public function predmetne_aktivnosti_show(Request $request, $sifra){
        $id_org_jed = (Nastavnik::where('id_korisnik', Auth::user()->id)->first())->id_organizaciona_jedinica;
        if(!$this->chech_approval($sifra, $id_org_jed)){
            return redirect()->back()->withErrors(['greska_odobrenje'=>"Немате дозволу да уређујете овај предмет!"]);
        }
        $now = Carbon::now();
        $date = Carbon::parse($now)->toDateString();
        $ovlascenjaDB = DB::table('ovlascenja')
        ->where('id_ovlascenog',  Auth::user()->id)
        ->where('sifra_predmeta', $sifra)
        ->where('ovlascenje', 'администрација')
        ->where(
            function($query) use($date) {
              return $query
                     ->whereDate('kraj', '>', $date)
                     ->orWhere('kraj', '=', null);
             })
       
        ->get();
        $ovlascenja = [];
        foreach($ovlascenjaDB as $ov){
            $ovlascenja[] = $ov->id_ovlastioca;
        }
        $ovlascenja[] =  Auth::user()->id;
        $angazovanja = DB::table('nastavnici_drze_grupe_predmeta')
        ->whereIn('id_nastavnika', $ovlascenja)
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->join('predmeti', 'predmeti.sifra', '=', 'id_predmeta')
        ->get();
        
        $predmet = Predmet::where('sifra',$sifra)->first();
        $grupe = DB::table('grupe_za_predmete')
        ->where('id_predmeta', $sifra)
        ->where('tip', "П")
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->whereIn('id', $angazovanja->unique('id_grupe_predmeta')->pluck('id_grupe_predmeta'))
        ->orderBy('broj')
        ->get();
        $grupe_ids = $grupe->pluck('id');
        $obaveze = DB::table('predmetne_obaveze')
        ->selectRaw('grupe_za_predmete.*, predmetne_obaveze.*, predmetne_obaveze.id')
        ->whereIn('id_grupe_predmeta', $grupe_ids)
        ->whereIn('id_grupe_predmeta', $angazovanja->pluck('id_grupe_predmeta'))
        ->join('grupe_za_predmete', 'grupe_za_predmete.id','=', 'id_grupe_predmeta')
        ->get();
        return view('zaposleni.uredi_obaveze_o_predmetu', ['obaveze'=>$obaveze, 'grupe'=>$grupe, 'predmet'=>$predmet]);

    }
    public function predmetne_aktivnosti_store(Request $request, $sifra){
        $this->validate($request,[
            'naziv'=>'required|string',
            'maks_br_poena'=>'required',
            'procenat'=> 'required|integer',
            'br_prilika'=> 'required|integer'
        ], [
            'naziv.required' => 'Назив је обавезан!',
        ]);
        foreach($request->grupe as $gr){
            DB::table('predmetne_obaveze')
                ->insert([
                    'id_grupe_predmeta'=>$gr,
                    'naziv'=>$request->naziv,
                    'maks_broj_poena'=>$request->maks_br_poena,
                    'procenat_u_ukupnoj_oceni'=>$request->procenat,
                    'broj_prilika_za_polaganje'=>$request->br_prilika,
                    'opis_pravila'=>$request->opis,
                    'id_sk'=>SkolskaGodina::tekuca()->id,
                    'jeste_ispit'=>$request->ispitna ? 1:0,
                    'ima_drugi_deo'=>$request->drugi_deo ? 1:0,

            ]);
        }
        return redirect()->back()->with('success', 'Обавеза успешно додата!');

    }
}


