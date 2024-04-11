@extends('layouts.header_side')
@section('title', 'Распоред часова')
@section('content')
      <div class="page-wrapper">
        <div class="page-header">
          <div class="container">
            
          </div>
        </div>
        <!-- Page body -->
        @php
            $termini = $termini_p = $termini_u = $termini_s = $termini_c = $termini_pe =["08:00:00","09:00:00","10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00"];
        @endphp
        <div class="page-body">
          <div class="container-xl">
            <h2>Распоред часова</h2>
            <div class="table table-responsive">
                <table class="table table-vcenter table-bordered table-nowrap card-table table-striped">
                    <thead>
                        <tr>
                          
                            <th>ПОН</th>
                            <th>УТО</th>
                            <th>СРЕ</th>
                            <th>ЧЕТ</th>
                            <th>ПЕТ</th>
                        </tr>
                    </thead>
                    <tbody>
      
                        <tr>
                            
                                @for($i=0; $i<5; $i++)
                                <td scope="col" class="col-1 align-top align-start">
                                @foreach($termini_rasp->where('dan', $i)->sortBy('vreme_pocetka') as $t)
                                
                                <div class="card w-100 mb-2">
                 
                                    <div class="ribbon bg-red">{{$t->grupa}}</div>
                                    <div class="card-body">
                                        <h3 class="card-title text-wrap me-2">{{substr($t->vreme_pocetka,0,5)}} - {{substr($t->vreme_kraja,0,5)}}
                                        <br>
                                        @if($t->parnost == 1)
                                        <span><small class="text-danger">у парним недељама</small></span>
                                        @elseif($t->parnost==0)
                                        <span><small class="text-info">у напераним недељама</small></span>
                                        @elseif($t->parnost == NULL)
                                        @endif
                                    </h3>
                                        <p class="text-secondary text-wrap me-2 mb-2 ">
                                        <span ><strong>{{$t->naziv}}</strong></span><br>
                                            @php
                                            $nastavnici_lista = $nastavnici->where('id_termina_u_rasporedu', $t->id_termina_u_rasporedu)->pluck('ime')->toArray();
                                        @endphp
                                        <span >

                                            @foreach ($nastavnici_lista as $item)
                                                {{ $item }}
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @endforeach
                                        </span>
                                        </p>
                                    </div>
                                    <div class="ribbon ribbon-bottom bg-yellow">{{$t->prostorija}}</div> <!-- Add this line for the bottom ribbon -->
                                </div>
                                @endforeach
                                </td>
                                @endfor
    
                           

           
                            
                          
                        </tr>
         
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        @endsection
        