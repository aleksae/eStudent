@extends('layouts.header_side')
@section('title', 'Моја ангажовања')
@section('content')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Предмети на катедри {{$organizaciona_jedinica->naziv}}
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
                        <th><button class="table-sort" data-sort="sort-ts">Тип студија</button></th>
                        <th><button class="table-sort" data-sort="sort-semestar">Семестар</button></th>
                        <th><button class="table-sort" data-sort="sort-status">И/О</button></th>
                        <th>Предавања</th>
                        <th>Вежбе</th>
                        <th>ДОН</th>
                        <th><button class="table-sort">Акција</button></th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                        @foreach($predmeti as $p)
                        @php
                        $nastavnici_unique_p = $angazovani[$p->sifra]->where('tip', 'П')->unique('id');
                        $nastavnici_unique_v = $angazovani[$p->sifra]->where('tip', 'В')->unique('id');
                        $nastavnici_unique_l = $angazovani[$p->sifra]->where('tip', 'Л')->unique('id');
                        $nastavnici_1 = $angazovani[$p->sifra];
                        @endphp
                        <tr>
                          <td class="sort-sifra">{{$p->sifra}}</td>
                          <td class="sort-naziv">{{$p->naziv}}</td>
                          <td class="sort-ts">{{$p->tip_studija}} - {{$p->skracenica}}</td>
                          <td class="sort-semestar">{{$p->semestar}}</td>
                          <td class="sort-status">{{$p->status=="I" ? "И" : "О"}}</td>
                          
                          <td>
                            @foreach($nastavnici_unique_p as $nast)
              
                @if($nast->tip=="П")<li>{{App\Models\Nastavnik::formatiraj_ime($nast->ime, $nast->prezime, $nast->id_zvanja, $nast->naziv_zvanja, $nast->strucno_zvanje)}} 
                  @php //implode(", ", $nastavnici->where('id', $nast->id)->where('tip', 'П')->only(['broj'])->all())
                  $i=0; $vel = $nastavnici_1->where('id', $nast->id)->where('tip', 'П')->count();
                  echo("(");
                  foreach($nastavnici_1->where('id', $nast->id)->where('tip', 'П') as $gr){
                    echo("П".$gr->broj);
                    if($i!=($vel-1)) echo(", ");
                    $i++;
                  }
                  echo(")");
                  @endphp </li>@endif
              @endforeach
                          </td>
                          <td>
                            @foreach($nastavnici_unique_v as $nast)
                @if($nast->tip=="В")<li>{{App\Models\Nastavnik::formatiraj_ime($nast->ime, $nast->prezime, $nast->id_zvanja, $nast->naziv_zvanja, $nast->strucno_zvanje)}}
                  @php //implode(", ", $nastavnici->where('id', $nast->id)->where('tip', 'П')->only(['broj'])->all())
                  $i=0; $vel = $nastavnici_1->where('id', $nast->id)->where('tip', 'В')->count();
                  echo("(");
                  foreach($nastavnici_1->where('id', $nast->id)->where('tip', 'В') as $gr){
                    echo("В".$gr->broj);
                    if($i!=($vel-1)) echo(", ");
                    $i++;
                  }
                  echo(")");
                  @endphp
                </li>@endif
              @endforeach
                          </td>
                          <td>@foreach($nastavnici_unique_l as $nast)
                            @if($nast->tip=="Л")<li>{{App\Models\Nastavnik::formatiraj_ime($nast->ime, $nast->prezime, $nast->id_zvanja, $nast->naziv_zvanja, $nast->strucno_zvanje)}}
                              @php //implode(", ", $nastavnici->where('id', $nast->id)->where('tip', 'П')->only(['broj'])->all())
                              $i=0; $vel = $nastavnici_1->where('id', $nast->id)->where('tip', 'Л')->count();
                              echo("(");
                              foreach($nastavnici_1->where('id', $nast->id)->where('tip', 'Л') as $gr){
                                echo("Л".$gr->broj);
                                if($i!=($vel-1)) echo(", ");
                                $i++;
                              }
                              echo(")");
                              @endphp
                            </li>@endif
                          @endforeach</td>
                          <td ><a href="{{route('upravljanje_konkretnim_predmetom', $p->sifra)}}">Уреди</a></td>
                          
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
        
    <!-- Libs JS -->
    <script src="{{asset('dist/libs/list.js/dist/list.min.js?1674944402')}}" defer></script>
   
    <script>
      document.addEventListener("DOMContentLoaded", function() {
      const list = new List('table-default', {
      	sortClass: 'table-sort',
      	listClass: 'table-tbody',
      	valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
      		
      		'sort-ts', 'sort-program', 'sort-grupe'
      	]
      });
      })
    </script>

