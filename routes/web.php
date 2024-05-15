<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 

















Route::get('/', function () {
    if(Auth::check()) return redirect()->route('home');
    return view('auth.login');
});
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::get('/pocetna', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//profil
Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'index'])->name('profil')->middleware('student');

//predmeti
Route::get('/predmeti', [App\Http\Controllers\PredmetiController::class, 'index'])->name('predmeti')->middleware('student');;
Route::get('/predmeti/izbor', [App\Http\Controllers\PredmetiController::class, 'create'])->name('predmeti_izbor')->middleware('student');;
Route::get('/predmeti/tekuca', [App\Http\Controllers\PredmetiController::class, 'show'])->name('predmeti_tekuca')->middleware('student');;
Route::post('/predmeti/prijavi', [App\Http\Controllers\PredmetiController::class, 'store'])->name('prijavi_predmete')->middleware('student');;


//Rokovi
Route::get('/rokovi', [App\Http\Controllers\RokoviController::class, 'index'])->name('rokovi')->middleware('auth');
Route::get('/prijava_ispita', [App\Http\Controllers\PrijavaIspitaController::class, 'index'])->name('prijava_ispita')->middleware('student');;
Route::get('/azuriraj_izlazak/{id}/{tip}', [App\Http\Controllers\PrijavaIspitaController::class, 'azuriraj_izlazak'])->middleware('student');;
Route::post('/prijavi_ispit', [App\Http\Controllers\PrijavaIspitaController::class, 'prijavi_ispit'])->name('prijavi_ispit')->middleware('student');;
Route::get('/odjava_ispita/{id}', [App\Http\Controllers\PrijavaIspitaController::class, 'odjavi_ispit'])->name('odjava_ispita')->middleware('student');;


//Ispiti
Route::get('/ispiti/polozeni_ispiti', [App\Http\Controllers\IspitiController::class, 'polozeni'])->name('ispiti.polozeni')->middleware('student');;
Route::get('/ispiti/neuspesna_polaganja', [App\Http\Controllers\IspitiController::class, 'neuspesna'])->name('ispiti.neuspesna')->middleware('student');;

//Zaposleni
Route::get('/zaposleni/profil/{id}', [App\Http\Controllers\ProfileController::class, 'show'])->name('zap.profil');
Route::get('/zaposleni/angazovanja', [App\Http\Controllers\NastavniciPredmetiController::class, 'show'])->name('zap.angazovanje')->middleware('nastavnik');
Route::get('/zaposleni/upravljanje_angazovanjima',[App\Http\Controllers\UpravljajAngazovanjimaController::class, 'index'] )->name('zap.upr.ang.sef.katedre')->middleware('nastavnik');
Route::get('/zaposleni/upravljanje_angazovanjima/{id}',[App\Http\Controllers\UpravljajAngazovanjimaController::class, 'show'] )->name('upravljanje_konkretnim_predmetom')->middleware('nastavnik');
Route::post('/zaposleni/azuriraj_angazovanje/{id}',[App\Http\Controllers\UpravljajAngazovanjimaController::class, 'store'] )->name('upravljanje_konkretnim_predmetom_sacuvaj')->middleware('nastavnik');
Route::post('/zaposleni/dodaj_grupu/{id}',[App\Http\Controllers\UpravljajAngazovanjimaController::class, 'add_group'] )->name('dodavanje_grupe_za_predmet_nastava')->middleware('nastavnik');
Route::get('/zaposleni/uredjivanje_aktivnosti_o_predmetu/{id}',[App\Http\Controllers\UpravljanjePredmetimaController::class, 'show'] )->name('zap.predmeti.uredjivanje_aktivnosti')->middleware('nastavnik');
Route::post('/zaposleni/predmetne_aktivnosti_cuvanje/{id}',[App\Http\Controllers\UpravljanjePredmetimaController::class, 'store'] )->name('predmetne_aktivnosti_store')->middleware('nastavnik');
Route::post('/zaposleni/predmetne_aktivnosti_azuriranje/{id}',[App\Http\Controllers\UpravljanjePredmetimaController::class, 'update'] )->name('predmetne_aktivnosti_update')->middleware('nastavnik');
Route::get('/zaposleni/predmetne_aktivnosti_brisanje/{id}',[App\Http\Controllers\UpravljanjePredmetimaController::class, 'delete'] )->name('predmetne_aktivnosti_delete')->middleware('nastavnik');

Route::get('/rokovi/pregled_za_nastavnike/{rok}/{predmet}', [App\Http\Controllers\RokoviController::class, 'predmeti_u_roku_za_nastavnike'])->name('zap.predmet_u_roku')->middleware('nastavnik');
Route::post('/rokovi/sacuvaj_ocenu', [App\Http\Controllers\RokoviController::class, 'sacuvaj_ocenu'])->name('zap.sacuvaj_ocenu')->middleware('nastavnik');
Route::post('/rokovi/zakljucaj_ocene', [App\Http\Controllers\RokoviController::class, 'zakljucaj_ocene'])->name('zap.zakljucaj_ocene')->middleware('nastavnik');

//Dezurstva
Route::get('/zaposleni/pregled_dezurstava', [App\Http\Controllers\DezurstvaController::class, 'index'])->name('zap.dezurstva')->middleware('nastavnik');
Route::get('/zaposleni/pregled_dezurstava/dezurstvo/{grupa}/{dezurstvo}', [App\Http\Controllers\DezurstvoUTokuController::class, 'show'])->name('zap.dezurstvo_u_toku')->middleware('nastavnik');

Route::post('/api/azuriraj_prisustvo/{id}', [App\Http\Controllers\PrijavaIspitaController::class, 'azuriraj_prisustvo']);

Route::post('/api/azuriraj_dezurstvo/{id}',[App\Http\Controllers\DezurstvaController::class,'azuriraj_status']);
//Raspored casova
Route::get('/studenti/raspored_casova', [App\Http\Controllers\RasporedCasovaController::class, 'index'])->name('stud.rasp_cas')->middleware('student');
//
Route::get('/zaposleni/studentska_sluzba/pregled_rokova', [App\Http\Controllers\StudentskaRokoviController::class, 'index'])->name('ss.pregled_rokova')->middleware('stud_sluz');
Route::get('/zaposleni/studentska_sluzba/dodaj_ispit_u_rok/{id}', [App\Http\Controllers\StudentskaRokoviController::class, 'dodavanje_u_rok'])->name('ss.dodavanje_u_rok')->middleware('stud_sluz');