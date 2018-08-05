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
                 <h4 class="card-title">Ver detalle de Usuario</h4>
                 <p class="card-category">En esta seccion podra ver la informacion de un usuario en especifico y validarlo si corresponde.</p>
               </div>
               <div class="card-body">
                 <form>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Nombre</label>
                         <input type="text" class="form-control" value="{{$user->first_name}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Apellido</label>
                         <input type="text" class="form-control" value="{{$user->last_name}}" disabled>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Correo electrónico</label>
                         <input type="email" class="form-control" value="{{$user->email}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Nacionalidad</label>
                         <input type="text" class="form-control" value="{{$user->country_id}}" disabled>
                       </div>
                     </div>
                   </div>

                  @if ($user -> verified == '1' or $user ->in_verified_process == '1' or $user -> verified == '2')

                   <div class="row">
                     <div class="col-md-12">
                       <div class="form-group">
                         <label>Validación de usuario</label>
                         <div class="form-group">
                           <label class="bmd-label-floating"> En esta seccion el administrador debera cotejar la información del pasaporte con la informacion del usuario.</label>
                         </div>
                       </div>
                     </div>
                     <div class="col-md-1">
                     </div>
                     @if($user->verified == "1")
                     <div class="alert alert-success col-md-10 pull-center">
                        <span>
                          <b> Verificación completada. - </b> Este usuario ha sido verificado.</span>
                      </div>
                      @else
                        @if($user ->verified == '2' && $user->in_verified_process == '0')
                          <div class="alert alert-danger col-md-10 pull-center">
                           <span>
                             <b> Verificación denegada. - </b> Este usuario debera volver a solicitar la verificación de su identidad.</span>
                         </div>
                        @else
                          <div class="alert alert-warning col-md-10 pull-center">
                           <span>
                             <b> Verificación solicitada. - </b> Este usuario ha solicitado la verificación de su identidad.</span>
                         </div>
                        @endif

                      @endif
                      <div class="col-md-1">
                      </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <label class="bmd-label-floating">Nro de pasaporte</label>
                         <input type="text" class="form-control" value="{{$user->passport_number}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <label class="bmd-label-floating">Pasaporte</label>
                         <img src="{{$user->passport_img_url}}" alt="Italian Trulli">
                       </div>
                     </div>
                   </div>
                    @if ($user -> verified == '0' || $user->in_verified_process == '1')
                    <div class="row">
                      <div class="col-md-6">
                        <a href="{{ url('users/validate/'.$user->id.'?new_status=2') }}" class="btn btn-danger pull-right">Denegar Validacion de Usuario</a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="col-md-6">
                        <a class="btn pull-left" style="background:#4BB543;" href="{{ url('users/validate/'.$user->id.'?new_status=1') }}">Validar Usuario</a>
                        <div class="clearfix"></div>
                      </div>
                    </div>

                    @endif
                  @endif
                 </form>
               </div>
             </div>
           </div>
           <div class="col-md-4">
             <div class="card card-profile">
               <div class="card-avatar">
                 <a href="#pablo">
                   <img class="img" src="{{$user->profile_img_url}}" />
                 </a>
               </div>
               <div class="card-body">
                 <h6 class="card-category text-gray">{{$user->first_name}}  {{$user->last_name}}.</h6>
                 <h4 class="card-title">Acciones adicionales.</h4>
                 <div class="row">
                   <div class="col-md-12">
                     <button type="submit" class="btn btn-primary pull-center">Ver Depositos</button>
                   </div>
                   <div class="col-md-12">
                     <button type="submit" class="btn btn-primary pull-center">Ver Transacciones</button>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
@endsection
