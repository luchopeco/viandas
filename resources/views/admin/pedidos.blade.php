@extends('admin.masteradmin')

@section('title')
<h1>Pedidos</h1>
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
                   <div class=" panel-heading">Pedidos
                      <div class="pull-right">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-question-circle"></i><span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu pull-right" role="menu">
                                  <li>Desde aquí se confirman los pedidos realizados en el dia. Solo puede buscar pedidos de 4 dias atras, no mayores al dia actual.</li>
                                  <li></li>
                              </ul>
                          </div>
                       </div>
                   </div>
                   <div class=" panel-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Dia</label>
                                    <div class="input-group">
                                         <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </span>
                                           <input class="form-control datepicker" name="fecha" id="txtfecha" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now('America/Argentina/Buenos_Aires')->format('d/m/Y')}}">

                                          <span class="input-group-addon">
                                             <button type="button" id="btnBuscar" title="Buscar" class="btn btn-success btn-xs"><i class="fa fa-search"></i></button>
                                          </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="tabla-pedidos"></div>
                            </div>
                        </div>
                   </div>
              </div>
       </div>
   </div>
@endsection

@section('script')
<script>
function buscarPedidos(){
    $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');
    //event.preventDefault();

    ///si tengo q buscar todos
        var fecha= $("#txtfecha").val();
        $.ajax({
                url:"pedidos/buscar",
                type: "POST",
                dataType: "html",
                data:{'fecha': fecha}
            })
            .done(function(response){
                $('#tabla-pedidos').html(response);
                $('#cargando').html('');
            })
            .fail(function(){
                $('#cargando').html('');
            });
}
$(function () {
        ///busco los pedidos del dia
       buscarPedidos();
        ////cuando busco
       $("#btnBuscar").click(function(event){
            buscarPedidos();
       });

});
</script>
@endsection