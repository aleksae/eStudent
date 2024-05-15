@extends('layouts.header_side')
@section('title', 'Дежурство')
@section('content')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Дежурство на испиту из предмета {{$ispit->sifra_predmeta}} ({{$ispit->predmet_naziv}}) у року {{$ispit->rok}} 
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div id="main-container">
            <div id="table-container">
                <h3>Присутни студенти</h3>
                    <div class="card">
                        <div class="card-body">
                        @if(count($ispitne_prijave))
                        <div id="table-default" class="table-responsive">
            
                            <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th><button class="table-sort">Име</button></th>
                                <th><button class="table-sort">Презиме</button></th>
                                <th><button class="table-sort">Број индекса</button></th>
                            </tr>
                            </thead>
                        <tbody class="table-tbody">
                        
                        @foreach($ispitne_prijave as $prijava)
                        @if($prijava->prisutan=="I") 
                        <tr>
                            <td>{{$prijava->ime}}</td>
                            <td>{{$prijava->prezime}}</td>
                            <td>{{$prijava->indeks}}</td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                  </table>
            </div>
            @endif
            </div>
            </div>
            </div>
       
            <div id="scanner-container">
                <button class="btn btn-pill btn-outline-dark" onclick="startScanner()">Скенирај QR код</button>
                <p id="result"></p>
                <div id="reader"></div>
                <a class="btn btn-pill btn-outline-dark" href="{{ route('zap.dezurstva')}}" onclick="zavrsiDezurstvo({{$dezurstvo}})">Заврши дежурство</a>
                <p id="result"></p>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/html5-qrcode"></script>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var ispitnePrijave = @json($ispitne_prijave);
        console.log(ispitnePrijave);  // Check what this outputs in the browser console
    </script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            //document.getElementById('result').textContent ="scanned";
            var num = parseInt(decodedText);
            var nadjen = false;
            for (const prijava of ispitnePrijave) {
                if (prijava.id_prijave==num){
                    nadjen=true;
                    break;
                }
            }
            if (nadjen==false) {
                document.getElementById('result').textContent ="Погрешан QR код."
            }
            else{
                document.getElementById('result').textContent="Успешно очитан QR код."
            
                fetch(`/api/azuriraj_prisustvo/${num}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                    },
                    body: JSON.stringify({
                        valueToUpdate: 'I' // the new value for the column
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    if (data.success) {

                        const tbody = document.querySelector('.table-tbody');
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${data.student.ime}</td>
                            <td>${data.student.prezime}</td>
                            <td>${data.student.indeks}</td>
                        `;
                        tbody.appendChild(tr);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
           // html5QrCode.stop();
        }

        var html5QrCode = new Html5Qrcode("reader");
        function startScanner() {
            html5QrCode.start(
              { facingMode: "environment" },
              { fps: 10, qrbox: 250 },
              onScanSuccess
            );
        }
        function zavrsiDezurstvo(dezurstvo_id) {
            fetch(`/api/azuriraj_dezurstvo/${dezurstvo_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                    },
                    body: JSON.stringify({
                        valueToUpdate: 'z' 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #main-container {
            display: flex;
            height: 100vh; /* Full height of the viewport */
        }
        #table-container {
            width: 66.67%; /* Approximately two-thirds of the page */
            
            padding: 25px; /* Padding around the content */
        }
        #scanner-container {
            width: 33.33%; /* Remaining third */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center-align the items horizontally */
            padding: 25px;
        }
        #reader {
            width: 100%; /* Full width of the scanner container */
            height: 300px; /* Fixed height */
            margin-bottom: 20px; /* Space below the camera frame */
        }
        button {
            padding: 10px 20px;
            margin-bottom: 10px; /* Space between buttons */
            cursor: pointer;
            width: 100%; /* Full width of the scanner container */
        }
    </style>
@endsection