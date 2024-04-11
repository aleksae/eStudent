<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Rok;
use App\Models\Student;
use App\Models\SlusanjeStudent;
use Auth;

class PrijavaIspitaController extends Controller
{
    public function index(){

       
        $poslednji_upis = Student::poslednji_upis(Auth::user()->id);
        
        $rokovi = DB::table('rokovi')
        ->whereDate('kraj_roka', '>=', Carbon::now())
        ->get();

        $ima_rokova_sa_prijavom_u_toku_upit = DB::table('rokovi')
        ->whereDate('kraj_prijave', '>=', Carbon::now())
        ->get();

        

        $ima_rokova_sa_prijavom_u_toku = !($ima_rokova_sa_prijavom_u_toku_upit->isEmpty());
        $rokovi_ids = $rokovi->pluck('id');

        $predmeti = SlusanjeStudent::
        selectRaw('predmeti.sifra, predmeti.naziv as naziv_predmeta, predmetne_obaveze.naziv as obaveza, predmetne_obaveze.id as id_obaveza, predmetne_obaveze.jeste_ispit, grupe_za_predmete.broj as ngr, (

            SELECT COUNT(*)
            FROM ispitne_prijave
            JOIN predmetna_grupa_postoji_u_roku ON (predmetna_grupa_postoji_u_roku.id = ispitne_prijave.id_grupe_u_roku)
            JOIN rokovi ON (rokovi.id = id_rok)
            WHERE ispitne_prijave.sifra_predmet = predmeti.sifra
            AND ispitni=1
            AND id_upis = '.$poslednji_upis->id.'
        ) as broj_prijava, id_rok, predmetna_grupa_postoji_u_roku.id as id_predmetne_grupe_u_roku')
        ->join('drze_se', 'drze_se.id', '=', 'slusanje.id_drzanje')
        ->join('predmeti', 'predmeti.sifra', '=' ,'drze_se.sifra_predmeta')
        ->where('id_upis', $poslednji_upis->id)
        ->join('predmetne_obaveze', 'predmetne_obaveze.id_grupe_predmeta', '=', 'slusanje.grupa_predavanja')
        
        ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze', '=', 'predmetne_obaveze.id')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->whereIn('id_rok', $rokovi_ids)
        ->get();

        $pred = $predmeti->pluck('sifra');
        /*foreach($predmeti as $pr){
            print_r($pr);
            echo("<br>");
            echo("<br>");
        }*/

        $kombinovane_opcije = DB::table('grupe_predmetnih_grupa_u_roku')
        ->whereIn('sifra_predmeta', $pred)
        ->whereIn('id_rok', $rokovi_ids)
        ->get();

        $prijavljeni = DB::table('ispitne_prijave')
        ->selectRaw('CONCAT(users.ime, " ",users.prezime) as nastavnik, ispitne_prijave.id as id_prijave, predmeti.naziv as predmet, predmeti.sifra as sifra, ispitne_prijave.*, predmetne_obaveze.naziv as obaveza, predmetne_obaveze.jeste_ispit, rokovi.id as id_rok, rokovi.naziv_skraceno as rok, predmetna_grupa_postoji_u_roku.datum, predmetna_grupa_postoji_u_roku.vreme, 
        predmetna_grupa_postoji_u_roku.poruka, prostorije.*, zgrade.*')
        ->where('id_upis', $poslednji_upis->id)
        ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id', '=', 'ispitne_prijave.id_grupe_u_roku')
        ->join('rokovi', 'rokovi.id', '=', 'id_rok')
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        ->leftjoin('prostorije', 'prostorije.id', '=', 'sala')
        ->leftjoin('zgrade', 'zgrade.id', '=', 'id_zgrade')
        ->leftjoin('users', 'users.id','=','potpisao')
        ->orderBy('predmetna_grupa_postoji_u_roku.datum')
        ->orderBy('predmetna_grupa_postoji_u_roku.vreme')
        ->get();


        $prijavljeni_grupa = DB::table('ispitne_prijave')
        ->selectRaw('CONCAT(users.ime, " ",users.prezime) as nastavnik, ispitne_prijave.id as id_prijave, predmeti.naziv as predmet, predmeti.sifra as sifra, id_grupe_u_roku, ispitne_prijave.*, prostorije.*, zgrade.*,  rokovi.id as id_rok, rokovi.naziv_skraceno as rok, grupe_predmetnih_grupa_u_roku.id_predmetnih_obaveza, grupe_predmetnih_grupa_u_roku.datum as datum, grupe_predmetnih_grupa_u_roku.vreme as vreme,
        grupe_predmetnih_grupa_u_roku.id_predmetnih_obaveza, grupe_predmetnih_grupa_u_roku.poruka, grupe_predmetnih_grupa_u_roku.sifra_predmeta, grupe_predmetnih_grupa_u_roku.datum, grupe_predmetnih_grupa_u_roku.vreme')
        ->where('id_upis', $poslednji_upis->id)
        ->where('grupa_obaveza', true)
        ->join('grupe_predmetnih_grupa_u_roku', 'id_grupe_u_roku','=','grupe_predmetnih_grupa_u_roku.id')
        ->join('predmeti', 'predmeti.sifra','=','sifra_predmet')
        ->join('rokovi', 'rokovi.id','=','grupe_predmetnih_grupa_u_roku.id_rok')
        ->leftjoin('prostorije', 'prostorije.id', '=', 'sala')
        ->leftjoin('zgrade', 'zgrade.id', '=', 'id_zgrade')
        ->leftjoin('users', 'users.id','=','potpisao')
        ->get();


 
        $prijavljeni_grupa_detalji = [];
        foreach($prijavljeni_grupa as $gr){

            $temp_niz = explode(";",$gr->id_predmetnih_obaveza);
            $temp_niz_store=[];
            foreach($temp_niz as $t){
                $res = DB::table('predmetne_obaveze')
                ->where('id', $t)
                ->first();
                $temp_niz_store[] = $res;
            }
            $prijavljeni_grupa_detalji[$gr->id_prijave]=$temp_niz_store;
        }
        

        
        
        $balans = DB::table('uplate')->selectRaw('SUM(iznos) as balans')->where('user_id', Auth::user()->id)->first();
        
        return view('student.prijava_ispita', ['predmeti'=>$predmeti, 'rokovi'=>$rokovi, 'prijavljeni'=>$prijavljeni, 'ima_rokova_sa_prijavom_u_toku'=>$ima_rokova_sa_prijavom_u_toku, 'balans'=>$balans, 'kombinovane_opcije'=>$kombinovane_opcije, 'prijavljeni_grupa'=>$prijavljeni_grupa, 'prijavljeni_grupa_detalji'=>$prijavljeni_grupa_detalji]);
    }
    public function azuriraj_izlazak($id, $tip) {
        $prijava = $ispitna_prijava =  DB::table('ispitne_prijave')
        ->where('ispitne_prijave.id', $id)
        ->first();
        if($ispitna_prijava->grupa_obaveza){
            $prijava = DB::table('ispitne_prijave')->where('ispitne_prijave.id', $id)
            ->join('grupe_predmetnih_grupa_u_roku', 'grupe_predmetnih_grupa_u_roku.id', '=', 'id_grupe_u_roku')         
            ->first();
        }
        else{
            $prijava = DB::table('ispitne_prijave')->where('ispitne_prijave.id', $id)
            ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id', '=', 'id_grupe_u_roku')
            ->first();
        }
        $msg="";
        if($prijava->datum == Carbon::now()->format('Y-m-d') && $prijava->vreme < Carbon::now()->format('H:i:s')) {
            $tip = !$tip;
            $msg = "Пријава/одјава изласка није у току.";
        }
        else if($prijava->datum < Carbon::now()->format('Y-m-d')){
            $tip = !$tip;
            $msg = "Пријава/одјава изласка није у току.";
        }else{
        }
        
        $rez = DB::table('ispitne_prijave')->where('id', $id)
        ->update(['potvrda_izlaska' => $tip]);


        return response()->json(array('tip'=> $tip, 'msg'=>$msg), 200);
     }

     
    public function prijavi_ispit(Request $request){
        $this->validate($request,[
            'izborPredmeta'=>'required',
            'izborRoka'=>'required|integer',
            'izborObaveza'=>'required',
        ], [
            'izborPredmeta.required' => 'Обавезно је изабрати предмет!',
            'izborRoka.required' => 'Обавезно је изабрати рок!',
            'izborRoka.integer' => 'Некоректна вредност за избор рока!',
            'izborObaveza.required' => 'Обавезно је изабрати обавезу!'
            
        ]);
        
         $poslednji_upis = Student::poslednji_upis(Auth::user()->id);
         $izborPredmeta = explode("|", $request->izborPredmeta);
         $rokovi = DB::table('rokovi')
        ->whereDate('kraj_roka', '>=', Carbon::now())
        ->where('id', $request->izborRoka)
        ->get();

       
        $prijava_u_toku = DB::table('rokovi')
        ->whereDate('kraj_prijave', '>=', Carbon::now())
        ->where('id', $izborPredmeta[0])
        ->get();
        $rokovi_ids = $rokovi->pluck('id');
        if($prijava_u_toku->isEmpty()){
            return redirect()->back()->withErrors(['error'=>'Пријава испита за изабрани рок није у току!']);
        }
        
        $predmet = $izborPredmeta[1];
        if($request->izborRoka != $izborPredmeta[0]){
            return redirect()->back()->withErrors(['error'=>'Дошло је до неконзистентности података. Покушајте поново!']);
        }
        $predmeti = SlusanjeStudent::
        selectRaw('predmeti.sifra, predmeti.naziv as naziv_predmeta, predmetne_obaveze.naziv as obaveza, predmetne_obaveze.broj_prilika_za_polaganje, predmetne_obaveze.id as id_obaveza, predmetne_obaveze.jeste_ispit, grupe_za_predmete.broj as ngr, (

            SELECT COUNT(*)
            FROM ispitne_prijave
            WHERE ispitne_prijave.sifra_predmet = predmeti.sifra
            AND id_upis = '.$poslednji_upis->id.'
        ) as broj_prijava, id_rok, predmetna_grupa_postoji_u_roku.id as id_grupe_u_roku')
        ->join('drze_se', 'drze_se.id', '=', 'slusanje.id_drzanje')
        ->join('predmeti', 'predmeti.sifra', '=' ,'drze_se.sifra_predmeta')
        ->where('id_upis', $poslednji_upis->id)
        ->join('predmetne_obaveze', 'predmetne_obaveze.id_grupe_predmeta', '=', 'slusanje.grupa_predavanja')
        
        ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze', '=', 'predmetne_obaveze.id')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->whereIn('id_rok', $rokovi_ids)
        ->get();

        $predmeti_plucked_by_sifra = $predmeti->pluck('sifra');
        if(!$predmeti_plucked_by_sifra->contains($predmet)){
            return redirect()->back()->withErrors(['error'=>'Предмет '.$predmet.' није на листи предмета које слушате или није дефинисан у року!']);
        }
        $prijavljeni = DB::table('ispitne_prijave')
        ->selectRaw('predmeti.naziv as predmet, predmeti.sifra as sifra, ispitne_prijave.*, predmetne_obaveze.naziv as obaveza, rokovi.id as id_rok, rokovi.naziv_skraceno as rok, predmetna_grupa_postoji_u_roku.datum, predmetna_grupa_postoji_u_roku.vreme, predmetna_grupa_postoji_u_roku.poruka')
        ->where('id_upis', $poslednji_upis->id)
        ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id', '=', 'ispitne_prijave.id_grupe_u_roku')
        ->join('rokovi', 'rokovi.id', '=', 'id_rok')
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        ->get();



        $prijavljeni_plucked_by_sifra = $prijavljeni->where('id_rok', $request->izborRoka)->pluck('sifra');
        if($prijavljeni_plucked_by_sifra->contains($predmet)){
            return redirect()->back()->withErrors(['error'=>'Предмет '.$predmet.' је већ пријављен!']);

        }

        
        $cena=0.0;
        //komb
        
        if(strpos($request->izborObaveza,'komb')!==false){
            $id = (explode(".", $request->izborObaveza))[1];
            $res = DB::table('grupe_predmetnih_grupa_u_roku')->where('id', $id)->first();
            foreach(explode(";", $res->id_predmetnih_obaveza) as $pr_o){

                $predmet_loc = $predmeti->where('sifra', $predmet)->where('id_grupe_u_roku', $pr_o)->first();
                if(!$predmet_loc) continue;
                $cnt = count($prijavljeni->where('sifra', $predmet_loc->sifra)->where('id_upis', $poslednji_upis->id));
                if($cnt ==($predmet_loc->broj_prilika_za_polaganje)){
                    return redirect()->back()->withErrors(['broj_prilika'=>'Максималан број излазака на обавезу <em>'.$predmet_loc->obaveza.'</em> из предмета <em>'.$predmet_loc->naziv_predmeta.'</em> је '.$predmet_loc->broj_prilika_za_polaganje]);
                }
            }
        }
       else{
            $predmet_loc = $predmeti->where('sifra', $predmet)->where('id_grupe_u_roku', $request->izborObaveza)->first();
            $cnt = count($prijavljeni->where('sifra', $predmet_loc->sifra)->where('id_upis', $poslednji_upis->id));
            if($cnt ==($predmet_loc->broj_prilika_za_polaganje)){
                return redirect()->back()->withErrors(['broj_prilika'=>'Максималан број излазака на обавезу <em>'.$predmet_loc->obaveza.'</em> из предмета <em>'.$predmet_loc->naziv_predmeta.'</em> је '.$predmet_loc->broj_prilika_za_polaganje]);
            }
        } 
        $predmet =$predmeti->where('sifra', $predmet)->first(); 
        if($predmet->broj_prijava > env('BR_PRIJAVA_FREE') && ($rokovi->first())->ispitni){
            $cena = (float) env('CENA_PRIJAVE_ISPITA');
        }
        $balans = DB::table('uplate')->selectRaw('CAST(SUM(iznos) as DECIMAL(10,2)) as balans')->where('user_id', Auth::user()->id)->first();
    
        
        if($cena && $balans->balans<$cena){
            return redirect()->back()->withErrors(['stanje'=>'Немате довољно средстава на рачуну!']);
        }
        if($cena){
            
            
            DB::transaction(function () use($cena, $poslednji_upis, $predmet, $request){
                
                DB::table('uplate')->insert([
                    'iznos'=>(0-$cena),
                    'user_id'=>Auth::user()->id,
                    'opis'=>'Пријава испита'
                ]);
                
                if(strpos($request->izborObaveza,'komb')!==false){
                DB::table('ispitne_prijave')->insert([
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'id_upis'=>$poslednji_upis->id,
                    'grupa_obaveza'=>true,
                    'id_grupe_u_roku'=>(explode(".",$request->izborObaveza))[1],
                    'sifra_predmet'=>$predmet->sifra,
                    'cena' => $cena
                ]);
                }else{
                    DB::table('ispitne_prijave')->insert([
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                        'id_upis'=>$poslednji_upis->id,
                        'id_grupe_u_roku'=>$request->izborObaveza,
                        'sifra_predmet'=>$predmet->sifra,
                        'cena' => $cena
                    ]);
                }
            });

        }else{
            if(strpos($request->izborObaveza,'komb')!==false){
                DB::table('ispitne_prijave')->insert([
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'id_upis'=>$poslednji_upis->id,
                    'grupa_obaveza'=>true,
                    'id_grupe_u_roku'=>(explode(".",$request->izborObaveza))[1],
                    'sifra_predmet'=>$predmet->sifra,
                    'cena' => $cena
                ]);
                }else{
                    DB::table('ispitne_prijave')->insert([
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                        'id_upis'=>$poslednji_upis->id,
                        'id_grupe_u_roku'=>$request->izborObaveza,
                        'sifra_predmet'=>$predmet->sifra,
                        'cena' => $cena
                    ]);
                }
        }  
        return redirect()->back()->with('success', 'Испит је успешно пријављен!');



    }
    public function odjavi_ispit($id){

        $ispitna_prijava = DB::table('ispitne_prijave')->where('ispitne_prijave.id', $id)
        ->first();
        if($ispitna_prijava->grupa_obaveza){
            $ispitna_prijava = DB::table('ispitne_prijave')->where('ispitne_prijave.id', $id)
            ->join('grupe_predmetnih_grupa_u_roku', 'grupe_predmetnih_grupa_u_roku.id', '=', 'id_grupe_u_roku')
            ->join('rokovi', 'rokovi.id', '=', 'id_rok')
            ->first();
        }
        else{
            $ispitna_prijava = DB::table('ispitne_prijave')->where('ispitne_prijave.id', $id)
            ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id', '=', 'id_grupe_u_roku')
            ->join('rokovi', 'rokovi.id', '=', 'id_rok')
            ->first();
        }
        if($ispitna_prijava->kraj_prijave<=Carbon::now()){
            return redirect()->back()->withErrors(['greska'=>'Одјава испита за <strong>'.$ispitna_prijava->naziv_skraceno.'</strong> није у току']);
        }
        $balans = DB::table('uplate')->selectRaw('SUM(iznos) as balans')->where('user_id', Auth::user()->id)->first();
        if($ispitna_prijava->cena){
            DB::transaction(function () use ($id) {
                DB::table('uplate')->where('user_id', Auth::user()->id)->where('opis', 'Пријава испита')->where('iznos', '<', 0)->orderBy('created_at')->delete();
                DB::table('ispitne_prijave')->where('id', $id)->delete();
            });
        }else{
            DB::table('ispitne_prijave')->where('id', $id)->delete();
        }
        return redirect()->back()->with('success', 'Испит је успешно одјављен!');
    }
}
