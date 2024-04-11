@extends('layouts.header_side')
@section('title', 'Бирање предмета')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="page-wrapper">
  <!-- Page header -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Бирање предмета
          </h2>
        </div>
        <!-- Page title actions -->
        <!--<div class="col-auto ms-auto d-print-none">
          <div class="d-flex">
            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
              <li class="breadcrumb-item"><a href="#">Tabler</a></li>
              <li class="breadcrumb-item"><a href="#">Pages</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="#">Frequently Asked Questions</a></li>
            </ol>
          </div>
        </div>-->
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="card card-lg">
        <form method="POST" action="{{route('prijavi_predmete')}}">
          @csrf
        <div class="card-body">
          <div class="space-y-4">
            @if($errors->has("check")) 
            &emsp; <div class="alert alert-important alert-danger alert-dismissible ms-3 me-3" role="alert" style="margin-top: -2.5%;">
              <div class="d-flex">
                <div>
                  <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 8l0 4" /><path d="M12 16l.01 0" /></svg>
                </div>
                <div>
                  {{$errors->first("check")}}
                  @if(isset($error_details))
                    @php print_r($error_details); @endphp
                  @endif
                </div>
              </div>
              
            </div>
            @endif
            
            @foreach($semestri as $semestar)
            <h1>Избор предмета за {{$semestar}}. семестар</h1>
            <div>
              
              <!--pocetak obavezni-->
              <div id="faq-{{$semestar}}1" class="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-item">
                  <div class="accordion-header" role="tab">
                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-{{$semestar}}1-1" onclick="return false;">Обавезни предмети</button>
                  </div>
                  <div id="faq-{{$semestar}}1-1" class="accordion-collapse collapse show" role="tabpanel" data-bs-parent="#faq-{{$semestar}}1">
                    <div class="accordion-body pt-0">
                      <div>
                      
                        @foreach($predmeti_bez_grupe as $predmet)
                          @if($predmet->semestar == $semestar)
                          <label class="form-check">
                            @if(!$polozeni->pluck('sifra_predmet')->contains($predmet->sifra))
                            <input class="form-check-input" type="checkbox" name="obavezni{{$predmet->semestar}}[]" value="{{$predmet->id_drzanje}}" 
                            @if(is_array(old('obavezni'.$predmet->semestar)) && in_array($predmet->id_drzanje, old('obavezni'.$predmet->semestar))) checked @endif
                            @if($predmet->id_slusanje) checked @endif @if($polozeni->pluck('sifra_predmet')->contains($predmet->sifra)) onclick="return false" @endif>
                            @endif
                            <span class="form-check-label">{{$predmet->naziv}} [{{$predmet->sifra}}], {{$predmet->espb}} ЕСПБ - мин: {{$predmet->min_studenata}}, пријављено: @if($brojevi->where('sifra_predmeta', $predmet->sifra)->first()){{($brojevi->where('sifra_predmeta', $predmet->sifra)->first())->cnt}}@else 0 @endif</span>
                            @if($polozeni->pluck('sifra_predmet')->contains($predmet->sifra))
                            <div class="alert alert-warning  w-50" role="alert">
                              Предмет је положен.
                            </div>
                            @endif
                          </label>
                          @endif
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>               
              </div>
              <!--kraj obavezni-->

               <!--pocetak izborni-->
               
               @foreach($grupe_nezavisne as $grupa)
                @if($grupa->semestar_grupe==$semestar)
                  <div id="grupa-{{$semestar}}{{$grupa->id}}" class="accordion mt-2" role="tablist" aria-multiselectable="true">
                    <div class="accordion-item">
                      <div class="accordion-header" role="tab">
                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#grupa-{{$semestar}}{{$grupa->id}}-1" onclick="return false;">{{$grupa->grupa}}</button>
                      </div>
                      <div id="grupa-{{$semestar}}{{$grupa->id}}-1" class="accordion-collapse collapse show" role="tabpanel" data-bs-parent="#grupa-{{$semestar}}{{$grupa->id}}">
                        <div class="alert alert-info ms-3 me-3" role="alert">
                          <h4 class="alert-title">{{$grupa->poruka}}</h4>
                        </div>
                        <div class="accordion-body pt-0">
                          <div>
                            @foreach($predmeti_sa_nezavisnom_grupom as $predmet)
                              @if($predmet->semestar == $semestar && $predmet->id_grupe == $grupa->id)
                              <label class="form-check">
                                @if(!$polozeni->pluck('sifra_predmet')->contains($predmet->sifra))
                                
                                <input class="form-check-input" type="checkbox" name="{{$semestar}}|{{$grupa->id}}[]" value="{{$predmet->id_drzanje}}"  
                                @if(is_array(old($semestar."|".$grupa->id)) && in_array($predmet->id_drzanje, old($semestar."|".$grupa->id))) checked @endif
                                @if($predmet->id_slusanje) checked @endif >
                                @endif
                                <span class="form-check-label">{{$predmet->naziv}} [{{$predmet->sifra}}], {{$predmet->espb}} ЕСПБ - мин: {{$predmet->min_studenata}}, пријављено: @if($brojevi->where('sifra_predmeta', $predmet->sifra)->first()){{($brojevi->where('sifra_predmeta', $predmet->sifra)->first())->cnt}}@else 0 @endif</span>
                                @if($polozeni->pluck('sifra_predmet')->contains($predmet->sifra))
                            <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                              Предмет је положен.
                            </div>
                            @endif
                              </label>
                              @endif
                            @endforeach
                            @foreach($grupe_zavisne as $gr)
                              @if($gr->natgrupa == $grupa->id)
                                &emsp; Подгрупа: <strong>{{$gr->naziv}}</strong>
                                
                                &emsp; <div class="alert alert-info ms-3 me-3" role="alert">
                                  <h4 class="alert-title">{{$gr->poruka}}</h4>
                                </div>
                                
                               
                                  @foreach($predmeti_sa_zavisnom_grupom as $predmet)
                                    @if($predmet->semestar == $semestar && $predmet->id_grupe == $gr->id)
                                      <label class="form-check">
                                        @if(!$polozeni->pluck('sifra_predmet')->contains($predmet->sifra))
                                        <input class="form-check-input" type="checkbox" name="{{$semestar}}|{{$grupa->id}}|{{$gr->id}}[]" value="{{$predmet->id_drzanje}}"  
                                        @if(is_array(old($semestar."|".$grupa->id."|".$gr->id)) && in_array($predmet->id_drzanje, old($semestar."|".$grupa->id."|".$gr->id))) checked @endif
                                        @if($predmet->id_slusanje) checked @endif  >
                                        
                                        @endif
                                        <span class="form-check-label">{{$predmet->naziv}} [{{$predmet->sifra}}], {{$predmet->espb}} ЕСПБ - мин: {{$predmet->min_studenata}}, пријављено: @if($brojevi->where('sifra_predmeta', $predmet->sifra)->first()) {{($brojevi->where('sifra_predmeta', $predmet->sifra)->first())->cnt}} @else 0 @endif</span>
                                        @if($polozeni->pluck('sifra_predmet')->contains($predmet->sifra))
                            <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                              Предмет је положен.
                            </div>
                            @endif
                                      </label>
                                    @endif
                                  @endforeach
                                  
                                
                              @endif
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>               
                  </div>
              @endif
              @endforeach
                
              <!--kraj izborni-->

              
            </div>
            @endforeach
           
          </div>
          <button type="submit" class="btn btn-primary" >Пријави</button>
        </div>
      </form>
      </div>
    </div>
  </div>

  @endsection

