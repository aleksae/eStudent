@extends('layouts.header_side')
@section('title', 'Предмети из текуће школске године')
@section('content')

      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Предмети из текуће школске године
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-body">
                <div id="table-default" class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th><button class="table-sort" data-sort="sort-sifra">Шифра</button></th>
                        <th><button class="table-sort" data-sort="sort-naziv">Назив</button></th>
                        <th><button class="table-sort" data-sort="sort-semestar">Семестар</button></th>
                        <th><button class="table-sort" data-sort="sort-status">Статус</button></th>
                        
                        <th><button class="table-sort" data-sort="sort-espb">ЕСПБ</button></th>
                        <th><button class="table-sort" data-sort="sort-put">Тип</button></th>
                        <th><button class="table-sort" data-sort="sort-cena">Цена</button></th>

                        <th><button class="table-sort" data-sort="sort-grupe" >Наставне групе</button></th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      @foreach($predmeti as $predmet)
                      <tr>
                        
                        <td class="sort-sifra"><a href="#"  data-bs-toggle="modal" data-bs-target="#modal-{{$predmet->sifra}}">{{$predmet->sifra}}</a></td>
                        <td class="sort-naziv">{{$predmet->naziv}}</td>
                        <td class="sort-semestar">{{$predmet->semestar}}</td>
                        <td class="sort-status">{{$predmet->status == "O" ? "обавезан" : "изборни"}}</td>
       
                        <td class="sort-espb">{{$predmet->espb}}</td>
                        <td class="sort-put">{{$predmet->put>1 ? "поновно праћење" : "прво праћење"}}</td>
                        <td class="sort-cena">{{$predmet->cena}}</td>
                        <td class="sort-grupe"><span ata-bs-toggle="tooltip" data-bs-placement="top" title="група за предавања">П{{$predmet->grupa_predavanja}}</span>@if($predmet->grupa_vezbe), <span ata-bs-toggle="tooltip" data-bs-placement="top" title="група за вежбе">В{{$predmet->grupa_vezbe}}</span>@endif
                        @if($predmet->grupa_don), <span data-bs-toggle="tooltip" data-bs-placement="top" title="група за друге облике наставе">Л{{$predmet->grupa_don}}</span>@endif</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endsection
        
      
    @foreach($predmeti as $predmet)
    @php 
    $fond = explode("|", $predmet->fond_casova);
    @endphp
    <div class="modal modal-blur fade" id="modal-{{$predmet->sifra}}" tabindex="-1" role="dialog" aria-hidden="true" style="visibility: hidden">
      <div class="modal-dialog modal-dialog-centered modal-full-width modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Информације о предмету {{$predmet->naziv}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h4>Фонд часова:</h4>
      
            <ul class="d-flex d-inline-flex">
              <li class=" d-inline-flex me-2">Предавања: {{$fond[0]}}</li>
              <li class=" d-inline-flex me-2">Вежбе: {{$fond[1]}}</li>
              <li class=" d-inline-flex">ДОН: {{$fond[2]}}</li>
            </ul>
            <br>
            @php
            $nastavnici_unique_p = $angazovani[$predmet->sifra_predmeta]->where('tip', 'П')->unique('id');
            $nastavnici_unique_v = $angazovani[$predmet->sifra_predmeta]->where('tip', 'В')->unique('id');
            $nastavnici_unique_l = $angazovani[$predmet->sifra_predmeta]->where('tip', 'Л')->unique('id');
            @endphp
            @php $nastavnici = $angazovani[$predmet->sifra_predmeta];@endphp
            <h4>Предавања (П{{$predmet->grupa_predavanja}}):</h4>
            <ul>
              @foreach($nastavnici_unique_p as $nast)
              
                @if($nast->tip=="П")<li>
                  @php $id_calc = $nast->id*37+17; @endphp
                  <a href="{{route('zap.profil', $nast->ime."-".$nast->prezime."-".$id_calc)}}" class="">
                  {{App\Models\Nastavnik::formatiraj_ime($nast->ime, $nast->prezime, $nast->id_zvanja, $nast->naziv_zvanja, $nast->strucno_zvanje)}} 
                  </a>
                  @php //implode(", ", $nastavnici->where('id', $nast->id)->where('tip', 'П')->only(['broj'])->all())
                  $i=0; $vel = $nastavnici->where('id', $nast->id)->where('tip', 'П')->count();
                  echo("(");
                  foreach($nastavnici->where('id', $nast->id)->where('tip', 'П') as $gr){
                    echo("П".$gr->broj);
                    if($i!=($vel-1)) echo(", ");
                    $i++;
                  }
                  echo(")");
                  @endphp</li>@endif
              @endforeach
            </ul>
            <h4>Вежбе @if($predmet->grupa_vezbe)(В{{$predmet->grupa_vezbe}})@endif:</h4>
            
              @if($fond[1]==0)
              /
              @else
              <ul>
              @foreach($nastavnici_unique_v as $nast)
                @if($nast->tip=="В")<li>
                  @php $id_calc = $nast->id*37+17; @endphp
                  <a href="{{route('zap.profil', $nast->ime."-".$nast->prezime."-".$id_calc)}}" class="">
                    {{App\Models\Nastavnik::formatiraj_ime($nast->ime, $nast->prezime, $nast->id_zvanja, $nast->naziv_zvanja, $nast->strucno_zvanje)}}
                  </a>
                  @php //implode(", ", $nastavnici->where('id', $nast->id)->where('tip', 'П')->only(['broj'])->all())
                  $i=0; $vel = $nastavnici->where('id', $nast->id)->where('tip', 'В')->count();
                  echo("(");
                  foreach($nastavnici->where('id', $nast->id)->where('tip', 'В') as $gr){
                    echo("В".$gr->broj);
                    if($i!=($vel-1)) echo(", ");
                    $i++;
                  }
                  echo(")");
                  @endphp
                </li>@endif
              @endforeach
            </ul>
              @endif
            
            <h4>ДОН @if($predmet->grupa_don)(Л{{$predmet->grupa_don}})@endif:</h4>
           
              @if($fond[2]==0) 
              /
              @else
              <ul>
              @foreach($nastavnici_unique_l as $nast)
                @if($nast->tip=="Л")<li>
                  @php $id_calc = $nast->id*37+17; @endphp
                  <a href="{{route('zap.profil', $nast->ime."-".$nast->prezime."-".$id_calc)}}" class="">
                    {{App\Models\Nastavnik::formatiraj_ime($nast->ime, $nast->prezime, $nast->id_zvanja, $nast->naziv_zvanja, $nast->strucno_zvanje)}}
                  </a>
                  @php //implode(", ", $nastavnici->where('id', $nast->id)->where('tip', 'П')->only(['broj'])->all())
                  $i=0; $vel = $nastavnici->where('id', $nast->id)->where('tip', 'Л')->count();
                  echo("(");
                  foreach($nastavnici->where('id', $nast->id)->where('tip', 'Л') as $gr){
                    echo("Л".$gr->broj);
                    if($i!=($vel-1)) echo(", ");
                    $i++;
                  }
                  echo(")");
                  @endphp
                </li>@endif
              @endforeach
              </ul>
              @endif


              <h4 class="mt-2">Предиспитне обавезе</strong></h4>
              
              @php $pob = $predmetne_obaveze->where('id_grupe_predmeta', $predmet->og_g_predavanja)->where('jeste_ispit', 0); @endphp
              @if($pob->count())
              <div class="table-responsive ">
              <table class="table table-striped table-bordered "   id="table_predispitne">
                <thead>
                  <tr>
                    <th scope="col">Назив</th>
                    <th scope="col">Максималан број поена</th>
                    <th scope="col">Учешће у укупној оцени </th>
                    <th scope="col">Број прилика за полагање</th>
                    <th scope="col">Опис</th>
                  </tr>
                </thead>
                <tbody>
                  
              @foreach($pob as $po)
                <tr>
                  <th scope="row" >[{{$po->id}}] {{$po->naziv}}</th>
                  <td >{{$po->maks_broj_poena}}</td>
                  <td >{{$po->procenat_u_ukupnoj_oceni}}/100</td>
                  <td >@php switch($po->broj_prilika_za_polaganje){
                    case -1:
                      echo("У свим роковима које прописује факултет");
                      break;
                    case -2:
                      echo("Организација независно од факултетских рокова");
                      break;
                    case -3:
                      echo("У свим роковима осим у јануарском року");
                      break;
                    case -4:
                      echo("У свим роковима  осим у јунском року");
                      break;
                    default:
                      echo($po->broj_prilika_za_polaganje);
                      break;
                  }@endphp</td>
                  <td >{{$po->opis_pravila}}</td>
                </tr>
              @endforeach
                </tbody>
              </table>
              </div>
              @else
              <p>Нема података о предиспитним обавезама</p>
              @endif
              <h4 class="mt-2">Испитне обавезе</strong></h4>
              @php $pob = $predmetne_obaveze->where('id_grupe_predmeta', $predmet->og_g_predavanja)->where('jeste_ispit', 1); @endphp
              @if($pob->count())
              <div class="table-responsive ">
              <table class="table table-striped table-bordered "  id="table_predispitne">
                <thead>
                  <tr>
                    <th scope="col">Назив</th>
                    <th scope="col">Максималан број поена</th>
                    <th scope="col">Учешће у укупној оцени </th>
                    <th scope="col">Број прилика за полагање</th>
                    <th scope="col">Други део испита (усмени)</th>
                    <th scope="col">Опис</th>
                  </tr>
                </thead>
                <tbody>
                  
              @foreach($pob as $po)
                <tr>
                  <th scope="row" >{{$po->naziv}}</th>
                  <td >{{$po->maks_broj_poena}}</td>
                  <td >{{$po->procenat_u_ukupnoj_oceni}}/100</td>
                  <td >@php switch($po->broj_prilika_za_polaganje){
                    case -1:
                      echo("У свим роковима које прописује факултет");
                      break;
                    case -2:
                      echo("Организација независно од факултетских рокова");
                      break;
                    case -3:
                      echo("У свим роковима осим у јануарском року");
                      break;
                    case -4:
                      echo("У свим роковима  осим у јунском року");
                      break;
                    default:
                      echo($po->broj_prilika_za_polaganje);
                      break;
                  }@endphp</td>
                  <td >{{$po->ima_drugi_deo ? "Да" : "Не"}}</td>
                  <td >{{$po->opis_pravila}}</td>
                </tr>
              @endforeach
                </tbody>
              </table>
              </div>
              @else
              <p>Нема података о испитним обавезама</p>
              @endif
              
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Затвори</button>
            
          </div>
        </div>
      </div>
    </div>

    @endforeach
    
    <!-- Libs JS -->
    <script src="{{asset('dist/libs/list.js/dist/list.min.js?1674944402')}}" defer></script>
    <!-- Tabler Core -->

    <script>
      document.addEventListener("DOMContentLoaded", function() {
      const list = new List('table-default', {
      	sortClass: 'table-sort',
      	listClass: 'table-tbody',
      	valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
      		
      		'sort-espb', 'sort-put', 'sort-cena', 'sort-grupe'
      	]
      });
      });
     
    </script>

