@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

<div class="container">

  <div class="content" style="margin-top: -45px;">
         <div class="container-fluid">
           <div class="row">
             <div class="col-md-12">
               <div class="card">
                 <div class="card-header card-header-primary">
                   <h4 class="card-title">Generar nueva tasa de cambio</h4>
                   <p class="card-category">En esta seccion es posible crear una nueva tasa de cambio. La nueva tasa sustituira a las existentes.</p>
                 </div>
                 <div class="card-body">



                   <form method="get" action="{{ url('transactions/generate/') }}" enctype="form-data">

                     <h5 class="card-title">Generar tasa de cambio.</h4>

                     <div class="row">

                       <div class="col-md-6">
                         <div class="form-group">
                           <label class="bmd-label-floating">Valor del bolivar contra el dolar expresado en Bolivares Fuertes </label>
                           <input type="number" name="message" class="form-control" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57"required>
                         </div>
                       </div>
                       <div class = "col-md-6">
                         <div class="form-group">
                           <button type="submit" class="btn btn-success pull-center" style="width: 100%;">Generar tasa de cambio</button>
                          </div>
                       </div>
                     </div>
                   </form>

                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>

  <div class="row justify-content-center">
    <div class="container-fluid" >
      <table id="pageTable" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Valor de dolar contra Bolivar</th>
                <th>Fecha de creación</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($exchangeRates as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->bsf_mount_per_dollar }} Bsf por Dolar
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="{{ asset('js/core/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}" type="text/javascript"></script>


<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    var myTable =
    $('#pageTable').DataTable();
  });
</script>




@endsection
