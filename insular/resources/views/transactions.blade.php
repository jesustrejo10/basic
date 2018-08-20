@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

  <div class="row justify-content-center">
    <div class="container-fluid card" style="margin-top:-45; margin-left: 20; margin-right: 20; margin-bottom: 20;">
      <div class="card-header card-header-primary "style="background: linear-gradient(180deg, #64a3d6, #1c5196);">
        <h3 class="card-title">Gestión de transacciones del sistema.</h3>
        <p class="card-category">En esta sección es posible ver cada uno de las transacciones del sistema. <br> Además con la opción ver detalle, puede conocer más información de la misma.</p>
      </div>
      <div class="margin_card">
        <table id="pageTable" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre del Emisor</th>
                <th>Nombre del Receptor</th>
                <th>Monto Usd</th>
                <th>Monto Bsf</th>
                <th>Tasa de Cambio</th>
                <th>Status</th>
                <th>Fecha de Transaccion</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($transactions as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{$item->transaction_owner_name }}
                </td>
                <td>
                    {{  $item->natural_person->legal_name }}
                </td>
                <td>
                    {{  $item->amount_usd }} Usd
                </td>
                <td>
                  {{  $item->total_bsf_amount }} Bsf

                </td>
                <td>
                  {{  $item->exchange_rate_value }} Bsf por Usd
                </td>
                <td>
                  @if($item->history->transaction_status_id =='1')
                    Solicitada
                  @elseif( $item->history->transaction_status_id =='2')
                    Procesada
                  @else
                    Negada
                  @endif
                </td>
                <td>
                  {{  $item->created_at }}
                </td>
                <td>
                  <a href="{{url('transactions/'.$item->id.'?v=3')}}"> ver detalle </a>
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
    $('#pageTable').DataTable({
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
});
  });
</script>




@endsection
