@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="container-fluid card" style="margin-top:-45;">
      <div class="card-header card-header-primary "style="background: linear-gradient(180deg, #64a3d6, #1c5196);">
        <h3 class="card-title">Gestión de usuarios del sistema.</h3>
        <p class="card-category">En esta seccion es posible ver cada uno de los usuarios del sistema. <br> Además con la opción ver detalle, puede conocer más información del mismo.</p>
      </div>
      <div class="margin_card">
        <table id="pageTable" class="display ">
          <thead>
              <tr>
                  <th>Id</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Acciones</th>
              </tr>
          </thead>

          <tbody>
              @foreach ($userList as $item)
              <tr>
                  <td>
                      {{ $item->id }}
                  </td>
                  <td>
                      {{ $item->first_name }}
                  </td>
                  <td>
                      {{ $item->last_name }}
                  </td>
                  <td>
                      {{ $item->email }}
                  </td>
                  <td>
                    @if($item->verified =='1')
                      Verificado
                    @else
                      @if($item->in_verified_process == '1')
                        Verificación Solicitada
                      @else
                        No Verificado
                      @endif
                    @endif
                  </td>
                  <td>
                      <a href="{{ url('users/'.$item->id.'?v=2') }}"> ver detalle </a>
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
    $('#pageTable').DataTable({
        "orderFixed": [ 0, 'desc' ]
      });
  });
</script>




@endsection
