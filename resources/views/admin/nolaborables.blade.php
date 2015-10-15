@extends('admin.masterAdmin')

@section('title')
<h1> Gestión de Dias no laborables</h1>
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
               <div class=" panel-heading">Definir dias no laborables <a href="" id="btnNuevoNoLaborables" title="Nuevo NoLaborables" class=" btn-xs btn btn-success" data-toggle="modal" data-target="#modalNoLaborablesAgregar"><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), editar o eliminar un NoLaborables</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <tr>
                               <th>Fecha</th>
                               <th>Motivo</th>
                           </tr>
                           
                           @foreach($listNoLaborables as $nolaborables)
                               <tr >
                                   <td>{{$nolaborables->fecha}}</td>
                                   <td>{{$nolaborables->motivo}}</td>
                                   <td><a href="#"  class="btn btn-xs btn-info editar" data-idnolaborable="{{$nolaborables->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                   <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idnolaborable="{{$nolaborables->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                               </tr>
                           @endforeach
                       </table>
                   </div>
               </div>
          </div>
       </div>
   </div>
   <div class="modal fade" id="modalNoLaborablesAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
               <div class="modal-content">
                     {!!Form::open(['route'=>'admin.nolaborables.store','method'=>'POST', 'data-toggle='>'validator'])!!}
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             <h4 class="modal-title" id="myModalLabel">Agregando NoLaborables</h4>
                         </div>
                         <div class="modal-body"><div class=" panel panel-default">
                         <div class=" panel-heading">No Laborables</div>
                            <div class=" panel-body">
                             <div clas="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                               {!!Form::label('fecha','Fecha')!!}
                                               {!!Form::Text('fecha',null,['class'=>' form-control','required'])!!}
                                           <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                        {!!Form::label('mootivo','Motivo')!!}
                                        {!!Form::Text('motivo',null,['class'=>' form-control','required'])!!}
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
   <div class="modal fade" id="modalNoLaborablesModificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
              <div class="modal-content">
                    {!!Form::open(['route'=>'admin.nolaborables.update','method'=>'PUT', 'data-toggle='>'validator'])!!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Modificando NoLaborables</h4>
                        </div>
                        <div class="modal-body"><div class=" panel panel-default">
                        <div class=" panel-heading">NoLaborables</div>
                           <div class=" panel-body">
                            <div clas="row">
                                <div class="col-md-12">
                                    {!!Form::Text('id',null,['class'=>' hidden form-control','id'=>'idU'])!!}
                                    <div class="form-group">
                                          {!!Form::label('fecha','Fecha')!!}
                                          {!!Form::Text('fecha',null,['class'=>' form-control','id'=>'fechaU','required'])!!}
                                      <span class="help-block with-errors"></span>
                                    </div>
                                    <div class="form-group">
                                       {!!Form::label('motivo','Motivo')!!}
                                       {!!Form::Text('motivo',null,['class'=>' form-control','id'=>'motivoU','required'])!!}
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
    <div class="modal fade" id="modalNoLaborablesEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.nolaborables.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando NoLaborables</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el NoLaborables?</h3>
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
            var id_nolaborable=$(this).attr('data-idnolaborable');
            $.ajax({
                 url:"nolaborables/buscar",
                 type: "POST",
                 dataType: "json",
                data:{'id': id_nolaborable}
                })
            .done(function(response){
                    //alert(response.datos.titulo);
                    $('#fechaU').val(response.datos.fecha);
                    $('#motivoU').val(response.datos.motivo);
                    $('#idU').val(response.datos.id);
                    $("#modalNoLaborablesModificar").modal("show");
                })
                .fail(function(){
                    alert(id_tipoalimento);
                });
        });
        $('body').on('click', '.eliminar', function (event) {
            event.preventDefault();
            var id_nolaborable=$(this).attr('data-idnolaborable');
            $("#idD").val(id_nolaborable);
            $("#modalNoLaborablesEliminar").modal("show");
        });

    });

</script>
@endsection

