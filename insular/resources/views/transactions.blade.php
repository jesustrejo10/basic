@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

  <div class="row justify-content-center">
    <div class="container-fluid">
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
                  <a href="./transactions/{{$item->id}}"> ver detalle </a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
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
