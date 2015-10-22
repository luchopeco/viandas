@extends('admin.masterAdmin')

@section('title')
<h1>Alimentos que NO Gustan</h1>
@endsection

@section('breadcrumb')
<li><a href="/admin/home"><i class="fa fa-home"></i> Home</a> / <a href="/admin/clientes"><i class="fa fa-user"></i> Cliente</a> </li>
@endsection

@section('content')
   @if(Session::has('mensajeOk'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{Session::get('mensajeOk')}}
                </div>
            </div>
        </div>
        </hr>
   @endif
   @if(Session::has('mensajeError'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('mensajeError')}}
                </div>
            </div>
        </div>
        </hr>
   @endif

        <div class="row">
            @foreach($listTiposAlimentos as $tipoAlimento)
                <div class="col-md-12">
                     <div class="box box-primary">
                         <div class="box-header with-border">
                             <h3 class="box-title">{{$tipoAlimento->nombre}}</h3>
                         </div>
                         <div class="box-body">
                            <div class="row">
                                @foreach($tipoAlimento->ListAlimentos as $alimento)
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading with-border">
                                           {{$alimento->nombre}}
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @foreach($alimento->ListClientesNoMeGusta as $cliente)
                                                    <p>{{$cliente->nombre}} {{$cliente->apellido}}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                         </div>
                     </div>
                </div>
            @endforeach
        </div>

@endsection

@section('script')

@endsection

