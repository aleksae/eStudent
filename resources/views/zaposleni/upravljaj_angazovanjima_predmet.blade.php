@extends('layouts.header_side')
@section('title', 'Моја ангажовања')
@section('content')

<link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">

      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Уређивање предмета {{$predmet->naziv}} [{{$predmet->sifra}}]
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-header">
                <h2>Ангажовање наставника</h2>
              </div>
              <div class="card-body">
                <form method="POST" action="{{route('upravljanje_konkretnim_predmetom_sacuvaj', $predmet->sifra)}}">
                  @csrf

                <div class="container">
                  <h3>Предавања</h3>
                  <div class="row">
                  @foreach($grupe->where('tip', 'П') as $g)
                  <div class="col">
                    <div class="mb-3">
                      <div class="form-label">Наставници предавања - група {{$g->broj}}:</div>
                
                        <select id="predavanja{{$g->id}}" name="predavanja{{$g->id}}[]" multiple >
                          @foreach($nastavnici as $nastavnik)
                            @if($nastavnik->id_zvanja<=3)
                            <option @if($angazovani->where('tip', 'П')->where('broj', $g->broj)->where('id_nastavnika',$nastavnik->id_nastavnika)->first()) selected @endif value={{$nastavnik->id_nastavnika}}>{{$nastavnik->ime." ".$nastavnik->prezime.", ".$nastavnik->naziv_zvanja}} [{{$nastavnik->username}}]</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                      <script>
                        new SlimSelect({
                          select: '#predavanja'+'<?php echo($g->id); ?>'
                        });
                        </script>
                        </div>
                  @endforeach
                   </div>
                </div>
                <div class="container">
                  <h3>Вежбе</h3>
                  <div class="row">
                  @foreach($grupe->where('tip', 'В') as $g)
                  <div class="col-4">
                  <div class="mb-3">
                    <div class="form-label">Наставници вежбе - група {{$g->broj}}:</div>
                  
                      <select id="vezbe{{$g->id}}" name="vezbe{{$g->id}}[]" multiple >
                        @foreach($nastavnici as $nastavnik)
                          @if($nastavnik->id_zvanja<=6)
                          <option @if($angazovani->where('tip', 'В')->where('broj', $g->broj)->where('id_nastavnika',$nastavnik->id_nastavnika)->first()) selected @endif value={{$nastavnik->id_nastavnika}}>{{$nastavnik->ime." ".$nastavnik->prezime.", ".$nastavnik->naziv_zvanja}} [{{$nastavnik->username}}]</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <script>
                      new SlimSelect({
                        select: '#vezbe'+'<?php echo($g->id); ?>'
                      });
                      </script>
                       </div>
                    @endforeach
                      </div>
                    </div>
                    <div class="container">
                      <h3>ДОН</h3>
                      <div class="row">
                    @foreach($grupe->where('tip', 'Л') as $g)
                    <div class="col">
                    <div class="mb-3">
                      <div class="form-label">Наставници ДОН - група {{$g->broj}}:</div>
                    
                        <select id="don{{$g->id}}" name="don{{$g->id}}[]" multiple >
                          @foreach($nastavnici as $nastavnik)
                            <option  @if($angazovani->where('tip', 'Л')->where('broj', $g->broj)->where('id_nastavnika',$nastavnik->id_nastavnika)->first()) selected @endif value={{$nastavnik->id_nastavnika}}>{{$nastavnik->ime." ".$nastavnik->prezime.", ".$nastavnik->naziv_zvanja}} [{{$nastavnik->username}}]</option>
                          @endforeach
                        </select>
                      </div>

                      <script>
                        new SlimSelect({
                          select: '#don'+'<?php echo($g->id); ?>'
                        });
                        </script>
                        </div>
                      @endforeach
                    </div>
                  </div>
                
               
                  <input type="submit" class="btn btn-primary mt-1" value="Сачувај"/>
                
                <script>
                  new SlimSelect({
                    select: '#vezbe'
                  });
                  new SlimSelect({
                    select: '#don'
                  });
                </script>

              </div>
            </div>
          </form>
            <div class="card mt-1">
              <div class="card-header">
                <h2>Наставне групе</h2>
              </div>
              <div class="card-body">
               
                  @csrf
                  Постојеће групе:
                  <ul>
                    <li>П: @foreach($grupe->where('tip', 'П') as $gr) {{$gr->broj}} @endforeach</li>
                    <li>В: @foreach($grupe->where('tip', 'В') as $gr) {{$gr->broj}} @endforeach</li>
                    <li>Л: @foreach($grupe->where('tip', 'Л') as $gr) {{$gr->broj}} @endforeach</li>
                  </ul>
                 <div class="container">
                  <form method="POST" action="{{route('dodavanje_grupe_za_predmet_nastava', $predmet->sifra)}}">
                    @csrf
                  <div class="row">
                    <div class="mb-3 col-4">
                      <label class="form-label">Тип наставе</label>
                      <select class="form-select" name="tip">
                        <option value="П">Предавања</option>
                        <option value="В">Вежбе</option>
                        <option value="Л">ДОН</option>
                      </select>
                    </div>
                    <div class="mb-3 col-4">
                      <label class="form-label">Група</label>
                      <input type="number" class="form-control" name="broj" placeholder="Унесите целобројни број групе">
                    </div>
                    <div class="mb-3 col-4">
                      <label class="form-label">Акција</label>
                      <input type="submit" class="btn btn-primary" value="Додај">
                    </div>
                  </div>
                </form>
                 </div>
               

              </div>
            </div>
          </div>
        </div>
        @endsection
        
        <!-- Libs JS -->
        <script src="{{asset('dist/libs/list.js/dist/list.min.js?1674944402')}}" defer></script>
        <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
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

