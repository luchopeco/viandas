@extends('admin.masteradmin')

@section('title')
<h1> Gestión de Gastos</h1>
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
               <div class=" panel-heading">Gastos <a href="" id="btnNuevoGasto" title="Nuevo Gasto" class=" btn-xs btn btn-success" data-toggle="modal" data-target="#modalGastoAgregar"><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), editar Buscar o eliminar gastos</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Fecha Desde</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="fecha_desde" class="form-control datepicker" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Fecha Hasta</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control datepicker" id="fecha_hasta" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}">
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
                        <div class="col-md-12" id="tabla-gastos"></div>
                    </div>
               </div>
          </div>
       </div>
   </div>
   <div class="modal fade" id="modalGastoAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
               <div class="modal-content">
                     {!!Form::open(['route'=>'admin.gastos.store','method'=>'POST', 'data-toggle='>'validator'])!!}
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             <h4 class="modal-title" id="myModalLabel">Agregando Gasto</h4>
                         </div>
                         <div class="modal-body"><div class=" panel panel-default">
                         <div class=" panel-heading">Gasto</div>
                            <div class=" panel-body">
                             <div clas="row">
                                 <div class="col-md-12">
                                    <div class="form-group">
                                         <label>Fecha</label>
                                         <div class="input-group">
                                             <div class="input-group-addon">
                                                 <i class="fa fa-calendar"></i>
                                             </div>
                                              {!!Form::date('fecha',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>' form-control datepicker','required'])!!}
                                         </div>
                                     </div>
                                     <div class="form-group">
                                        {!!Form::label('descripcion','Descripcion')!!}
                                        {!!Form::Text('descripcion',null,['class'=>' form-control','required'])!!}
                                        <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                         {!!Form::label('monto','Monto')!!}
                                         {!!Form::Text('monto',null,['class'=>' form-control','required'])!!}
                                         <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                          {!!Form::label('tipoGasto','Tipo Gasto')!!}
                                          {!!Form::select('idtipo_gasto', $listTipoGastos,null,array('class' => 'form-control'))!!}
                                          <span class="help-block with-errors"></span>
                                     </div>
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
   <div class="modal fade" id="modalGastoModificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
              <div class="modal-content">
                    {!!Form::open(['route'=>'admin.gastos.update','method'=>'PUT', 'data-toggle='>'validator'])!!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Modificando Gasto</h4>
                        </div>
                        <div class="modal-body"><div class=" panel panel-default">
                        <div class=" panel-heading">Gasto</div>
                           <div class=" panel-body">
                            <div clas="row">
                                <div class="col-md-12">
                                {!!Form::Text('id',null,['class'=>' hidden form-control','id'=>'idU'])!!}
                                    <div class="form-group">
                                         <label>Fecha</label>
                                         <div class="input-group">
                                             <div class="input-group-addon">
                                                 <i class="fa fa-calendar"></i>
                                             </div>
                                              {!!Form::date('fecha',null,['class'=>' form-control datepicker','required','id'=>'fechaU'])!!}
                                         </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('descripcion','Descripcion')!!}
                                        {!!Form::Text('descripcion',null,['class'=>' form-control','required','id'=>'descripcionU'])!!}
                                        <span class="help-block with-errors"></span>
                                    </div>
                                    <div class="form-group">
                                         {!!Form::label('monto','Monto')!!}
                                         {!!Form::Text('monto',null,['class'=>' form-control','required','id'=>'montoU'])!!}
                                         <span class="help-block with-errors"></span>
                                    </div>
                                    <div class="form-group">
                                          {!!Form::label('tipoGasto','Tipo Gasto')!!}
                                          {!!Form::select('idtipo_gasto', $listTipoGastos,null,array('class' => 'form-control','id'=>'idtipo_gastoU'))!!}
                                          <span class="help-block with-errors"></span>
                                    </div>
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
    <div class="modal fade" id="modalGastoEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.gastos.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Alimento</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el Gasto?</h3>
                                   <div id="caca"></div>
                               </div>
                          </div>
                   <div class="modal-footer">
                       <div class="row ">
                           <div class="col-md-12">
                               <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                               {!!Form::submit('Eliminar', array('class' => 'btn btn-success'))!!}
                           </div>
                       </div>
                   </div>
                 {!! Form::close() !!}
              </div>
               <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
     </div>
    </div>
@endsection

@section('script')
<script>
function buscarGastos(){
    $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');
   // event.preventDefault();
    var fd =$('#fecha_desde').val();
    var fh =$('#fecha_hasta').val();
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
        buscarGastos();
        $('body').on('click', '.editar', function (event) {
            event.preventDefault();
            var id_alimento=$(this).attr('data-idgasto');
            $.ajax({
                 url:"gastos/buscar",
                 type: "POST",
                 dataType: "json",
                data:{'id': id_alimento}
                })
            .done(function(response){
                    //alert(response.datos.titulo);
                    $('#fechaU').val(response.datos.fecha);
                    $('#descripcionU').val(response.datos.descripcion);
                    $('#idU').val(response.datos.id);
                    $('#idtipo_gastoU').val(response.datos.idtipo_gasto);
                    $('#montoU').val(response.datos.monto);

                    $("#modalGastoModificar").modal("show");
                })
                .fail(function(){
                    alert(id_alimento);
                });
        });
        $('body').on('click', '.eliminar', function (event) {
            event.preventDefault();
            var id_alimento=$(this).attr('data-idgasto');
            $("#idD").val(id_alimento);
            $("#modalGastoEliminar").modal("show");
        });

        $('body').on('click', '.buscar', function (event) {
            buscarGastos();
         });

    });

</script>
@endsection

