@extends('admin.masterAdmin')

@section('title')
<h1> Gestión de Tipos de Alimentos</h1>
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
               <div class=" panel-heading">Tipos Alimentos <a href="" id="btnNuevoTipoAlimento" title="Nuevo Tipo Alimento" class=" btn-xs btn btn-success" data-toggle="modal" data-target="#modalTipoAlimentoAgregar"><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), editar o eliminar un Tipo de Alimento</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <tr>
                               <th>Nombre</th>
                               <th>Descripcion</th>
                           </tr>
                           @foreach($listTiposAlimentos as $tipoAlimento)
                               <tr >
                                   <td>{{$tipoAlimento->nombre}}</td>
                                   <td>{{$tipoAlimento->descripcion}}</td>
                                   <td><a href="#"  class="btn btn-xs btn-info editar" data-idtipoalimento="{{$tipoAlimento->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                   <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idtipoalimento="{{$tipoAlimento->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                               </tr>
                           @endforeach
                       </table>
                   </div>
               </div>
          </div>
       </div>
   </div>
   <div class="modal fade" id="modalTipoAlimentoAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
               <div class="modal-content">
                     {!!Form::open(['route'=>'admin.tiposalimentos.store','method'=>'POST', 'data-toggle='>'validator'])!!}
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             <h4 class="modal-title" id="myModalLabel">Agregando Tipo Alimento</h4>
                         </div>
                         <div class="modal-body"><div class=" panel panel-default">
                         <div class=" panel-heading">Tipo Alimento</div>
                            <div class=" panel-body">
                             <div clas="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                               {!!Form::label('nombre','Nombre')!!}
                                               {!!Form::Text('nombre',null,['class'=>' form-control','required'])!!}
                                           <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                        {!!Form::label('descripcion','Descripcion')!!}
                                        {!!Form::Text('descripcion',null,['class'=>' form-control','required'])!!}
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
   <div class="modal fade" id="modalTipoAlimentoModificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
              <div class="modal-content">
                    {!!Form::open(['route'=>'admin.tiposalimentos.update','method'=>'PUT', 'data-toggle='>'validator'])!!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Modificando Tipo Alimento</h4>
                        </div>
                        <div class="modal-body"><div class=" panel panel-default">
                        <div class=" panel-heading">Tipo Alimento</div>
                           <div class=" panel-body">
                            <div clas="row">
                                <div class="col-md-12">
                                    {!!Form::Text('id',null,['class'=>' hidden form-control','id'=>'idU'])!!}
                                    <div class="form-group">
                                          {!!Form::label('nombre','Nombre')!!}
                                          {!!Form::Text('nombre',null,['class'=>' form-control','id'=>'nombreU','required'])!!}
                                      <span class="help-block with-errors"></span>
                                    </div>
                                    <div class="form-group">
                                       {!!Form::label('descripcion','Descripcion')!!}
                                       {!!Form::Text('descripcion',null,['class'=>' form-control','id'=>'descripcionU','required'])!!}
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
    <div class="modal fade" id="modalTipoAlimentoEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.tiposalimentos.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Tipo Alimento</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el Tipo de Alimento?</h3>
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
    $(function () {
        $('body').on('click', '.editar', function (event) {
            event.preventDefault();
            var id_tipoalimento=$(this).attr('data-idtipoalimento');
            $.ajax({
                 url:"tiposalimentos/buscar",
                 type: "POST",
                 dataType: "json",
                data:{'id': id_tipoalimento}
                })
            .done(function(response){
                    //alert(response.datos.titulo);
                    $('#nombreU').val(response.datos.nombre);
                    $('#descripcionU').val(response.datos.descripcion);
                    $('#idU').val(response.datos.id);
                    $("#modalTipoAlimentoModificar").modal("show");
                })
                .fail(function(){
                    alert(id_tipoalimento);
                });
        });
        $('body').on('click', '.eliminar', function (event) {
            event.preventDefault();
            var id_tipoalimento=$(this).attr('data-idtipoalimento');
            $("#idD").val(id_tipoalimento);
            $("#modalTipoAlimentoEliminar").modal("show");
        });

    });

</script>
@endsection

