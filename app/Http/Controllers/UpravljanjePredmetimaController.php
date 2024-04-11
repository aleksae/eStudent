<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UpravljajAngazovanjimaController;
use App\Models\Nastavnik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Predmet;
use App\Models\SkolskaGodina;
use Carbon\Carbon;

class UpravljanjePredmetimaController extends Controller
{
    public function show(Request $request, $sifra){
        $id_org_jed = (Nastavnik::where('id_korisnik', Auth::user()->id)->first())->id_organizaciona_jedinica;
        if(!(new UpravljajAngazovanjimaController)->chech_approval($sifra, $id_org_jed)){
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
        //->where('tip', "П")
        ->where('id_sk', SkolskaGodina::tekuca()->id)
        ->whereIn('id', $angazovanja->unique('id_grupe_predmeta')->pluck('id_grupe_predmeta'))
        ->orderBy('tip', 'desc')
        ->orderBy('broj')
        ->get();

        $grupe_ids = $grupe->pluck('id');
        $obaveze = DB::table('predmetne_obaveze')
        ->selectRaw('grupe_za_predmete.*, predmetne_obaveze.*, predmetne_obaveze.id')
        ->whereIn('id_grupe_predmeta', $grupe_ids)
        ->whereIn('id_grupe_predmeta', $angazovanja->pluck('id_grupe_predmeta'))
        ->join('grupe_za_predmete', 'grupe_za_predmete.id','=', 'id_grupe_predmeta')
        ->orderBy('jeste_ispit')
        ->orderBy('ima_drugi_deo')
        ->orderBy('broj')
        ->get();
        //print_r($obaveze);
        
        return view('zaposleni.uredi_obaveze_o_predmetu', ['obaveze'=>$obaveze, 'grupe'=>$grupe, 'predmet'=>$predmet]);

    }
    public function store(Request $request, $sifra){
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
    public function update(Request $request, $id_obaveze){
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
            ->where('id', $id_obaveze)
                ->update([
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
    public function delete($id){
        DB::table('predmetne_obaveze')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Обавеза успешно обрисана!');
    }
}
