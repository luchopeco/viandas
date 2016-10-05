@extends('admin.masteradmin')

@section('title')
<h1>Gestión de Pedidos</h1>
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
                   <div class=" panel-heading"> <i class="fa fa-users"></i> Pedidos Cliente
                      <div class="pull-right">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-question-circle"></i><span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu pull-right" role="menu">
                                  <li>Solo Busca Pedidos sin Empresa</li>
                                  <li>Desde aqui puede buscar el pedido, y modificarlo</li>
                              </ul>
                          </div>
                       </div>
                   </div>
                   <div class=" panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                Fecha Desde
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" name="fecha_pedido_desde" id="txtfechaDesde" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now('America/Argentina/Buenos_Aires')->format('d/m/Y')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                Fecha Hasta
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" name="fecha_pedido_hasta" id="txtfechaHasta" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now('America/Argentina/Buenos_Aires')->format('d/m/Y')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                Cliente
                                <div class="input-group ">
                                    <span class="input-group-addon" title="Comience a escribir el apellido del cliente"> <i class="fa fa-user"></i></span>
                                    {!!Form::text('cliente', '', array('id' => 'cliente', 'class'=>'form-control'))!!}
                                    {!!Form::text('cliente_id', '', array('id' =>'cliente_id', 'style'=>'display:none'))!!}
                                </div>
                            </div>
                            <div class="col-md-3">.
                                {!!Form::submit('Buscar', array('class' => 'btn btn-success btn-block','id'=>'btnBuscar'))!!}
                            </div>
                        </div>
                        <br>
                        <div id="pedidos-encontrados">

                        </div>
                   </div>
              </div>
        </div>

        <hr>
        <div class="col-md-12">
            <div class=" panel panel-default">
               <div class=" panel-heading"><i class="fa fa-building-o"></i> Pedidos Empresa
                  <div class="pull-right">
                      <div class="btn-group">
                          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-question-circle"></i><span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu pull-right" role="menu">
                              <li>Solo Busca Pedidos Por Empresa</li>
                              <li>Desde aqui puede buscar el pedido, y modificarlo</li>
                          </ul>
                      </div>
                   </div>
               </div>
               <div class=" panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            Fecha Desde
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input class="form-control datepicker" name="fecha_pedido_desde" id="txtfechaDesdeEmpresa" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now('America/Argentina/Buenos_Aires')->format('d/m/Y')}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            Fecha Hasta
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input class="form-control datepicker" name="fecha_pedido_hasta" id="txtfechaHastaEmpresa" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now('America/Argentina/Buenos_Aires')->format('d/m/Y')}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            Empresa
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-building-o"></i>
                                </span>
                                <select class="form-control" name="empresa" id="empresa">
                                <option value="0">TODAS</option>
                                  @foreach($listEmpresas as $e)
                                      <option value="<?php echo $e->id; ?>" > <?php echo $e->nombre; ?></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">.
                            {!!Form::submit('Buscar', array('class' => 'btn btn-success btn-block','id'=>'btnBuscarPedidoEmpresa'))!!}
                        </div>
                    </div>
                    <br>
                    <div id="pedidos-empresa-encontrados">

                    </div>
               </div>
            </div>
        </div>
   </div>


   <div class="modal fade" id="modalPedidoModificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
                 <div class="modal-content">
                       {!!Form::open(['route'=>'admin.pedidos.update','method'=>'PUT', 'data-toggle='>'validator'])!!}
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                               <h4 class="modal-title" id="myModalLabel">Modificando Pedido</h4>
                           </div>
                           <div class="modal-body"><div class=" panel panel-default">
                           <div class=" panel-heading">Pedido</div>
                              <div class=" panel-body">
                               <div clas="row">
                                   <div class="col-md-12">
                                       {!!Form::Text('id',null,['class'=>' hidden form-control','id'=>'idU'])!!}
                                       <h2>Proximamente podra modificar los pedidos sin abonar</h2>
                                   </div>
                                </div>
                           </div>
                      </div></div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                               {!!Form::submit('Aceptar', array('class' => 'btn btn-success'))!!}
                           </div>
                       {!! Form::close() !!}
                 </div>
               <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
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
        var idcliente = $("#cliente_id").val();

        $.ajax({
                url:"../pedidos/buscarpedidos",
                type: "POST",
                dataType: "html",
                data:{'cliente_id': idcliente, 'fecha_pedido_desde':fechaDesde , 'fecha_pedido_hasta':fechaHasta  }
            })
            .done(function(response){
                $('#pedidos-encontrados').html(response);
                $('#cargando').html('');
            })
            .fail(function(){
                //alert(fd);
                $('#cargando').html('');
            });



}
function buscarPedidosEmpresa(){
    $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');
    //event.preventDefault();

    ///si tengo q buscar todos
        var fechaDesde= $("#txtfechaDesdeEmpresa").val();
        var fechaHasta= $("#txtfechaHastaEmpresa").val();

        var empresa = $("#empresa").val();
        $.ajax({
                url:"../pedidos/buscarpedidosempresas",
                type: "POST",
                dataType: "html",
                data:{'empresa_id': empresa, 'fecha_pedido_desde':fechaDesde , 'fecha_pedido_hasta':fechaHasta  }
            })
            .done(function(response){
                $('#pedidos-empresa-encontrados').html(response);
                $('#cargando').html('');
            })
            .fail(function(){
                //alert(fd);
                $('#cargando').html('');
            });



}
$(function () {

    $("#cliente").autocomplete({
        source: "../clientes/like/like",
        minLength: 2,
        select: function( event, ui ) {
            $('#cliente_id').val(ui.item.id);
        }
    });
    $("#btnBuscar").click(function(){
            buscarPedidos();
       });
   $("#btnBuscarPedidoEmpresa").click(function(){
           buscarPedidosEmpresa();
      });
    $('body').on('click', '.editar', function (event) {
                $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');
                event.preventDefault();
                var idpedido=$(this).attr('data-idpedido');
                $.ajax({
                     url:"../pedidos/"+ idpedido+"/edit",
                     type: "GET",
                     dataType: "json"
                    })
                .done(function(response){
                        //alert(response.datos.titulo);
                        $('#nombreU').val(response.datos.nombre);
                        $('#descripcionU').val(response.datos.descripcion);
                        $('#idU').val(response.datos.id);
                        $('#tipo_alimento_idU').val(response.datos.tipo_alimento_id);
                        $("#modalPedidoModificar").modal("show");
                         $('#cargando').html('');
                    })
                    .fail(function(){
                        alert(id_alimento);
                         $('#cargando').html('');
                    });

    });

});
</script>
@endsection