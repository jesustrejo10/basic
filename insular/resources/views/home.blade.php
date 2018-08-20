@extends('layouts.app')

@section('content')
<div class="content" style="margin-top: -45px; margin-left:40px; margin-right:40px;">
    <div class="row justify-content-center">
        <div class="container-fluid " >
          <div class=" card card-header card-header-primary "style="background: linear-gradient(180deg, #64a3d6, #1c5196); margin-top:-5px;">
            <h3 class="card-title" style="color:#fff;">Gestión general del sistema.</h3>
            <p class="card-category" style="color:#fff;">En esta sección es posible ver los reportes del sistema. <br> Además con la opción ver detalle, puede conocer más información del mismo.</p>
          </div>
        </div>

      <div class="container-fluid">
        <div class="row">

          {{-- Request section --}}
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon" style="    background: linear-gradient(180deg, #64a3d6, #1c5196);">
                  <i class="material-icons">person</i>
                </div>
                <p class="card-category">Verificaciones Pendientes</p>
                <h3 class="card-title">{{$usersPendingToValidate}}
                  <small>Solicitudes</small>
                </h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="{{url('users?v=2')}}">Gestionar Solicitudes</a>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon" style="    background: linear-gradient(180deg, #64a3d6, #1c5196);">
                  <i class="material-icons">content_paste</i>
                </div>
                <p class="card-category">Transacciones Solicitadas</p>
                <h3 class="card-title">{{$pendingTransactionsAmount}} <small> Solicitudes</small></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="{{url('transactions?v=3')}}">Gestionar Solicitudes</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon" style="    background: linear-gradient(180deg, #64a3d6, #1c5196);">
                  <i class="material-icons">attach_money</i>
                </div>
                <p class="card-category">Tasa de cambio activa</p>
                <h5 class="card-title"><b>$ 1 USD ~ Bsf {{$finalMount}} VEF</b </h5>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="{{url('exchange_rates?v=5')}}">Gestionar tasas de cambio</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- End of request section --}}

        <div class="row">
          <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-success">
                <div class="ct-chart" id="dailySalesChart"></div>
              </div>
              <div class="card-body">
                <h4 class="card-title">Daily Salesasdasdasda</h4>
                <p class="card-category">
                  <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
              </div>

              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> updated 4 minutes ago
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-warning">
                <div class="ct-chart" id="websiteViewsChart"></div>
              </div>
              <div class="card-body">
                <h4 id="shit" class="card-title">Email Subscriptions</h4>
                <p class="card-category">Last Campaign Performance</p>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> campaign sent 2 days ago
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-danger">
                <div class="ct-chart" id="completedTasksChart"></div>
              </div>
              <div class="card-body">
                <h4 class="card-title">Completed Tasks</h4>
                <p class="card-category">Last Campaign Performance</p>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> campaign sent 2 days ago
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var a = <?php echo json_encode($a ); ?>;
  var b = <?php echo json_encode($b );?>;
</script>
<script src="{{ asset('js/core/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<script src="{{ asset('js/plugins/chartist.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
<script src="{{ asset('js/material-dashboard.js?v=2.1.0') }}" type="text/javascript"></script>

<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();
    shitFunction();

  });
</script>
@endsection
