@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="content">
      <div class="container-fluid">
        <div class="row">

          {{-- Request section --}}
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">content_copy</i>
                </div>
                <p class="card-category">Verificaciones Pendientes</p>
                <h3 class="card-title">5
                  <small>Solicitudes</small>
                </h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="#pablo">Gestionar Solicitudes</a>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">store</i>
                </div>
                <p class="card-category">Transacciones Solicitadas</p>
                <h3 class="card-title">3 <small> Solicitudes</small></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="#pablo">Gestionar Solicitudes</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">info_outline</i>
                </div>
                <p class="card-category">Depositos Solcitados</p>
                <h3 class="card-title">7 <small>Solicitudes</small></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="#pablo">Gestionar Solicitudes</a>
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
