@extends('layouts.header_side')
@section('title', 'Рокови')
@section('content')
<style>
    table.table-fit {
    width: auto !important;
    table-layout: auto !important;
}
table.table-fit thead th, table.table-fit tfoot th {
    width: auto !important;
}
table.table-fit tbody td, table.table-fit tfoot td {
    width: auto !important;
}
table.table-fit td{

  font-size: 0.8rem;

}
</style>
      <div class="page-wrapper" onload="wrapper()">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Рокови
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
                  <table class="table table-striped table-hover table-fit">
                    <thead>
                      <tr>
                        <th><button class="table-sort" data-sort="sort-sifra">Назив рока</button></th>
                        <th><button class="table-sort" data-sort="sort-naziv">Почетак пријава</button></th>
                        <th><button class="table-sort" data-sort="sort-semestar">Крај пријава</button></th>
                        <th><button class="table-sort" data-sort="sort-status">Почетак рока</button></th>
                        <th><button class="table-sort" data-sort="sort-espb">Крај рока</button></th>
                        <th><button class="table-sort" >Моји</button></th>
                        <th><button class="table-sort" >Сви</button></th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                    
                      @foreach($rokovi as $rok)
                      <tr>
                        <td class="sort-sifra">{{mb_strtoupper(mb_substr($rok->naziv, 0, 1)).mb_substr($rok->naziv, 1)}}</td>
                        <td class="sort-naziv">{{Carbon\Carbon::parse($rok->pocetak_prijave)->format('d.m.Y.')}}</td>
                        <td class="sort-semestar">{{Carbon\Carbon::parse($rok->kraj_prijave)->format('d.m.Y.')}}</td>
                        <td class="sort-status">{{Carbon\Carbon::parse($rok->pocetak_roka)->format('d.m.Y.')}}</td>
       
                        <td class="sort-espb">{{Carbon\Carbon::parse($rok->kraj_roka)->format('d.m.Y.')}}</td>
                        <td><a href="#" onclick="prikazMoji({{$rok->id}})">моји</a></td>
                        <td><a href="#" onclick="prikazSvi({{$rok->id}})">сви</a></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @foreach($rokovi as $rok)
                <div id="moji-{{$rok->id}}" class="rokovi-moji">
                    <h4 class="mt-2">Моји испити за {{$rok->naziv}}</h4>
                    @if(count($ispiti->where('id_roka', $rok->id)->where('moj', 1)))
                    <div id="table-default" class="table-responsive">
                        <table class="table table-striped table-hover table-fit">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-sifra-{{$rok->id}}-moji">Шифра испита</button></th>
                                <th><button class="table-sort" data-sort="sort-naziv-{{$rok->id}}-moji">Назив</button></th>
                                <th><button class="table-sort" data-sort="sort-ng-{{$rok->id}}-moji">Наставна група</button></th>
                                <th><button class="table-sort" data-sort="">Обавеза</button></th>
                                <th><button class="table-sort" data-sort="sort-datum-{{$rok->id}}-moji">Датум</button></th>
                                <th><button class="table-sort" data-sort="sort-vreme-{{$rok->id}}-moji">Време</button></th>
                                <th><button class="table-sort" >Сале</button></th>
                        
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @php $moji = $ispiti->where('id_roka', $rok->id)->where('moj', 1);@endphp
                            @foreach($moji as $moj)
                            <tr>
                                <td class="sort-sifra-{{$rok->id}}-moji">
                                  @if(Auth::user()->isStudent())
                                  {{$moj->id_predmeta}}
                                @else
                                <a href="{{route("zap.predmet_u_roku", ['rok'=>$rok->id, 'predmet'=>$moj->id_predmeta])}}" >{{$moj->id_predmeta}}</a>
                              @endif</td>
                                <td class="sort-naziv-{{$rok->id}}-moji">{{$moj->predmet}}</td>
                                <td class="sort-ng-{{$rok->id}}-moji">{{$moj->broj}}</td>
                                <td>{{$moj->obaveza}}</td>
                                <td class="sort-datum-{{$rok->id}}-moji">{{Carbon\Carbon::parse($moj->datum)->format('d.m.Y.')}}</td>
               
                                <td class="sort-vreme-{{$rok->id}}-moji">{{$moj->vreme=="00:00:00" ? "" : Carbon\Carbon::parse($moj->vreme)->format("H:i")}}</td>
                                <td >{{implode(", ",$sale->where('id_grupe_u_roku', $moj->id_pred_gr)->pluck('skraceni_naziv')->toArray())}}</td>
                            </tr>
                            @endforeach
                            
                            @foreach($prijavljeni_grupa_detalji as $key=>$val)
                              
                                @if($val[0]->moj)
                                  @php $prom = $ispiti_spojeno->where('id_rok', $rok->id)->where('id_pred_gr', $key)->first(); @endphp
                                  @if($prom)
                                    <tr>
                                      <td class="sort-sifra-{{$rok->id}}-moji">
                                        @if(Auth::user()->isStudent())
                                        {{$prom->sifra_predmeta}}
                                @else
                                <a href="{{route("zap.predmet_u_roku", ['rok'=>$rok->id, 'predmet'=>$prom->sifra_predmeta])}}" >{{$prom->sifra_predmeta}}</a>
                              @endif
                                        
                                        </td>
                                      <td class="sort-naziv-{{$rok->id}}-moji">{{$prom->predmet}}</td>
                                      <td class="sort-ng-{{$rok->id}}-moji">{{$val[0]->ngr}}</td>
                                      <td class="sort-ng-{{$rok->id}}-moji">
                                        @php $niz = []; @endphp
                                        @foreach($val as $v)
                                        @php $naz = $v->naziv; switch($naz){
                                          case (strpos($naz,'Први')!==false || strpos($naz,'Прва')!==false || strpos($naz,'прва')!==false || strpos($naz,'први')!==false):
                                            $niz[]= 'К1';
                                            break;
                                          case (strpos($naz,'Други')!==false || strpos($naz,'други')!==false || strpos($naz,'Друга')!==false || strpos($naz,'друга')!==false):
                                            $niz[]= 'К2';
                                            break;
                                          case (strpos($naz,'Трећи')!==false || strpos($naz,'трећи')!==false || strpos($naz,'трећа')!==false || strpos($naz,'Трећа')!==false):
                                            $niz[]= 'К3';
                                            break;
                                          case (strpos($naz,'испит')!==false || strpos($naz,'Испит')!==false):
                                            $niz[]='И';
                                            break;
                                          default;
                                            $niz[]= $naziv;
                                        } @endphp
                                        @endforeach {{implode("+",$niz)}}</td>
                                        <td class="sort-datum-{{$rok->id}}-moji">{{Carbon\Carbon::parse($prom->datum)->format('d.m.Y.')}}</td>
               
                                <td class="sort-vreme-{{$rok->id}}-moji">{{$prom->vreme=="00:00:00" ? "" : Carbon\Carbon::parse($prom->vreme)->format("H:i")}}</td>
                                <td >{{implode(", ",$sale_2->where('id_grupe_u_roku', $prom->id_pred_gr)->pluck('skraceni_naziv')->toArray())}}</td>
                                  </tr>
                                  @endif
                                @endif
                              
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
                          Немате испита за дати рок.
                        </div>
                      </div>
                    </div>
                    @endif
                </div>
                <div id="svi-{{$rok->id}}" class="rokovi-svi">
                <h4 class="mt-2">Сви испити за {{$rok->naziv}}</h4>
                <div id="table-default" class="table-responsive">
                    <table class="table table-striped table-hover table-fit">
                      <thead>
                        <tr>
                          <th><button class="table-sort" data-sort="sort-sifra-{{$rok->id}}-svi">Шифра испита</button></th>
                          <th><button class="table-sort" data-sort="sort-naziv-{{$rok->id}}-svi">Назив</button></th>
                          <th><button class="table-sort" data-sort="sort-ng-{{$rok->id}}-svi">Наставна група</button></th>
                          <th><button class="table-sort" data-sort="">Обавеза</button></th>
                          <th><button class="table-sort" data-sort="sort-datum-{{$rok->id}}-svi">Датум</button></th>
                          <th><button class="table-sort" data-sort="sort-vreme-{{$rok->id}}-svi">Време</button></th>
                          <th><button class="table-sort" >Сале</button></th>
                       
                        </tr>
                      </thead>
                      <tbody class="table-tbody">
                         @php $moji = $ispiti->where('id_roka', $rok->id);@endphp
                        @foreach($moji as $moj)
                        <tr>
                          <td class="sort-sifra-{{$rok->id}}-svi">{{$moj->id_predmeta}}</td>
                          <td class="sort-naziv-{{$rok->id}}-svi">{{$moj->predmet}}</td>
                          <td class="sort-ng-{{$rok->id}}-svi">{{$moj->broj}}</td>
                          <td>{{$moj->obaveza}}</td>
                          <td class="sort-datum-{{$rok->id}}-svi">{{Carbon\Carbon::parse($moj->datum)->format('d.m.Y.')}}</td>
         
                          <td class="sort-vreme-{{$rok->id}}-svi">{{$moj->vreme=="00:00:00" ? "" : Carbon\Carbon::parse($moj->vreme)->format("H:i")}}</td>
                          <td >{{implode(", ",$sale->where('id_grupe_u_roku', $moj->id_pred_gr)->pluck('skraceni_naziv')->toArray())}}</td>
                        </tr>
                        @endforeach
                        @foreach($prijavljeni_grupa_detalji as $key=>$val)
                              
                              
                                  @php $prom = $ispiti_spojeno->where('id_rok', $rok->id)->where('id_pred_gr', $key)->first(); @endphp
                                  @if($prom)
                                    <tr>
                                      <td class="sort-sifra-{{$rok->id}}-moji">{{$prom->sifra_predmeta}}</td>
                                      <td class="sort-naziv-{{$rok->id}}-moji">{{$prom->predmet}}</td>
                                      <td class="sort-ng-{{$rok->id}}-moji">{{$val[0]->ngr}}</td>
                                      <td class="sort-ng-{{$rok->id}}-moji">
                                        @php $niz = []; @endphp
                                        @foreach($val as $v)
                                        @php $naz = $v->naziv; switch($naz){
                                          case (strpos($naz,'Први')!==false || strpos($naz,'Прва')!==false || strpos($naz,'прва')!==false || strpos($naz,'први')!==false):
                                            $niz[]= 'К1';
                                            break;
                                          case (strpos($naz,'Други')!==false || strpos($naz,'други')!==false || strpos($naz,'Друга')!==false || strpos($naz,'друга')!==false):
                                            $niz[]= 'К2';
                                            break;
                                          case (strpos($naz,'Трећи')!==false || strpos($naz,'трећи')!==false || strpos($naz,'трећа')!==false || strpos($naz,'Трећа')!==false):
                                            $niz[]= 'К3';
                                            break;
                                          case (strpos($naz,'испит')!==false || strpos($naz,'Испит')!==false):
                                            $niz[]='И';
                                            break;
                                          default;
                                            $niz[]= $naziv;
                                        } @endphp
                                        @endforeach {{implode("+",$niz)}}</td>
                                        <td class="sort-datum-{{$rok->id}}-moji">{{Carbon\Carbon::parse($prom->datum)->format('d.m.Y.')}}</td>
               
                                <td class="sort-vreme-{{$rok->id}}-moji">{{$prom->vreme=="00:00:00" ? "" : Carbon\Carbon::parse($prom->vreme)->format("H:i")}}</td>
                                <td >{{implode(", ",$sale_2->where('id_grupe_u_roku', $prom->id_pred_gr)->pluck('skraceni_naziv')->toArray())}}</td>
                                  </tr>
                                  @endif
                            
                              
                            @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endsection
        
    <!-- Libs JS -->
    <script src="{{asset('dist/libs/list.js/dist/list.min.js?1674944402')}}" defer></script>
   
    <script>
      function wrapper(){
        const list = new List('table-default', {
      	sortClass: 'table-sort',
      	listClass: 'table-tbody',
      	valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
      		
      		'sort-espb', 'sort-sk',  'sort-grupe'
        ]
      });
      
      let boxes = document.querySelectorAll('.rokovi-moji');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            boxes = document.querySelectorAll('.rokovi-svi');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
      }
        function prikazMoji(id){
            console.log(id);
            let boxes = document.querySelectorAll('.rokovi-moji');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            boxes = document.querySelectorAll('.rokovi-svi');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            document.getElementById('moji-'+id).classList.remove('d-none');
            
        }
        function prikazSvi(id){
          console.log(id);
            let boxes = document.querySelectorAll('.rokovi-svi');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            boxes = document.querySelectorAll('.rokovi-moji');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            document.getElementById('svi-'+id).classList.remove('d-none');
        }
     
      document.addEventListener("DOMContentLoaded", function() {
      const list = new List('table-default', {
      	sortClass: 'table-sort',
      	listClass: 'table-tbody',
      	valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
      		
      		'sort-espb', 'sort-sk',  'sort-grupe'
        ]
      });
      
      let boxes = document.querySelectorAll('.rokovi-moji');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            boxes = document.querySelectorAll('.rokovi-svi');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
      });
      
    </script>

