@extends('layouts.header_side')
@section('title', 'Предмети из текуће школске године')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                  
                  <h2 class="page-title">
                    Пријава испита
                  </h2>
                  
                </div>
                
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-pregled">
                                Испити које могу да пријавим
                            </a>
                          </span>
                      
                      <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Пријава испита
                      </a>
                      <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                      </a>
                    </div>
                  </div>
              </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-body">
                <h4>Пријављени испити</h4>
                <div id="errors" class="alert alert-danger " role="alert" style="display:none;">
                  <div class="d-flex">
                    <div>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 8l0 4" /><path d="M12 16l.01 0" /></svg>
                    </div>
                    <div>
                      <h4 class="alert-title">Грешка</h4>
                      <div class="text-muted"></div>
                    </div>
                  </div>
                 
                </div>
                <?php $jeste_ispit = false; ?>
                @if(count($prijavljeni->where('zakljucana', 0)))
                <div id="table-default" class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          @if($ima_rokova_sa_prijavom_u_toku)
                          <th>Одјава</th>
                          @endif
                          <th><button class="table-sort" data-sort="sort-obaveza">Рок</button></th>

                          <th><button class="table-sort" data-sort="sort-naziv">Назив</button></th>
                          
                          <th><button class="table-sort" data-sort="sort-obaveza">Обавеза</button></th>
                          <th><button class="table-sort" data-sort="sort-datum">Датум</button></th>
                          <th><button class="table-sort" data-sort="sort-vreme">Време</button></th>
                          <th>Сала</th>
                          <th>Број поена</th>
                          <th>Оцена</th>
                          <th>Потписао</th>
                          <th>Порука</th>
                          <th>Потврда изласка</th>
                          <th>QR код</th>
                        </tr>
                      </thead>
                      <tbody class="table-tbody">
                        <?php $jeste_ispit = false; ?>
                    @foreach($prijavljeni->where('zakljucana', 0) as $prijavljen)
            
                        <tr>
                          @if($ima_rokova_sa_prijavom_u_toku)
                          <td><a href="{{route('odjava_ispita', $prijavljen->id_prijave)}}" class="btn btn-danger btn-sm">
                            Одјава
                          </a></td>
                          @endif
                          <td data-sort="rok-naziv">{{$prijavljen->rok}}</td>

                          <td data-sort="sort-naziv">{{$prijavljen->predmet}} [{{$prijavljen->sifra}}]</td>
                          <td>{{$prijavljen->obaveza}}</td>
                          <td data-sort="sort-datum">{{Carbon\Carbon::parse($prijavljen->datum)->format('d.m.Y.')}}</td>
                          <td data-sort="sort-vreme">{{Carbon\Carbon::parse($prijavljen->vreme)->format('H:i') == "00:00" ? "" : Carbon\Carbon::parse($prijavljen->vreme)->format('H:i')}}</td>
                          <td data-bs-toggle="tooltip" data-bs-placement="top" 
                          title="Пун назив: {{$prijavljen->pun_naziv}}, Локација: {{$prijavljen->lokacija}}, {{$prijavljen->naziv_zgrade}} - {{$prijavljen->adresa}}">{{$prijavljen->skraceni_naziv}}</td>
                          <td>{{$prijavljen->broj_poena}}</td>
                          <td>@if(!$prijavljen->jeste_ispit && ($prijavljen->ocena==NULL || $prijavljen->ocena>4)) <span data-bs-toggle="tooltip" data-bs-placement="top" 
                            title="Обавеза није испитна, па се не може унети оцена">/</span> @else {{
                              $prijavljen->ocena == 3 ? 'Н.И.' : ($prijavljen->ocena==4 ? 'Удаљен' : $prijavljen->ocena) 
                            }} @endif</td>
                          <td>{{$prijavljen->nastavnik}}</td>
                          <td>{{$prijavljen->poruka}}</td>
                          <td>

                   
                         
                            <label class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="check-izlazak-{{$prijavljen->sifra}}" @if($prijavljen->potvrda_izlaska)checked= "checked" @endif onchange="checkChange('{{$prijavljen->sifra}}', {{$prijavljen->id_prijave}})">
                              <div class="spinner-border" role="status" id="spinner-izlazak-{{$prijavljen->sifra}}" style="display: none;">
                                <span class="visually-hidden">Учитавање...</span>
                              </div>
                              <span class="form-check-label" id="tekst-izlazak-{{$prijavljen->sifra}}">{{$prijavljen->potvrda_izlaska ? "Да" : "Не"}}</span>
                           
                              
                            </label> 
                                               
                          </td>
                          <td>{!!QrCode::generate($prijavljen->id_prijave)!!} </td>
                        </tr>
                      @endforeach
                      <?php $jeste_ispit = false; ?>
                      @foreach($prijavljeni_grupa->where('zakljucana', 0) as $prijavljen)
                      
                        <tr>
                          <?php $jeste_ispit = false; ?>
                          @if($ima_rokova_sa_prijavom_u_toku)
                          <td><a href="{{route('odjava_ispita', $prijavljen->id_prijave)}}" class="btn btn-danger btn-sm">
                            Одјава
                          </a></td>
                          @endif
                          <td data-sort="rok-naziv">{{$prijavljen->rok}}</td>

                          <td data-sort="sort-naziv">{{$prijavljen->predmet}} [{{$prijavljen->sifra}}]</td>
                          <td><?php  $i=1;
                          $duz=count($prijavljeni_grupa_detalji[$prijavljen->id_prijave]);
                          $jeste_ispit = false;
                          foreach($prijavljeni_grupa_detalji[$prijavljen->id_prijave] as $prr){
                            //print_r($prr);
                            $naz = $prr->naziv;
                            switch($naz){
                                    case (strpos($naz,'Први')!==false || strpos($naz,'Прва')!==false || strpos($naz,'прва')!==false || strpos($naz,'први')!==false):
                                      echo 'К1';
                                      break;
                                    case (strpos($naz,'Други')!==false || strpos($naz,'други')!==false || strpos($naz,'Друга')!==false || strpos($naz,'друга')!==false):
                                      echo 'К2';
                                      break;
                                    case (strpos($naz,'Трећи')!==false || strpos($naz,'трећи')!==false || strpos($naz,'трећа')!==false || strpos($naz,'Трећа')!==false):
                                      echo 'К3';
                                      break;
                                    case (strpos($naz,'испит')!==false || strpos($naz,'Испит')!==false):
                                      echo 'И';
                                      break;
                                    default;
                                      echo $naziv;
                                      break;
                                  }
                                  if($i!=$duz) echo "+";
                                  $i++;
                                  $jeste_ispit =  $jeste_ispit || $prr->jeste_ispit;
                          }?></td>
                          <td data-sort="sort-datum">{{Carbon\Carbon::parse($prijavljen->datum)->format('d.m.Y.')}}</td>
                          <td data-sort="sort-vreme">{{Carbon\Carbon::parse($prijavljen->vreme)->format('H:i') == "00:00" ? "" : Carbon\Carbon::parse($prijavljen->vreme)->format('H:i')}}</td>
                          <td data-bs-toggle="tooltip" data-bs-placement="top" 
                          title="Пун назив: {{$prijavljen->pun_naziv}}, Локација: {{$prijavljen->lokacija}}, {{$prijavljen->naziv_zgrade}} - {{$prijavljen->adresa}}">{{$prijavljen->skraceni_naziv}}</td>
                          <td>{{$prijavljen->broj_poena}}</td>
                          <td>@if(!$jeste_ispit && ($prijavljen->ocena==NULL || $prijavljen->ocena>4)) <span data-bs-toggle="tooltip" data-bs-placement="top" 
                            title="Обавеза није испит, те се не може унети оцена">/</span> @else {{
                              $prijavljen->ocena == 3 ? 'Н.И.' : ($prijavljen->ocena==4 ? 'Удаљен' : $prijavljen->ocena) 
                            }} @endif</td>
                          <td>{{$prijavljen->nastavnik}}</td>
                          <td>{{$prijavljen->poruka}}</td>
                          <td>

                   
                         
                            <label class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="check-izlazak-{{$prijavljen->sifra}}" @if($prijavljen->potvrda_izlaska)checked= "checked" @endif onchange="checkChange('{{$prijavljen->sifra}}', {{$prijavljen->id_prijave}})">
                              <div class="spinner-border" role="status" id="spinner-izlazak-{{$prijavljen->sifra}}" style="display: none;">
                                <span class="visually-hidden">Учитавање...</span>
                              </div>
                              <span class="form-check-label" id="tekst-izlazak-{{$prijavljen->sifra}}">{{$prijavljen->potvrda_izlaska ? "Да" : "Не"}}</span>
                           
                              
                            </label> 
                                               
                          </td>
                          <td>{!! QrCode::generate($prijavljen->id_prijave) !!}</td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>

            
                @else
                <div class="alert alert-info" role="alert">
                  <div class="d-flex">
                    <div>
                      <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                    </div>
                    <div>
                      Тренутно немате пријављених испита.
                    </div>
                  </div>
                </div>
              @endif</div>
        </div>
      </div>
    </div>
    @endsection
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" style="visibility: hidden">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Пријава испита</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="POST" name="prijava" action="{{route('prijavi_ispit')}}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Стање рачуна: {{$balans->balans}} дин.</label>
                </div>
              <div class="mb-3">
                <label class="form-label">Избор рока</label>
                    <select class="form-select" onchange="displayPredmeti()" id="izborRoka" name="izborRoka">
                      <option>Изаберите рок</option>
                      @foreach($rokovi as $rok)
                        <option value="{{$rok->id}}">{{$rok->naziv}}</option>
                      @endforeach
                    </select>
              </div>
              
              <div class="mb-3">
                <label class="form-label">Избор предмета</label>
                    <select class="form-select" onchange="displayObaveze()" id="izborPredmeta" name="izborPredmeta">
                      <option value="{{null}}">Изаберите предмет</option>
                      @foreach($rokovi as $rok)
                      @php $prij=$prijavljeni->where('id_rok', $rok->id)->pluck('sifra');
                      $prijavljeni_gr = $prijavljeni_grupa->where('id_rok', $rok->id)->pluck('sifra');@endphp
                        @foreach($predmeti->where('id_rok', $rok->id)->whereNotIn('sifra', $prij)->whereNotIn('sifra', $prijavljeni_gr)->unique('sifra') as $predmet)
                        <option class="predmet-{{$rok->id}} d-none predmeti_izbor" value="{{$rok->id}}|{{$predmet->sifra}}">{{$predmet->naziv_predmeta}} [{{$predmet->sifra}}]</option>
                        @endforeach
                      @endforeach
                    </select>
                   
              </div>
              <label class="form-label">Избор обавезе</label>
              <div class="form-selectgroup-boxes row mb-3">
                @foreach($rokovi as $rok)
                @php $prij=$prijavljeni->where('id_rok', $rok->id)->pluck('sifra');@endphp
                    @foreach($predmeti->where('id_rok', $rok->id)->whereNotIn('sifra', $prij)->unique('sifra') as $predmet)
                        @foreach($predmeti->where('sifra', $predmet->sifra)->where('id_rok', $rok->id) as $arr)
  
                          <div class="col-lg-3 obaveze-opcije d-none {{$rok->id}}{{$predmet->sifra}}" >
                            <label class="form-selectgroup-item">
                              <input type="radio" value="{{$arr->id_predmetne_grupe_u_roku}}" class="form-selectgroup-input" name="izborObaveza">
                              <span class="form-selectgroup-label d-flex align-items-center p-3">
                                <span class="me-3">
                                  <span class="form-selectgroup-check"></span>
                                </span>
                                <span class="form-selectgroup-label-content">
                                  <span class="form-selectgroup-title strong mb-1">{{$arr->obaveza}}</span>
                                  <!--<span class="d-block text-muted">Provide only basic data needed for the report</span>-->
                                </span>
                              </span>
                            </label>
                          </div>
                        @endforeach
                        @foreach($kombinovane_opcije->where('sifra_predmeta', $predmet->sifra) as $komb)
                        <div class="col-lg-3 obaveze-opcije d-none {{$rok->id}}{{$predmet->sifra}}" >
                          <label class="form-selectgroup-item">
                            <input type="radio" value="komb.{{$komb->id}}" class="form-selectgroup-input" name="izborObaveza">
                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                              <span class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </span>
                              <span class="form-selectgroup-label-content">
                                <span class="form-selectgroup-title strong mb-1">
                                  @php
                                  $nizz = explode(";",$komb->id_predmetnih_obaveza);
                                  $duz = count($nizz);
                                  $i=1;
                                  @endphp
                                  @foreach($nizz as $k)
                                  @php
                                  $naz = (App\Models\PredmetneObaveze::where('id',$k)->first())->naziv;
                                  switch($naz){
                                    case (strpos($naz,'Први')!==false || strpos($naz,'Прва')!==false || strpos($naz,'прва')!==false || strpos($naz,'први')!==false):
                                      echo 'К1';
                                      break;
                                    case (strpos($naz,'Други')!==false || strpos($naz,'други')!==false || strpos($naz,'Друга')!==false || strpos($naz,'друга')!==false):
                                      echo 'К2';
                                      break;
                                    case (strpos($naz,'Трећи')!==false || strpos($naz,'трећи')!==false || strpos($naz,'трећа')!==false || strpos($naz,'Трећа')!==false):
                                      echo 'К3';
                                      break;
                                    case (strpos($naz,'испит')!==false || strpos($naz,'Испит')!==false):
                                      echo 'И';
                                      break;
                                    default;
                                      echo $naziv;
                                  }
                                  if($i!=$duz) echo "+";
                                  $i++;
                                  @endphp
                                  
                                  @endforeach</span>
                                <!--<span class="d-block text-muted">Provide only basic data needed for the report</span>-->
                              </span>
                            </span>
                          </label>
                        </div>
                        @endforeach
                    @endforeach
                @endforeach
          
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label class="form-label">Цена</label>
                    <div class="input-group input-group-flat">
                      @foreach($rokovi as $rok)
                      @php $prij=$prijavljeni->where('id_rok', $rok->id)->pluck('sifra');@endphp
                      @foreach($predmeti->where('id_rok', $rok->id)->whereNotIn('sifra', $prij)->unique('sifra') as $predmet)
                      <span class="input-group-text d-none cene ps-1 pe-1" id="cena|{{$rok->id}}|{{$predmet->sifra}}">
                        @if($predmet->broj_prijava > env('BR_PRIJAVA_FREE') && $rok->ispitni) {{env('CENA_PRIJAVE_ISPITA')}}@else 0,00 @endif динара
                      </span>
                      @endforeach
                      @endforeach
         
                    </div>
                  </div>
                </div>
                
              </div>

            </div>

            <div class="modal-footer">
              <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                Откажи
              </a>
              <button type="submit" href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Пријава
              </button>
            </form>
            </div>
          </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-pregled" tabindex="-1" role="dialog" aria-hidden="true" style="visibility: hidden">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Испити које могу да пријавим</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           
            <div id="table-default" class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th rowspan="2" class="align-middle"><button class="table-sort" data-sort="sort-sifra">Шифра</button></th>
                    <th rowspan="2" class="align-middle"><button class="table-sort" data-sort="sort-naziv">Назив</button></th>
                    <th rowspan="2" class="align-middle">Број пријава</th>
                    <th rowspan="2" class="align-middle">Н. гр.</th>
                    <th colspan="2" class="text-center">Обавезе у року</th>
                 
                  </tr>
                  <tr>
                    <th  class="text-center">Рок</th>
                    <th  class="text-center">Доступне обавезе</th>
                  </tr>
                </thead>
                <tbody class="table-tbody">
                
                  @foreach($rokovi as $rok)

                    @foreach($predmeti->where('id_rok', $rok->id)->unique('sifra') as $predmet)
                        <tr>
                          
                          <td data-sort="sort-sifra">
                         
                            <div style="display: inline-block;">
                            @if($prijavljeni->contains(
                              function ($val, $key) use ($rok, $predmet) {
        return $val->sifra == $predmet->sifra && $val->id_rok == $rok->id;
        }) || $prijavljeni_grupa->contains(
                              function ($val, $key) use ($rok, $predmet) {
        return $val->sifra == $predmet->sifra && $val->id_rok == $rok->id;
        }))
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Испит је већ пријављен"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-octagon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M9.103 2h5.794a3 3 0 0 1 2.122 .879l4.101 4.101a3 3 0 0 1 .88 2.123v5.794a3 3 0 0 1 -.879 2.122l-4.101 4.101a3 3 0 0 1 -2.122 .879h-5.795a3 3 0 0 1 -2.122 -.879l-4.101 -4.1a3 3 0 0 1 -.88 -2.123v-5.794a3 3 0 0 1 .879 -2.122l4.101 -4.101a3 3 0 0 1 2.123 -.88z"></path>
                              <path d="M12 8l0 4"></path>
                              <path d="M12 16l.01 0"></path>
                           </svg ></span>
                           @endif
                            {{$predmet->sifra}}</div></td>
                          <td data-sort="sort-naziv">{{$predmet->naziv_predmeta}}</td>
                          <td >{{$predmet->broj_prijava}}</td>
                          <td >{{$predmet->ngr}}</td>
                          <td >{{$rok->naziv}}</td>
                          <td >
                            @if($prijavljeni->contains(
                              function ($val, $key) use ($rok, $predmet) {
            return $val->sifra == $predmet->sifra && $val->id_rok == $rok->id;
                }
                            )) <span class="text-danger">Пријављена обавеза:</span> @php $prom = $prijavljeni->where('id_rok', $rok->id)->Where('sifra', $predmet->sifra)->first(); print_r($prom->obaveza);@endphp
                            
                            
                          @elseif(!$prijavljeni_grupa->isEmpty())

                          @if($prijavljeni_grupa->contains(
                            function ($val, $key) use ($rok, $predmet) {
      return $val->sifra == $predmet->sifra && $val->id_rok == $rok->id;
      }))<span class="text-danger">Пријављена обавеза:</span> <?php $i=1; $duz=count($prijavljeni_grupa_detalji[($prijavljeni_grupa->where('id_rok', $rok->id)->Where('sifra', $predmet->sifra)->first())->id_prijave]); foreach($prijavljeni_grupa_detalji[($prijavljeni_grupa->where('id_rok', $rok->id)->Where('sifra', $predmet->sifra)->first())->id_prijave] as $prr){
                            $naz = $prr->naziv;
                            switch($naz){
                                    case (strpos($naz,'Први')!==false || strpos($naz,'Прва')!==false || strpos($naz,'прва')!==false || strpos($naz,'први')!==false):
                                      echo 'К1';
                                      break;
                                    case (strpos($naz,'Други')!==false || strpos($naz,'други')!==false || strpos($naz,'Друга')!==false || strpos($naz,'друга')!==false):
                                      echo 'К2';
                                      break;
                                    case (strpos($naz,'Трећи')!==false || strpos($naz,'трећи')!==false || strpos($naz,'трећа')!==false || strpos($naz,'Трећа')!==false):
                                      echo 'К3';
                                      break;
                                    case (strpos($naz,'испит')!==false || strpos($naz,'Испит')!==false):
                                      echo 'И';
                                      break;
                                    default;
                                      echo $naziv;
                                  }
                                  if($i!=$duz) echo "+";
                                  $i++;
                            $jeste_ispit =  $jeste_ispit || $prr->jeste_ispit;
                          }?> @endif
                          @else{{ implode(", ",$predmeti->where('sifra', $predmet->sifra)->where('id_rok', $rok->id)->pluck('obaveza')->toArray())}}
                          @if($prijavljeni_grupa->isEmpty())
                          
                          @php $br=1; $duz = $kombinovane_opcije->where('sifra_predmeta', $predmet->sifra)->count(); @endphp
                          @foreach($kombinovane_opcije->where('sifra_predmeta', $predmet->sifra) as $komb)
                          @php
                                  $nizz = explode(";",$komb->id_predmetnih_obaveza);
                                  $duz = count($nizz);
                                  $stampa=[]
                                  @endphp
                                  
                                  @foreach($nizz as $k)
                                  @php
                                  $naz = (App\Models\PredmetneObaveze::where('id',$k)->first())->naziv;
                                  switch($naz){
                                    case (strpos($naz,'Први')!==false || strpos($naz,'Прва')!==false || strpos($naz,'прва')!==false || strpos($naz,'први')!==false):
                                      $stampa[]='К1';
                                      break;
                                    case (strpos($naz,'Други')!==false || strpos($naz,'други')!==false || strpos($naz,'Друга')!==false || strpos($naz,'друга')!==false):
                                    $stampa[]='К2';
                                      break;
                                    case (strpos($naz,'Трећи')!==false || strpos($naz,'трећи')!==false || strpos($naz,'трећа')!==false || strpos($naz,'Трећа')!==false):
                                    $stampa[]='К3';
                                      break;
                                    case (strpos($naz,'испит')!==false || strpos($naz,'Испит')!==false):
                                    $stampa[]='И';
                                      break;
                                    default;
                                    $stampa[]=$naziv;
                                  }

                                  @endphp
                                  
                          @endforeach
                          @php echo(implode("+",$stampa)." |")@endphp
                          @endforeach
                          @endif 
                         
                        </td>
                  @endif
        

                        </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
         
             
          
             
          </div>
        </div>
      </div>
    </div>
    
     <!-- Libs JS -->

     <script>
      
      function displayPredmeti(){
          let izbor = document.getElementById('izborRoka').value;
          var elementi = document.getElementsByClassName("predmeti_izbor");
          var cene = document.getElementsByClassName('cene');


          for(var i = elementi.length - 1; i >= 0; --i)
          {
            try {
              elementi[i].classList.add("d-none");
              elementi[i].selected = false;
              cene[i].classList.add("d-none");
            }catch{}


          }   
          elementi = document.getElementsByClassName("predmet-"+izbor);

          for(var i = elementi.length - 1; i >= 0; --i)
          {
            try {
              elementi[i].classList.remove("d-none");
            }catch{}

          } 
          elementi = document.getElementsByClassName("obaveze-opcije");

          for(var i = elementi.length - 1; i >= 0; --i)
          {
            try{
              elementi[i].classList.add("d-none");
            }catch{}


          }   
          //document.getElementsByClassName('predmeti_izbor').classList.add("d-none");
          //document.getElementsByClassName('predmet-'+izbor).classList.remove("d-none");
      }
      function displayObaveze(){
          let izbor = document.getElementById('izborPredmeta').value;
          izbor = izbor.split("|");
          var elementi = document.getElementsByClassName("obaveze-opcije");
          var cene = document.getElementsByClassName('cene');

          for(var i = elementi.length - 1; i >= 0; --i)
          {
            try{
              elementi[i].classList.add("d-none");
              cene[i].classList.add('d-none');
            }catch{}

          }
          try{
          document.getElementById("cena|"+izbor[0]+"|"+izbor[1]).classList.remove("d-none");
          elementi = document.getElementsByClassName(izbor[0]+izbor[1]);
          }catch{

          }

          for(var i = elementi.length - 1; i >= 0; --i)
          {
            try{
              elementi[i].classList.remove("d-none");
            }catch{}

          } 
          //document.getElementsByClassName('predmeti_izbor').classList.add("d-none");
          //document.getElementsByClassName('predmet-'+izbor).classList.remove("d-none");
      }
      
      </script>
    <script>
      function checkChange(prom, id){
        document.getElementById('spinner-izlazak-'+prom).style.display = "block";
        document.getElementById('tekst-izlazak-'+prom).style.display = "none";
        const delay = ms => new Promise(res => setTimeout(res, ms));
        const url = '/azuriraj_izlazak/'+id+'/'+(document.getElementById('tekst-izlazak-'+prom).innerText == "Не" ? "1" : "0");
            $.ajax({
               type:'GET',
               url:url,
               contentType: false,
            cache: false,
            processData: false,
               //data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                if(data['msg']){
                  document.getElementById('errors').style.display = 'block';
                  document.querySelector('#errors div:nth-child(2)').innerText = data['msg'];
                  //document.getElementById('errors').div.div.div.
                  
                }
                if(data['tip'] == 1){
                    document.getElementById('check-izlazak-'+prom).checked = true; 
     document.getElementById('tekst-izlazak-'+prom).innerText = "Да"; 

      }
      else {document.getElementById('check-izlazak-'+prom).checked = false; document.getElementById('tekst-izlazak-'+prom).innerText = "Не";}
      document.getElementById('spinner-izlazak-'+prom).style.display = "none";
            document.getElementById('tekst-izlazak-'+prom).style.display = "block";

            
               }
            });

            

        /*const yourFunction = async () => {
      await delay(5000);
      console.log("Waited 5s");
      document.getElementById('spinner-izlazak-'+prom).style.display = "none";
      if(document.getElementById('tekst-izlazak-'+prom).innerText=="Не"){

      document.getElementById('tekst-izlazak-'+prom).innerText = "Да";

      }
      else {document.getElementById('tekst-izlazak-'+prom).innerText = "Не";}
            document.getElementById('tekst-izlazak-'+prom).style.display = "block";
    };*/
      //yourFunction();
      }
      </script>

     <script src="{{asset('dist/libs/list.js/dist/list.min.js?1674944402')}}" defer></script>
     <!-- Tabler Core -->
 
     <script>
       document.addEventListener("DOMContentLoaded", function() {
       const list = new List('table-default', {
           sortClass: 'table-sort',
           listClass: 'table-tbody',
           valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
               
               'sort-espb', 'sort-put', 'sort-cena', 'sort-grupe', 'sort-datum', 'sort-vreme', 'sort-obaveza'
           ]
       });
       });
      
     </script>
 
 