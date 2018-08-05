@extends('layouts.app')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />

@section('content')

<div class="content" style="margin-top: -45px;">
       <div class="container-fluid">
         <div class="row">
           <div class="col-md-8">
             <div class="card">
               <div class="card-header card-header-primary">
                 <h4 class="card-title">Ver detalle de Transacción</h4>
                 <p class="card-category">En esta seccion podra ver la informacion de una transacción para procesarla.</p>
               </div>
               <div class="card-body">
                 <h3 class="card-title">Información de la transacción.</h3>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Nombre Legal de la persona natural</label>
                         <input type="text" class="form-control" value="{{$transaction->natural_person->legal_name}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Cédula del titular</label>
                         <input type="text" class="form-control" value="{{$transaction->natural_person->cedula}}" disabled>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Correo electrónico</label>
                         <input type="email" class="form-control" value="{{$transaction->natural_person->email}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Banco</label>
                         <input type="text" class="form-control" value="{{$transaction->natural_person->bank_id}}" disabled>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Número de cuenta</label>
                         <input type="email" class="form-control" value="{{$transaction->natural_person->account_number}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Tipo de Cuenta</label>
                         <input type="text" class="form-control" value="Corriente" disabled>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Monto en Usd</label>
                         <input type="email" class="form-control" value="Usd {{$transaction->amount_usd}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Monto por comisión</label>
                         <input type="text" class="form-control" value="PENDIENTE" disabled>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Monto en Bsf a transferir</label>
                         <input type="email" class="form-control" value="Bsf {{$transaction->total_bsf_amount}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Valor del Bolivar contra el Dolar</label>
                         <input type="text" class="form-control" value="Bsf {{$transaction->exchange_rate_value}} por Dolar" disabled>
                       </div>
                     </div>
                   </div>

                   <div class="card-body">
                     <h3 class="card-title">Historico de Transaccion.</h3>

                     <table class="display" style="width:100%;">
                       <thead>
                         <th style="text-align:center;">
                           Status
                         </th>
                         <th style="text-align:center;">
                           Fecha
                         </th>
                         <th style="text-align:center;">
                           Información
                         </th>
                       </thead>
                       <tbody>
                         @foreach ($transaction->history as $item)
                           <tr>
                            <td style="text-align:center;">
                              @if($item->transaction_status_id == '1')
                                Creada
                              @elseif ($item->transaction_status_id == '2')
                                Procesada
                              @else
                                Negada
                              @endif
                            </td>
                            <td style="text-align:center;">
                              {{$item->created_at}}
                            </td>
                            <td style="text-align:center;">
                              {{$item->message}}
                            </td>
                          </tr>
                         @endforeach
                       </tbody>
                     </table>

                   </div>

                   <h3 class="card-title"><br>Acciones de la transacción.</h3>
                   <form method="get" action="{{ url('transactions/process/'.$transaction->id) }}" enctype="form-data">

                     <h5 class="card-title">Marcar como procesada.</h4>

                     <div class="row">
                       <div class="col-md-12">
                         <h6 class="card-category text-gray">Una transaccion aprobada es aquella que fue efectivamente procesda, es decir fueron transaferidos los Bolivares a la cuenta de destino.</h6>
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">
                           <label class="bmd-label-floating">Comentario / Nro de referencia </label>
                           <input type="text" name="message" class="form-control" required>
                         </div>
                       </div>
                       <div class = "col-md-6">
                         <div class="form-group">
                           <button type="submit" class="btn btn-primary pull-center" style="width: 100%;">
                             Marcar transaccion como procesada
                           </button>
                          </div>
                       </div>
                     </div>
                 </form>
                 <form method="get" action="{{ url('transactions/denegate/'.$transaction->id) }}" enctype="form-data">

                   <h5 class="card-title"><br><br>Marcar como denegada.</h4>

                   <div class="row">
                     <div class="col-md-12">
                       <h6 class="card-category text-gray">Una transaccion denegada es aquella que no puede ser procesada, es decir, no fue posible realizar la transferencia de los Bolivares a la cuenta del destino.</h6>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Motivo / comentario </label>
                         <input type="text" name="message" class="form-control" value="" required>
                       </div>
                     </div>
                     <div class = "col-md-6">
                       <div class="form-group">
                         <button type="submit" class="btn btn-danger pull-center" style="width: 100%;">Denegar transacción</button>
                        </div>
                     </div>
                   </div>
                 </form>

               </div>
             </div>
           </div>
           <div class="col-md-4">
             <div class="card card-profile">
               <div class="card-avatar">
                 <a href="#pablo">
                   <img class="img" src="{{$transaction->transactionOwner->profile_img_url}}" />
                 </a>
               </div>
               <div class="card-body">
                 <h4 class="card-title">Información del emisor.</h4>

                 <h6 class="card-category text-gray">Nombre: {{$transaction->transactionOwner->first_name}}  {{$transaction->transactionOwner->last_name}}.</h6>
                 <h6 class="card-category text-gray">Email: {{$transaction->transactionOwner->email}}.</h6>

                 <div class="row">
                   <div class="col-md-12">
                     <a href="{{ url('/users/'.$transaction->transactionOwner->id) }}" class="btn btn-primary pull-center">Ver Emisor</a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
@endsection
