<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Rok;
use Illuminate\Support\Collection;
use App\Models\Student;
use Auth;

class RokoviController extends Controller
{
    public function index(){
        $poslednji_upis = Student::poslednji_upis(Auth::user()->id);
        $rokovi = DB::table('rokovi')
        ->whereDate('kraj_roka', '>=', Carbon::now())
        ->get();
        $ispiti = new Collection();
        if(Auth::user()->isStudent()){
        $ispiti = DB::table('predmetna_grupa_postoji_u_roku')
        ->selectRaw('predmetna_grupa_postoji_u_roku.*, predmetna_grupa_postoji_u_roku.id as id_pred_gr, rokovi.*, rokovi.id as id_roka, predmetne_obaveze.*, predmetne_obaveze.naziv as obaveza, grupe_za_predmete.*, predmeti.naziv as predmet,
        (SELECT 1 FROM slusanje WHERE id_grupe_predmeta = slusanje.grupa_predavanja AND slusanje.id_upis='.$poslednji_upis->id.') as moj')
        ->join('rokovi', 'rokovi.id', '=', 'predmetna_grupa_postoji_u_roku.id_rok')
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        ->where('kraj_roka','>=',Carbon::now())
        ->get();

        }else{
            /*nastavnik*/
            $ispiti = DB::table('predmetna_grupa_postoji_u_roku')
        ->selectRaw('predmetna_grupa_postoji_u_roku.*, predmetna_grupa_postoji_u_roku.id as id_pred_gr, rokovi.*, rokovi.id as id_roka, predmetne_obaveze.*, predmetne_obaveze.naziv as obaveza, grupe_za_predmete.*, predmeti.naziv as predmet, 0 as moj')
        ->join('rokovi', 'rokovi.id', '=', 'predmetna_grupa_postoji_u_roku.id_rok')
        ->join('predmetne_obaveze', 'predmetne_obaveze.id', '=', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze')
        ->join('grupe_za_predmete', 'grupe_za_predmete.id', '=', 'predmetne_obaveze.id_grupe_predmeta')
        ->join('predmeti', 'predmeti.sifra', '=', 'grupe_za_predmete.id_predmeta')
        ->where('kraj_roka','>=',Carbon::now())
        ->get();
        foreach($ispiti as $ispit){

            $ispit->moj = DB::table('nastavnici_drze_grupe_predmeta')
            ->where('id_grupe_predmeta', $ispit->id_grupe_predmeta)
            ->where('id_nastavnika', Auth::user()->id)
            ->count();
            
        }
        }

        $ispiti_spojeno =  DB::table('grupe_predmetnih_grupa_u_roku')
        ->selectRaw('grupe_predmetnih_grupa_u_roku.*, grupe_predmetnih_grupa_u_roku.id as id_pred_gr, rokovi.*, rokovi.id as id_roka, predmeti.naziv as predmet')
        ->join('predmeti','predmeti.sifra','=','sifra_predmeta')
        ->join('rokovi', 'rokovi.id', '=', 'grupe_predmetnih_grupa_u_roku.id_rok')  
        ->where('kraj_roka','>=',Carbon::now())
        ->get();

         
        $prijavljeni_grupa_detalji = [];
        foreach($ispiti_spojeno as $gr){

            $temp_niz = explode(";",$gr->id_predmetnih_obaveza);
            $temp_niz_store=[];
            foreach($temp_niz as $t){
                $res = DB::table('predmetne_obaveze')
                ->selectRaw('predmetne_obaveze.*, grupe_za_predmete.broj as ngr,
                0 as moj')
                ->where('predmetne_obaveze.id', $t)
                ->join('grupe_za_predmete', 'id_grupe_predmeta', '=', 'grupe_za_predmete.id')
                ->first();
                $res->moj = DB::table('nastavnici_drze_grupe_predmeta')
                ->where('id_grupe_predmeta', $res->id_grupe_predmeta)
                ->where('id_nastavnika', Auth::user()->id)
                ->count();
                $temp_niz_store[] = $res;
            }
            $prijavljeni_grupa_detalji[$gr->id_pred_gr]=$temp_niz_store;
        }
        
        
        $ispiti_ids = $ispiti->pluck('id_pred_gr')->toArray();
        $ispiti_ids_2 = $ispiti_spojeno->pluck('id_pred_gr')->toArray();
        $ispiti_imena = $ispiti->pluck('id_predmeta');
        $ispiti_imena_2 = ($ispiti_spojeno->pluck('sifra_predmeta'));
        $sale = DB::table('ispitne_prijave')
        ->selectRaw('skraceni_naziv, id_grupe_u_roku')
        ->whereIn('id_grupe_u_roku', $ispiti_ids)
        ->whereIn('sifra_predmet', $ispiti_imena)
        ->join('prostorije', 'prostorije.id', '=', 'sala')
        ->groupBy('id_grupe_u_roku')
        ->groupBy('skraceni_naziv')
        ->get();

        $sale_2 = DB::table('ispitne_prijave')
        ->selectRaw('skraceni_naziv, id_grupe_u_roku')
        ->whereIn('id_grupe_u_roku', $ispiti_ids_2)
        ->whereIn('sifra_predmet', $ispiti_imena_2)
        ->join('prostorije', 'prostorije.id', '=', 'sala')
        ->groupBy('id_grupe_u_roku')
        ->groupBy('skraceni_naziv')
        ->get();
       
        //print_r($sale_2);
        //$moji = $ispiti->where('id_roka', 1)->Where('moj', 1);
        //print_r($moji);


        //print_r($ispiti);
        return view('student.rokovi', ['rokovi'=>$rokovi, 'ispiti'=>$ispiti, 'sale'=>$sale, 'ispiti_spojeno'=>$ispiti_spojeno, 'sale_2'=>$sale_2, 'prijavljeni_grupa_detalji'=>$prijavljeni_grupa_detalji]);
        
        
    }

    public function predmeti_u_roku_za_nastavnike($rok, $predmet){
        $ispitne_prijave = DB::table('ispitne_prijave')
        ->selectRaw('ispitne_prijave.id as id_prijave, ispitne_prijave.broj_poena, ispitne_prijave.ocena, predmetna_grupa_postoji_u_roku.id as id_predmetne_grupe_u_roku, users.id as id_studenta, prostorije.id as id_sale, prostorije.skraceni_naziv as sala, users.ime, users.prezime
        , predmetna_grupa_postoji_u_roku.id_predmetne_obaveze, predmetne_obaveze.naziv as obaveza')
        ->join('predmetna_grupa_postoji_u_roku', 'predmetna_grupa_postoji_u_roku.id','=','ispitne_prijave.id_grupe_u_roku')
        ->join('upisi', 'id_upis', '=', 'upisi.id')
        ->join('users', 'upisi.id_student', '=', 'users.id')
        ->join('predmetne_obaveze', 'predmetna_grupa_postoji_u_roku.id_predmetne_obaveze','=','predmetne_obaveze.id')
        ->leftjoin('prostorije', 'ispitne_prijave.sala', '=', 'prostorije.id')
        ->where('ispitne_prijave.grupa_obaveza',0)
        ->where('id_rok', $rok)
        ->where('sifra_predmet', $predmet)
        ->where('zakljucana', 0)
        ->orderBy('prostorije.skraceni_naziv')
        ->orderBy('obaveza')
        ->orderBy('users.email')
        ->get();


        $pr_ob_1 = $ispitne_prijave->pluck('id_predmetne_obaveze')->unique();
        $ispitne_prijave_grupe = DB::table('ispitne_prijave')
        ->selectRaw('ispitne_prijave.id as id_prijave, ispitne_prijave.broj_poena, ispitne_prijave.ocena, users.id as id_studenta, prostorije.id as id_sale, prostorije.skraceni_naziv as sala, users.ime, users.prezime
        , grupe_predmetnih_grupa_u_roku.id_predmetnih_obaveza as obaveza')
        
        ->join('upisi', 'id_upis', '=', 'upisi.id')
        ->join('users', 'upisi.id_student', '=', 'users.id')
        ->join('grupe_predmetnih_grupa_u_roku', 'ispitne_prijave.id_grupe_u_roku','=','grupe_predmetnih_grupa_u_roku.id')
        ->leftjoin('prostorije', 'ispitne_prijave.sala', '=', 'prostorije.id')
        ->where('ispitne_prijave.grupa_obaveza',1)
        ->where('grupe_predmetnih_grupa_u_roku.id_rok', $rok)
        ->where('sifra_predmet', $predmet)
        ->where('zakljucana', 0)
        ->orderBy('prostorije.skraceni_naziv')
        ->orderBy('obaveza')
        ->orderBy('users.email')
        ->get();

        $vreme=$vreme_kraja=null;
        foreach($ispitne_prijave_grupe as $ig){
            $temp = explode(";",$ig->obaveza);
            $obaveze = [];
            foreach($temp as $t){
                $res = DB::table('predmetne_obaveze')->where('id', $t)->first();
                $pr_ob_1 = $pr_ob_1->merge($res);
                
                $obaveze[] = $res->naziv;
            }
            
            $ig->obaveza = implode(" + ", $obaveze);
        }

        

        //print_r($ispitne_prijave_grupe);

        $temp_res = DB::table('predmetna_grupa_postoji_u_roku')
        ->whereIn('id', $pr_ob_1)
        ->first();

        if($temp_res !=null) {
        $vreme = Carbon::createFromFormat('Y-m-d H:i:s', $temp_res->datum. ' ' . $temp_res->vreme);
        $vreme_kraja =  Carbon::createFromFormat('Y-m-d H:i:s', $temp_res->datum. ' ' . $temp_res->vreme);
        $vreme_kraja = $vreme_kraja->addHours(3);
        }
        $rok = DB::table('rokovi')->where('id', $rok)->first();
        $ispitne_prijave = $ispitne_prijave->merge($ispitne_prijave_grupe);
        return view('zaposleni.pregled_predmeta_rok', ['ispitne_prijave'=>$ispitne_prijave, 'rok'=>$rok->naziv, 'predmet'=>$predmet, 'vreme'=>$vreme, 'vreme_kraja'=>$vreme_kraja]);
    }


    public function sacuvaj_ocenu(Request $request){

        $this->validate($request,[
            'br_poena'=>'integer|nullable',
            'ocena'=>'required|integer'
        ], [
            'ocena.required' => 'Обавезно је унети оцену!',
            'ocena.integer' => 'Оцена мора бити број!',
            'br_poena.integer' => 'Број поена мора бити цео број!'

        ]);
        DB::table('ispitne_prijave')
        ->where('id', '=', $request->id_prijave)
        ->update([
            'broj_poena' => $request->br_poena,
            'ocena' => $request->ocena,
            'potpisao' => Auth::user()->id
        ]);
        return redirect()->back()->with('success', 'Успешно унета оцена!');
        //print_r($request->id_prijave);

    }
    public function zakljucaj_ocene(Request $request){

      
        DB::table('ispitne_prijave')
        ->whereIn('id', explode(",",$request->id_prijava))
        ->update([
            'zakljucana' => 1,
            'potpisao' => Auth::user()->id
        ]);
        return redirect()->back()->with('success', 'Успешно закључане оцене!');
        //print_r($request->id_prijava);

    }
}
