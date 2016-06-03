@extends('admin.masteradmin')

@section('title')
<h1>Cobros</h1>
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
                   <div class=" panel-heading">Cobros a liquidar
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
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>Seleccione una empresa a cobrar. </label>
                                <select class="form-control" name="empresa" id="empresa">
                                  <?php foreach($empresas as $e){
                                    ?>
                                      <option value="<?php echo $e->id; ?>" > <?php echo $e->nombre; ?></option>
                                    <?php  } ?>
                                    <option value="9999">SIN EMPRESA</option>
                                  
                                </select>
                              </div>
                             

                            </div>

                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>Fecha desde</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                          {!!Form::date('fechaDesde',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>' form-control datepicker','required','id'=>'txtfechaDesde'])!!}
                                          
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>Fecha Hasta</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                          {!!Form::date('fechaHasta',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>' form-control datepicker','required','id'=>'txtfechaHasta'])!!}
                                          
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                   <button type="button" id="btnBuscar" title="Buscar" class="btn btn-success "><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12" id="tabla-pedidos"></div>
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
        var fechaDesde= $("#txtfechaDesde").val();
        var fechaHasta= $("#txtfechaHasta").val();
        var empresa = $("#empresa").val();
        
        $.ajax({
                url:"cobros/buscarcobros",
                type: "POST",
                dataType: "html",
                data:{'empresa': empresa, 'fechaHasta':fechaHasta , 'fechaDesde':fechaDesde  }
            })
            .done(function(response){
                $('#tabla-pedidos').html(response);
                $('#cargando').html('');
            })
            .fail(function(){
                //alert(fd);
                $('#cargando').html('');
            });
        $('#cargando').html('');


}
$(function () {
        ///busco los pedidos del dia
       //buscarPedidos();
        ////cuando busco
       $("#btnBuscar").click(function(){
            buscarPedidos();
       });

    });

</script>
<script type="text/javascript" src="code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" media="screen" />
<script>
  $(document).ready(function() {
    $('#cobros').DataTable();
} );

function activardatatable(){
    alert();
     $('#cobros').DataTable();
  }
</script>
@endsection

