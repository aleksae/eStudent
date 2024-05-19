@extends('layouts.header_side')
@section('title', 'Информације за предмет за р0о')
@section('content')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Информације за {{$rok}} за шифру предмета {{$predmet}} @if(count($ispitne_prijave)){{Carbon\Carbon::parse($vreme)->format('d.m.Y H:i')}}@endif
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
                @if(count($ispitne_prijave))
                <form method="POST" action="{{route("zap.zakljucaj_ocene")}}">
                  @csrf
                  @php
                  $id_niz = "";
                  foreach($ispitne_prijave as $ip){
                    if($id_niz!="")$id_niz = $id_niz.",".$ip->id_prijave;
                    else $id_niz = $ip->id_prijave;
                  }
                  @endphp
                  <input type="hidden" value="{{$id_niz}}" name="id_prijava"/>
                  <button type="submit" class="btn btn-warning">Закључај</button>
                </form>

                <div id="table-default" class="table-responsive">

                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><button class="table-sort" data-sort="sort-sifra">Име</button></th>
                        <th><button class="table-sort" data-sort="sort-naziv">Презиме</button></th>

                        <th><button class="table-sort" data-sort="sort-grupe" >Сала</button></th>
                        <th><button class="table-sort" data-sort="sort-sk" >Обавеза</button></th>
                        @if(Carbon\Carbon::now()>Carbon\Carbon::parse($vreme_kraja))
                        <th>Број поена</th>
                        <th>Оцена</th>
                        <th></th>
                        @endif





                      </tr>
                    </thead>
                    <tbody class="table-tbody">

                      @foreach($ispitne_prijave as $ip)

                      <tr>
                        <td class="sort-sifra">
                        {{$ip->ime}}</td>
                        <td class="sort-naziv"> {{$ip->prezime}}</td>
                        <td class="sort-grupe">{{$ip->sala}}</td>
                        <td class="sort-sk">{{$ip->obaveza}}</td>
                        @if(Carbon\Carbon::now()>Carbon\Carbon::parse($vreme_kraja))
                        <form method="POST" action="{{route('zap.sacuvaj_ocenu')}}">
                          @csrf
                        <th><input type="hidden" class="form-control" id="" name="id_prijave" value="{{$ip->id_prijave}}"/>
                          <input type="number" class="form-control" id="br_poena-{{$ip->id_prijave}}" name="br_poena" value="{{$ip->broj_poena}}"/>
                          @error('br_poena')
                          <div class="alert alert-danger mt-1">{{ $message }}</div>
                      @enderror
                        </th>
                        <th><input type="number" class="form-control" id="ocena-{{$ip->id_prijave}}" name="ocena" value="{{$ip->ocena}}"/>

                          @error('ocena')
                          <div class="alert alert-danger mt-1">{{ $message }}</div>
                      @enderror</th>
                        <th><button type="submit" class="btn btn-primary">Сачувај</button></th>
                      </form>
                        @endif

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
                      Ни један студент није пријавио испит или су све оцене закључане.
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

