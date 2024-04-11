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
                  Уређивање обавеза за предмет {{$predmet->naziv}} [{{$predmet->sifra}}]
                </h2>
                
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                   
                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Додавање обавезве
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Додавање обавезе">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  </a>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="container">
              <div class="row">
                <div class="col-md-6 order-2">
            <div class="card ">
              <div class="card-header">
                <h2>Преглед постојећих обавеза</h2>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list">
                     
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                      <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                      Додавање обавезве
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Додавање обавезе">
                      <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                
                    <div id="table-default" class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Обавеза</th>
                            <th>Група</th>
                            <th>Број поена</th>
                            <th>Бр. прилика</th>

                            <th>Испит</th>
                            <th>Акције</th>
                          </tr>
                        </thead>
                        <tbody class="table-tbody">
                          @foreach($obaveze as $obaveza)
                          <tr>
                          <td>{{$obaveza->naziv}}</td>
                          <td>{{$obaveza->tip}}{{$obaveza->broj}}</td>
                          <td>{{$obaveza->maks_broj_poena}} [{{$obaveza->procenat_u_ukupnoj_oceni}}%]</td>
    
                          <td>
                            @php
                                switch($obaveza->broj_prilika_za_polaganje){
                                  case -1:
                                    echo("У свим роковима које прописује факултет");
                                    break;
                                  case -2:
                                    echo("Организација независно од факултетских рокова");
                                    break;
                                  case -3:
                                    echo("У свим роковима осим у јануарском року");
                                    break;
                                  case -4:
                                    echo("У свим роковима  осим у јунском року");
                                    break;
                                  default:
                                    echo($obaveza->broj_prilika_za_polaganje);
                                    break;
                                }
                            @endphp</td>

                          <td>@if($obaveza->jeste_ispit==0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M18 6l-12 12"></path>
                              <path d="M6 6l12 12"></path>
                           </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checks text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M7 12l5 5l10 -10"></path>
                              <path d="M2 12l5 5m5 -5l5 -5"></path>
                           </svg>
                            @endif @if($obaveza->ima_drugi_deo) - има други део @endif</td>
                          <td><div class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                              Радње
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="" >
                              <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal{{$obaveza->id}}">
                                Уреди
                              </a>
                              <a class="dropdown-item" href="{{route('predmetne_aktivnosti_delete', $obaveza->id)}}">
                                Обриши
                              </a>
                            </div>
                          </div></td>
                          </tr>

                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  
              </div>
            </div>
          </div>
          <!--<div class="col-md-6 order-1">
            <div class="card">
              <div class="card-header">
                <h2>Преглед спискова</h2>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list">
                     
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-spisak">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                      Додавање списка
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-spisak" aria-label="Додавање списка">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                
                    <div id="table-default" class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Назив</th>
                            <th>Обавеза</th>
                            <th>Датум и време</th>
                            <th>Детаљи</th>
                            <th>Акције</th>
                          </tr>
                        </thead>
                        <tbody class="table-tbody">
                          @foreach($obaveze as $obaveza)
                          <tr>
                          <td>{{$obaveza->naziv}}</td>
                          <td>{{$obaveza->tip}}{{$obaveza->broj}}</td>
                          <td>{{$obaveza->maks_broj_poena}}</td>
                          <td>{{$obaveza->procenat_u_ukupnoj_oceni}}%</td>
                          
                          <td><div class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                              Радње
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="" >
                              <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal{{$obaveza->id}}">
                                Уреди
                              </a>
                              <a class="dropdown-item" href="{{route('predmetne_aktivnosti_delete', $obaveza->id)}}">
                                Обриши
                              </a>
                            </div>
                          </div></td>
                          </tr>

                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  
              </div>
            </div>
          </div>-->
          </div>
        </div>
          
          </div>
        </div>
        @endsection
        @foreach($obaveze as $obaveza)
        <div class="modal modal-blur fade" id="modal{{$obaveza->id}}" tabindex="-1" role="dialog" aria-hidden="true" style="visibility: hidden">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Уређивање обавезе {{$obaveza->naziv}} за групу П{{$obaveza->broj}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
  
              <div class="modal-body">
                <form method="POST" name="prijava" action="{{route('predmetne_aktivnosti_update', $obaveza->id)}}">
                  @csrf
                  <div class="mb-3">
                    <label for="exampleDataList" class="form-label">Обавеза</label>
                    <input class="form-control" list="naziv" name="naziv" id="exampleDataList" value="{{$obaveza->naziv}}" placeholder="Унесите да претражите или самостално унесете">
                    <datalist id="naziv" name="naziv">
                      <option value="Колоквијум">
                      <option value="Испит">
                      <option value="Лабораторијска вежба">
                      <option value="Практичан тест">
                    </datalist>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="mb-3 col">
                        <div class="form-label">Групе</div>
                        <div>
                         
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="grupe[]" value="{{($grupe->where('broj', $obaveza->broj)->where('tip', 'П')->first())->id}}" checked>
                            <span class="form-check-label">П{{$obaveza->broj}}</span>
                          </label>

                        </div>
                      </div>
                      <div class="mb-3 col">
                        <div class="form-label">Испитна обавеза</div>
                        <div>
                        
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="ispitna" value="1" @if($obaveza->jeste_ispit) checked @endif>
                            <span class="form-check-label">Да</span>
                          </label>
                        </div>
                      </div>
                      <div class="mb-3 col">
                        <div class="form-label">Други део испита</div>
                        <div>
                        
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="drugi_deo" value="1" @if($obaveza->ima_drugi_deo) checked @endif>
                            <span class="form-check-label">Да</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col mb-3 form-check-inline">
                        <div class="form-label">Максималан број поена на обавези</div>
                        <input  type="text" class="form-control" name="maks_br_poena" value="{{$obaveza->maks_broj_poena}}">
                      </div>
                      <div class="col mb-3">
                        <div class="form-label ">Проценат обавезе у укупној обавези</div>
                        <input  type="text" class="form-control" name="procenat" value="{{$obaveza->procenat_u_ukupnoj_oceni}}">
                      </div>
                    
                      <div class="mb-3  col">
                        <div class="form-label">Број прилика за полагање обавезе</div>
                        <select class="form-select" name="br_prilika">
                          <option value="-1" @if($obaveza->broj_prilika_za_polaganje==-1) selected @endif>У сваком року у ком је могуће полагање</option>
                          <option value="-2" @if($obaveza->broj_prilika_za_polaganje==-2) selected @endif>Биће дефинисано накнадно, ван факултетских рокова</option>
                          <option value="-3" @if($obaveza->broj_prilika_za_polaganje==-3) selected @endif>У свим роковима осим у јануарском испитном року</option>
                          <option value="-4" @if($obaveza->broj_prilika_za_polaganje==-4) selected @endif>У свим роковима осим у јунском испитном року</option>
                          <option value="1" @if($obaveza->broj_prilika_za_polaganje==1) selected @endif>Једна</option>
                          <option value="2" @if($obaveza->broj_prilika_za_polaganje==2) selected @endif>Две</option>
                          <option value="3" @if($obaveza->broj_prilika_za_polaganje==3) selected @endif>Три</option>
                          <option value="4" @if($obaveza->broj_prilika_za_polaganje==4) selected @endif>Четири</option>
                          <option value="5" @if($obaveza->broj_prilika_za_polaganje==5) selected @endif>Пет</option>
                          <option value="6" @if($obaveza->broj_prilika_za_polaganje==6) selected @endif>Шест</option>
                          <option value="7" @if($obaveza->broj_prilika_za_polaganje==7) selected @endif>Седам</option>
                          <option value="8" @if($obaveza->broj_prilika_za_polaganje==8) selected @endif>Осам</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 mb-0">
                    <label class="form-label">Опис</label>
                    <textarea rows="5" class="form-control" id="opis" name="opis">{{$obaveza->opis_pravila}}</textarea>
                  </div>
                 

                  
                 

  
              </div>
  
              <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Откажи
                </a>
                <button type="submit" href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  Сачувај
                </button>
              </form>
              </div>
            </div>
          </div>
      </div>
        @endforeach
        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" style="visibility: hidden">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Додавање обавезе</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
  
              <div class="modal-body">
                <form method="POST" name="prijava" action="{{route('predmetne_aktivnosti_store', $predmet->sifra)}}">
                  @csrf
                  <div class="mb-3">
                    <label for="exampleDataList" class="form-label">Обавеза</label>
                    <input class="form-control" list="naziv" name="naziv" id="exampleDataList" placeholder="Унесите да претражите или самостално унесете">
                    <datalist id="naziv" name="naziv">
                      <option value="Колоквијум">
                      <option value="Испит">
                      <option value="Лабораторијска вежба">
                      <option value="Практичан тест">
                    </datalist>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="mb-3 col">
                        <div class="form-label">Групе</div>
                        <div>
                          @foreach($grupe->where('tip', 'П')->unique('broj') as $gr)
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="grupe[]" value="{{$gr->id}}">
                            <span class="form-check-label">{{$gr->broj}}</span>
                          </label>
                          @endforeach
                        </div>
                      </div>
                      <div class="mb-3 col">
                        <div class="form-label">Испитна обавеза</div>
                        <div>
                        
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="ispitna" value="1">
                            <span class="form-check-label">Да</span>
                          </label>
                        </div>
                      </div>
                      <div class="mb-3 col">
                        <div class="form-label">Други део испита</div>
                        <div>
                        
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="drugi_deo" value="1">
                            <span class="form-check-label">Да</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col mb-3 form-check-inline">
                        <div class="form-label">Максималан број поена на обавези</div>
                        <input  type="text" class="form-control" name="maks_br_poena">
                      </div>
                      <div class="col mb-3">
                        <div class="form-label ">Проценат обавезе у укупној обавези</div>
                        <input  type="text" class="form-control" name="procenat">
                      </div>
                    
                      <div class="mb-3  col">
                        <div class="form-label">Број прилика за полагање обавезе</div>
                        <select class="form-select" name="br_prilika">
                          <option value="-1">У сваком року у ком је могуће полагање</option>
                          <option value="-2">Биће дефинисано накнадно, ван факултетских рокова</option>
                          <option value="-3">У свим роковима осим у јануарском испитном року</option>
                          <option value="-4">У свим роковима осим у јунском испитном року</option>
                          <option value="1">Једна</option>
                          <option value="2">Две</option>
                          <option value="3">Три</option>
                          <option value="4">Четири</option>
                          <option value="5">Пет</option>
                          <option value="6">Шест</option>
                          <option value="7">Седам</option>
                          <option value="8">Осам</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 mb-0">
                    <label class="form-label">Опис</label>
                    <textarea rows="5" class="form-control" placeholder="Here can be your description" name="opis"></textarea>
                  </div>
                 

                  
                 

  
              </div>
  
              <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Откажи
                </a>
                <button type="submit" href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  Пријава
                </button>
              </form>
              </div>
            </div>
          </div>
      </div>

      <div class="modal modal-blur fade" id="modal-spisak" tabindex="-1" role="dialog" aria-hidden="true" style="visibility: hidden">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Додавање списка</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="POST" name="prijava" action="{{route('predmetne_aktivnosti_store', $predmet->sifra)}}">
                @csrf
                <div class="mb-3">
                  <label for="exampleDataList" class="form-label">Назив списка</label>
                  <input class="form-control" list="naziv" name="naziv" id="exampleDataList" placeholder="Унесите да претражите или самостално унесете">
                  <datalist id="naziv" name="naziv">
                    <option value="Колоквијум">
                    <option value="Испит">
                    <option value="Лабораторијска вежба">
                    <option value="Практичан тест">
                  </datalist>
                </div>
                <div class="container">
                  <div class="row">
                    <div class="mb-4 col">
                      <div class="form-label">Групе</div>
                      <div>
                        @foreach($grupe as $gr)
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="grupe[]" value="{{$gr->id}}">
                          <span class="form-check-label">{{$gr->tip}}{{$gr->broj}}</span>
                        </label>
                        @endforeach
                      </div>
                    </div>
                    <div class="mb-4 col">
                      <div class="form-label">Пријава студента за опције излазим/не излазим</div>
                      <div>
                      
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="izlaz" value="1">
                          <span class="form-check-label">Да</span>
                        </label>
                      </div>
                    </div>
                    <div class="mb-4 col">
                      <div class="form-label">Пријава студента за термине</div>
                      <div>
                      
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="termini" value="1">
                          <span class="form-check-label">Да</span>
                        </label>
                      </div>
                    </div>
                    <div class="mb-4 col">
                      <div class="form-label">Пријава студента за сале</div>
                      <div>
                      
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="sale" value="1">
                          <span class="form-check-label">Да</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="mb-3 mb-0">
                  <label class="form-label">Опис</label>
                  <textarea rows="5" class="form-control" placeholder="Пример: " name="opis"></textarea>
                </div>
               

                
               


            </div>

            <div class="modal-footer">
              <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                Откажи
              </a>
              <button type="submit" href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Пријава
              </button>
            </form>
            </div>
          </div>
        </div>
    </div>
        
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

