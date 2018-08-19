@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="container-fluid">
      <table id="pageTable" class="display">
        <thead>
            <tr>
                <th>Email del Autor</th>
                <th>Tipo</th>
                <th>Monto Base</th>
                <th>Fee (Si aplica)</th>
                <th>Monto total</th>
                <th>Fecha</th>
                <th>Ver referencia </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($movements as $item)
            <tr>
                <td style="text-align:center;">
                  <a href="{{ url('users/'.$item->user->id.'?v=2') }}">
                    {{ $item->user->email }}
                  </a>
                </td>
                <td style="text-align:center;">
                  {{ $item->movement_type }}
                </td>
                <td style="text-align:center;">
                  $ {{ $item->amount }} Usd
                </td>
                <td style="text-align:center;">
                  $ {{ $item->fee }} Usd
                </td>
                <td style="text-align:center;">
                  $ {{ $item->total_amount }} Usd

                </td>
                <td style="text-align:center;">
                  {{ $item->created_at }}

                </td>
                <td style="text-align:center;">
                    @if($item->stripe_id != "")
                      <a  target="_blank" href="{{ 'https://dashboard.stripe.com/test/payments/'.$item->stripe_id }}" > Ver detalle </a>
                    @else
                      <a href="{{ url('/transactions/'.$item->transaction->id.'?v=3') }}">
                        Ver detalle
                      </a>
                    @endif
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
        "orderFixed": [ 5, 'desc' ]
      });
  });
</script>




@endsection
