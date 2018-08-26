@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

<div class="container">



  <div class="row justify-content-center">
    <div class="container-fluid card" style="margin-top:-45;">
      <div class="card-header card-header-primary "style="background: linear-gradient(180deg, #64a3d6, #1c5196);">
        <h3 class="card-title">Gestión de tasas de cambio.</h3>
        <p class="card-category">En esta sección es agregar una nueva tasa de cambio y ver el historico de las mismas.</p>
      </div>

      <div>
        <div class="card-body">
          <h3>Tasa de cambio actual <b>$ 1 USD ~ Bs {{$lastExchangerate->mount_per_dollar}}</b></h3>
          <br><br>
          <form method="get" action="{{ url('/exchange_rates/generate') }}" >
            <h5 class="card-title">Generar nueva tasa de cambio. (<b>sustituira a la actual</b>)</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Valor del bolivar contra el dolar expresado en Bolivares Fuertes </label>
                    <div>
                      <label>Amount $
                        <input type="number" placeholder="0.00" required name="bsf_mount_per_dollar" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$"
                      </label>
                    </div>
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

  <div class="container">
    <div class="row justify-content-center">

      <div class="card margin_card">

        <table id="pageTable" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tasa de cambio</th>
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
</div>
<script src="{{ asset('js/core/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}" type="text/javascript"></script>


<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    var myTable =
    $('#pageTable').DataTable(
      {
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
      }
    );
  });
</script>




@endsection
