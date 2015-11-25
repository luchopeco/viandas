@extends('admin.masteradmin')

@section('title')
<h1> Listado de Viandas</h1>
@endsection

@section('breadcrumb')
<li><a href="/admin/home"><i class="fa fa-home"></i> Home</a></li>
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
       <div class=" col-md-12">
             <div class=" panel panel-default">
                   <div class=" panel-heading">Viandas
                   </div>
                   <div class=" panel-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input  name="fecha" id="fecha" class="form-control datepicker" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                            .
                                <button type="button" title="Buscar" class="btn btn-success btn-block buscar"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12" id="tabla-viandas"></div>
                        </div>
                   </div>
              </div>
       </div>
   </div>
@endsection

@section('script')
<script>
function buscarViandas(){
    $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');
   // event.preventDefault();
    var f =$('#fecha').val();
    $.ajax({
        url:"gastos/buscarxfechas",
        type: "POST",
        dataType: "html",
        data:{'fecha_desde': fd,'fecha_hasta': fh}
    })
    .done(function(response){
        $('#tabla-gastos').html(response);
        $('#cargando').html('');
    })
    .fail(function(){
        alert(fd);
        $('#cargando').html('');
    });
}
$(function () {
        buscarViandas();
        $('body').on('click', '.buscar', function (event) {
            buscarGastos();
         });

    });

</script>
@endsection

