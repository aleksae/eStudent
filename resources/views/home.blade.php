@extends('layouts.header_side')
@section('content')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Преглед
                </div>
                <h2 class="page-title">
                  Почетна страна
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn">
                      Преглед финансија
                    </a>
                  </span>
                 
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              
             
             
              <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-6 col-lg-4">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{$stanje_racuna}} дин. на рачуну
                            </div>
                            <div class="text-muted">
                              0 уплата последњи месец
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M9 12l.01 0"></path>
                                    <path d="M13 12l2 0"></path>
                                    <path d="M9 16l.01 0"></path>
                                    <path d="M13 16l2 0"></path>
                                 </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              20 положених испита
                            </div>
                            <div class="text-muted">
                              5 неположених испита
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-sm-6 col-lg-4">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-bar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                    <path d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                    <path d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                    <path d="M4 20l14 0"></path>
                                 </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Просечна оцена: 8,86
                            </div>
                            <div class="text-muted">
                            У топ 25% студената твог смера
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Важне информације</h3>
                      
                    </div>
                    <div class="card-body" id="info">
                        <div class="alert alert-info alert-dismissible d-none" id="all_read" role="alert">
                            <div class="d-flex">
                              <div>
                                <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 8l.01 0" /><path d="M11 12l1 0l0 4l1 0" /></svg>
                              </div>
                              <div>
                                <h4 class="alert-title">Све сте прегледали</h4>
                                <div class="text-muted">Тренутно нема важних обавештења.</div>
                              </div>
                            </div>
                            
                          </div>
                          @foreach(App\Models\OrganizacionaAktivnost::tekuceAktivnosti() as $akt)
                          @php
             
                          $datum = Carbon\Carbon::parse($akt->kraj);
                          $danas = Carbon\Carbon::now();
                          $razlika = $danas->diff($datum)->days;
                          $razlika_sekunde = $danas->diffInSeconds($datum);
                          $razlika_sati = (int) ($razlika_sekunde / 3600);
                          $razlika_minuti = (int) (($razlika_sekunde - $razlika_sati*3600)/60)
                          @endphp
                        <div class="alert @if(!$razlika) alert-danger @else alert-info @endif alert-dismissible" role="alert">
                            <div class="d-flex">
                              <div>
                                
                                <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                @if(!$razlika)<svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 8l0 4" /><path d="M12 16l.01 0" /></svg>
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 8l.01 0" /><path d="M11 12l1 0l0 4l1 0" /></svg>
                             @endif
                            </div>
                              <div>
                                <h4 class="alert-title">{{$akt->naziv}}</h4>
                                <div class="text-muted">@if(!$razlika) Остало је још {{$razlika_sati}} сати и {{$razlika_minuti}} минута за активност <em>{{$akt->naziv}}</em> @else{{$akt->naziv}} је у току и траје до {{$datum->format('d.m.Y. H:i')}}@endif</div>
                              </div>
                            </div>
                            <a href="javascript:;" class="btn-close" data-bs-dismiss="alert" aria-label="close" onclick="checkEmptyDiv()"></a>
                        </div>

                        @endforeach
                    </div>
                    
                  </div>
              </div>
              <div class="">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Статистика излазака на испите</h3>
                    
                    <div id="chart-mentions" class="chart-lg"></div>
                    
                    <p class="mt-3">Комплетна статистика може се наћи на картици <em>Статистика.</em></p>
                  </div>
                </div>
              </div>
              
              
              
             
              
              
              
             
            </div>
          </div>
        </div>
        @endsection
    <script>
function checkEmptyDiv(){
    var container_div = document.getElementById('info');
var count = container_div.getElementsByTagName('div').length;
console.log(count);
    if(count==5){
        document.getElementById("all_read").classList.remove("d-none");
        document.getElementById("all_read").classList.add("d-block");
    }
}
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-mentions'), {
                chart: {
                    locales: [{
    "name": "rs",
    "options": {
      "months": [
        "Јануар",
        "Фебруар",
        "Март",
        "Април",
        "Мај",
        "Јун",
        "Јул",
        "Август",
        "Септембар",
        "Октобар",
        "Новембар",
        "Децембар"
      ],
      "shortMonths": [
        "Јан",
        "Феб",
        "Мар",
        "Апр",
        "Мај",
        "Јун",
        "Јул",
        "Авг",
        "Сеп",
        "Окт",
        "Нов",
        "Дец"
      ],
      "days": [
        "Недеља",
        "Понедељак",
        "Уторак",
        "Среда",
        "Четвртак",
        "Петак",
        "Субота"
      ],
      "shortDays": ["Нед", "Пон", "Уто", "Сре", "Чет", "Пет", "Суб"],
      "toolbar": {
        "exportToSVG": "Preuzmi SVG",
        "exportToPNG": "Preuzmi PNG",
        "exportToCSV": "Preuzmi CSV",
        "menu": "Meni",
        "selection": "Odabir",
        "selectionZoom": "Odabirno povećanje",
        "zoomIn": "Uvećajte prikaz",
        "zoomOut": "Umanjite prikaz",
        "pan": "Pomeranje",
        "reset": "Resetuj prikaz"
      }
    }
  }],
    defaultLocale: "rs",
                    type: "bar",
                    fontFamily: 'inherit',
                    height: 240,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: false
                    },
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [{
                    name: "Неположено",
                    data: [3,3,2,2,4,3,2,3,3,2,2,3,3,2]
                },
                {
                    name: "Положено",
                    data: [4,0,4,1,1,1,1,4,0,4,1,2,1,1]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    '2021-01', '2021-02',  '2021-06', '2021-07', '2021-08', '2021-09','2021-10', '2022-01','2022-02','2022-06','2022-07','2022-08','2022-09',
                ],
                colors: [tabler.getColor("red"), tabler.getColor("green", 0.8)],
                legend: {
                    show: false,
                },
            })).render();
        });
        // @formatter:on
      </script>
