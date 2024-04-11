@extends('layouts.header_side')
@section('title', 'Дежурства')
@section('content')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Дежурства
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
                @if(count($dezurstva))
                <div id="table-default" class="table-responsive">
            
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><button class="table-sort" data-sort="sort-sifra">Шифра</button></th>
                        <th><button class="table-sort" data-sort="sort-naziv">Назив</button></th>
                        
                        <th><button class="table-sort" data-sort="sort-grupe" >Рок</button></th>
                        <th><button class="table-sort" data-sort="sort-sk">Датум</button></th>
                        <th><button class="table-sort" data-sort="sort-espb">Време</button></th>
                        <th><button class="table-sort" data-sort="sort-semestar">Просторија</button></th>
                        <th><button class="table-sort" data-sort="sort-status">Зборно место</button></th>
                        
                        
                        
                     
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                     
                      @foreach($dezurstva as $dezurstvo)
                    
                      <tr>
                        <td class="sort-sifra">
                        {{$dezurstvo->sifra}}</td>
                        <td class="sort-naziv">{{$dezurstvo->predmet}}</td>
                        <td class="sort-grupe">{{$dezurstvo->rok}}</td>
                        <td class="sort-sk">{{Carbon\Carbon::parse($dezurstvo->datum)->format("d.m.Y.")}}</td>
                        <td class="sort-espb">{{$dezurstvo->vreme}}</td>
                        <td class="sort-semestar"><strong>{{$dezurstvo->pun_naziv}}</strong> - {{$dezurstvo->lokacija}}, {{$dezurstvo->naziv_zgrade}}</td>
                        <td class="sort-status">@php print_r($dezurstvo->zborno_mesto); @endphp</td>
                        
                        
                        
                        
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
                      Тренутно немате дежурстава
                    </div>
                  </div>
                </div>
                @endif
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

