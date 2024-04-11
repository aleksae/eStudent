@extends('layouts.header_side')
@section('title', 'Профил')
@section('content')
@php
    function mb_ucfirst($string, $encoding)
{
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, null, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}
@endphp



      <div class="page-wrapper">
        <div class="page-header">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="avatar avatar-lg rounded" style="background-image: url('{{ asset("images/zaposleni_".$nastavnik->id_korisnik.".jpg") }}')"></span>
              </div>
              <div class="col">
                <h1 class="fw-bold">{{$nastavnik->ime." ".$nastavnik->prezime}}</h1>
                <div class="my-2">{{$nastavnik->strucno_zvanje}}
                </div>
                <div class="list-inline list-inline-dots text-muted">
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/map -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 -3l6 3l6 -3l0 13l-6 3l-6 -3l-6 3l0 -13" /><path d="M9 4l0 13" /><path d="M15 7l0 13" /></svg>
                    
                    {{$nastavnik->naziv_zvanja}}
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/cake -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-inline icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                      <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                   </svg>
                   {{mb_ucfirst($nastavnik->naziv, 'UTF-8')}}
                    
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M3 7l9 6l9 -6" /></svg>
                    <a href="#" class="text-reset">{{$nastavnik->email}}</a>
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-inline icon-tabler-building" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M3 21l18 0"></path>
                      <path d="M9 8l1 0"></path>
                      <path d="M9 12l1 0"></path>
                      <path d="M9 16l1 0"></path>
                      <path d="M14 8l1 0"></path>
                      <path d="M14 12l1 0"></path>
                      <path d="M14 16l1 0"></path>
                      <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>
                   </svg>
                    
                  <span data-bs-toggle="tooltip" data-bs-placement="top" 
                          title="Пун назив: {{$nastavnik->pun_naziv}}, Локација: {{$nastavnik->lokacija}}, {{$nastavnik->naziv_zgrade}} - {{$nastavnik->adresa}}">{{$nastavnik->skraceni_naziv}}</span>
                          
                        </div>
                </div>
              </div>
              <div class="col-auto ms-auto">
                <div class="btn-list">
                  <a href="#" class="btn btn-icon" aria-label="Button">
                    <!-- Download SVG icon from http://tabler-icons.io/i/dots -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                  </a>
                  <a href="#" class="btn btn-icon" aria-label="Button">
                    <!-- Download SVG icon from http://tabler-icons.io/i/message -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4" /><path d="M8 9l8 0" /><path d="M8 13l6 0" /></svg>
                  </a>
                  <a href="#" class="btn btn-primary">
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    Following
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
                  @foreach($izbori_u_zvanje as $i)
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-twitter-lt"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                     </svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">{{Carbon\Carbon::parse($i->datum_izbora)->format('d.m.Y.')}}</div>
                        <h4>{{mb_strtoupper($i->naziv_zvanja, 'UTF-8')}}</h4>
                        <p class="text-muted">
                          <ul class="list">
                            <li class="list-inline-item">&bull; Катедра: <em>{{mb_ucfirst($i->naziv, 'UTF-8')}}</em></li>
                            <li class="list-inline-item">&bull; Научна област: <em>{{mb_ucfirst($i->naucna_oblast, 'UTF-8')}}</em></li>
                            <li class="list-inline-item">&bull; Стручно звање: <em>{{$i->strucno_zvanje}}</em></li>
                          </ul>
                        </p>
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

                        <div class="card-title">Тренутна ангажовања</div>
                        <ul class="list-group">
                          @foreach($angazovanja->unique('sifra') as $a)
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$a->naziv}} [{{$a->sifra}}]
                            @php
                              $predavanja=$angazovanja->where('sifra', $a->sifra)->where('tip', 'П')->pluck('broj')->toArray();
                              $vezbe = $angazovanja->where('sifra', $a->sifra)->where('tip', 'В')->pluck('broj')->toArray();
                              $don = $angazovanja->where('sifra', $a->sifra)->where('tip', 'Л')->pluck('broj')->toArray();
                            @endphp
                            @php
                            $tipovi_nastave = [];
                            if(isset($predavanja[0])) $tipovi_nastave[] = "П";
                            if(isset($vezbe[0]))  $tipovi_nastave[] = "В";
                            if(isset($don[0]))  $tipovi_nastave[] = "Л";
                            @endphp
                            <span class="badge bg-primary rounded-pill" data-bs-toggle="tooltip" data-bs-placement="top" title="Типови наставе које наставник изводи: П - предавања, В - вежбе, Л - лабораторијске вежбе">{{implode(", ", $tipovi_nastave)}}</span>
                          </li>
                          @endforeach
                        </ul>
                       
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <h2 class="card-title">About Me</h2>
                        <div>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid beatae eaque eius
                            esse fugit, hic id illo itaque modi molestias nemo perferendis quae rerum soluta. Blanditiis
                            laborum minima molestiae molestias nemo nesciunt nisi pariatur quae sapiente ut. Aut consectetur
                            doloremque, error impedit, ipsum labore laboriosam minima non omnis perspiciatis possimus
                            praesentium provident quo recusandae suscipit tempore totam.
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
        