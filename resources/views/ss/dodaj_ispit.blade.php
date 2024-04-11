@extends('layouts.header_side')
@section('title', 'Рокови')
@section('content')
<style>
    table.table-fit {
    width: auto !important;
    table-layout: auto !important;
}
table.table-fit thead th, table.table-fit tfoot th {
    width: auto !important;
}
table.table-fit tbody td, table.table-fit tfoot td {
    width: auto !important;
}
table.table-fit td{

  font-size: 0.8rem;

}
</style>
      <div class="page-wrapper" onload="wrapper()">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Рокови
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
               


                Додавање испита у <strong>{{$rok->naziv}}</strong>
               
                </div>
            </div>
          </div>
        </div>
        @endsection

         <!-- Libs JS -->
    <script src="{{asset('dist/libs/list.js/dist/list.min.js?1674944402')}}" defer></script>
   
    <script>
      function wrapper(){
        const list = new List('table-default', {
      	sortClass: 'table-sort',
      	listClass: 'table-tbody',
      	valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
      		
      		'sort-espb', 'sort-sk',  'sort-grupe'
        ]
      });
      
      let boxes = document.querySelectorAll('.rokovi-moji');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            boxes = document.querySelectorAll('.rokovi-svi');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
      }
      
        
      document.addEventListener("DOMContentLoaded", function() {
      const list = new List('table-default', {
      	sortClass: 'table-sort',
      	listClass: 'table-tbody',
      	valueNames: [ 'sort-sifra', 'sort-naziv', 'sort-semestar', 'sort-status',
      		
      		'sort-espb', 'sort-sk',  'sort-grupe'
        ]
      });
      
      let boxes = document.querySelectorAll('.rokovi-moji');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
            boxes = document.querySelectorAll('.rokovi-svi');

            boxes.forEach(box => {
            box.classList.add('d-none');
            });
      });
      
    </script>

