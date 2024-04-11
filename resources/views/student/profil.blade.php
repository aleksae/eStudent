@extends('layouts.header_side')
@section('title', 'Профил')
@section('content')
      <div class="page-wrapper">
        <div class="page-header">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="avatar avatar-lg rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
              </div>
              @php
              $upis = $upisi->first();
              @endphp
              <div class="col">
                <h1 class="fw-bold">{{Auth::user()->ime." ".Auth::user()->prezime}}</h1>
                <div class="my-2">Студент
                </div>
                <div class="list-inline list-inline-dots text-muted">
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/map -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 -3l6 3l6 -3l0 13l-6 3l-6 -3l-6 3l0 -13" /><path d="M9 4l0 13" /><path d="M15 7l0 13" /></svg>
                    {{$upis->program}}, {{$upis->statut}}
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M3 7l9 6l9 -6" /></svg>
                    <a href="#" class="text-reset">{{Auth::user()->email}}</a>
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/cake -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 20h18v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8z" /><path d="M3 14.803c.312 .135 .654 .204 1 .197a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1c.35 .007 .692 -.062 1 -.197" /><path d="M12 4l1.465 1.638a2 2 0 1 1 -3.015 .099l1.55 -1.737z" /></svg>
                    {{Carbon\Carbon::parse($student->datum_rodjenja)->format('d.m.Y')."."}}
                  </div>
                </div>
              </div>
              <div class="col-auto ms-auto">
                <div class="btn-list">
                  <!--<a href="#" class="btn btn-icon" aria-label="Button">
                   
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                  </a>
                  <a href="#" class="btn btn-icon" aria-label="Button">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4" /><path d="M8 9l8 0" /><path d="M8 13l6 0" /></svg>
                  </a>-->
                  <a href="#" class="btn btn-success">
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    Активан студент
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row g-3">
              <div class="col">
                <ul class="timeline">
                  
                 @foreach($upisi as $upis)
                    <li class="timeline-event">
                      <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/check -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                      </div>
                      <div class="card timeline-event-card">
                        <div class="card-body">
                          <div class="text-muted float-end">{{$upis->sk}}</div>
                          <h4>@if(isset($upis->natprogram)) {{$upis->natprogram}}, @endif {{$upis->program}}, {{$upis->statut}} - @php
                            switch ($upis->godina) {
                                  case 1:
                                      echo "прва";
                                      break;
                                  case 2:
                                      echo "друга";
                                      break;
                                  case 3:
                                      echo "трећа";
                                      break;
                                  case 4:
                                      echo "четврта";
                                      break;
                              }
                            @endphp година</h4>
                          <p class="text-muted">Студент је уписан у статусу @if($upis->status=="budzet") финансирања из буџета @else самофинансирања @endif. Положено је {{($polozeno_espb->where('id_upis', $upis->id)->first())? ($polozeno_espb->where('id_upis', $upis->id)->first())->espb : 0}} ЕСПБ.</p>
                        </div>
                      </div>
                    </li>
                  @endforeach
                 
                 
             
                 
                </ul>
              </div>
              <div class="col-lg-4">
                <div class="row row-cards">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">

                        <div class="card-title">Основне информаије</div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                <path d="M9 7l6 0"></path>
                                <path d="M9 11l6 0"></path>
                                <path d="M9 15l4 0"></path>
                            </svg>
                            Име и презиме: <strong>{{Auth::user()->ime." ".Auth::user()->prezime}}</strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                <path d="M9 7l6 0"></path>
                                <path d="M9 11l6 0"></path>
                                <path d="M9 15l4 0"></path>
                            </svg>
                            Број индекса: <strong>{{substr($student->indeks, 0, 4)."/".substr($student->indeks, 4, 8)}}</strong>
                        </div>
                        
                        
                        <div class="mb-2">
                          <!-- Download SVG icon from http://tabler-icons.io/i/book -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                          Тренутни програм:<strong>@if(isset($upis->natprogram)) {{$upis->natprogram}}, @endif {{$upis->program}}, {{$upis->statut}}</strong>
                        </div>
                        <div class="mb-2">
                          <!-- Download SVG icon from http://tabler-icons.io/i/briefcase -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                          Година студија: <strong>@php
                          switch ($upis->godina) {
                                case 1:
                                    echo "прва";
                                    break;
                                case 2:
                                    echo "друга";
                                    break;
                                case 3:
                                    echo "трећа";
                                    break;
                                case 4:
                                    echo "четврта";
                                    break;
                            }
                          @endphp</strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg>
                            Име једног родитеља: <strong>{{$student->ime_roditelja}}</strong>
                        </div>
                        <div class="mb-2">
                          <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                          @if($student->pol=='M')<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-male text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 14m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"></path>
                            <path d="M19 5l-5.4 5.4"></path>
                            <path d="M19 5h-5"></path>
                            <path d="M19 5v5"></path>
                         </svg>
                         @else
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-female text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"></path>
                            <path d="M12 14v7"></path>
                            <path d="M9 18h6"></path>
                         </svg>
                         @endif
                         Пол: <strong>{{$student->pol == 'M' ? "мушки" : "женски"}}</strong>
                        </div>
                        <div class="mb-2">
                            <!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M11 15l1 0" /><path d="M12 15l0 3" /></svg>
                            Датум рођења: <strong>{{Carbon\Carbon::parse($student->datum_rodjenja)->format('d.m.Y')."."}}</strong>
                        </div>
                        <div class="mb-2">
                            <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-atom text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12v.01"></path>
                                <path d="M19.071 4.929c-1.562 -1.562 -6 .337 -9.9 4.243c-3.905 3.905 -5.804 8.337 -4.242 9.9c1.562 1.561 6 -.338 9.9 -4.244c3.905 -3.905 5.804 -8.337 4.242 -9.9"></path>
                                <path d="M4.929 4.929c-1.562 1.562 .337 6 4.243 9.9c3.905 3.905 8.337 5.804 9.9 4.242c1.561 -1.562 -.338 -6 -4.244 -9.9c-3.905 -3.905 -8.337 -5.804 -9.9 -4.242"></path>
                             </svg>
                            ЈМБГ: <strong>{{$student->jmbg}}</strong>
                          </div>
                          <div class="mb-2">
                            <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-backpack me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 18v-6a6 6 0 0 1 6 -6h2a6 6 0 0 1 6 6v6a3 3 0 0 1 -3 3h-8a3 3 0 0 1 -3 -3z"></path>
                                <path d="M10 6v-1a2 2 0 1 1 4 0v1"></path>
                                <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                                <path d="M11 10h2"></path>
                             </svg>
                            ЈОБ: <strong>{{$student->job}}</strong>
                          </div>
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                         </svg>
                          Телефон: <strong>{{$student->telefon != "" ? "+381 ".$student->telefon : "/"}}</strong>
                        </div>
                        
                        
                       
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <h2 class="card-title">Празан простор</h2>
                        <div>
                          <p>Допунити нечим....
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endsection
        