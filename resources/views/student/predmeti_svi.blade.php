@extends('layouts.header_side')
@section('title', 'Моји предмети')
@section('content')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Предмети
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
                        <th><button class="table-sort" data-sort="sort-sk">Школска година</button></th>
                        <th><button class="table-sort" data-sort="sort-grupe" >Наставне групе</button></th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      @foreach($predmeti as $predmet)
                      <tr>
                        <td class="sort-sifra">{{$predmet->sifra}}</td>
                        <td class="sort-naziv">{{$predmet->naziv}}</td>
                        <td class="sort-semestar">{{$predmet->semestar}}</td>
                        <td class="sort-status">{{$predmet->status == "O" ? "обавезан" : "изборни"}}</td>
       
                        <td class="sort-espb">{{$predmet->espb}}</td>
                        <td class="sort-sk">{{$predmet->sk}}</td>
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

