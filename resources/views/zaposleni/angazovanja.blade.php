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
                  Моја ангажовања
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
                        <th><button class="table-sort" data-sort="sort-semestar">Тип студија</button></th>
                        <th><button class="table-sort" data-sort="sort-sk">Тип наставе</button></th>
                        <th><button class="table-sort" data-sort="sort-grupe" >Наставна група</button></th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      @foreach($angazovanja as $a)
                      <tr>
                        <td class="sort-sifra"><a href="{{route('zap.predmeti.uredjivanje_aktivnosti', $a->sifra)}}">{{$a->sifra}}</a></td>
                        <td class="sort-naziv">{{$a->naziv}}</td>
                        <td class="sort-semestar">{{$a->tip_studija}}</td>
                        <td class="sort-sk">{{$a->tip == "П" ? "Предавања" : ($a->tip=="В" ? "Вежбе" : "Лабораторијске вежбе и др.")}}</td>
       
                        <td class="sort-grupe">{{$a->broj}}</td>
                        
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
      		
      		'sort-espb', 'sort-sk', 'sort-grupe'
      	]
      });
      })
    </script>

