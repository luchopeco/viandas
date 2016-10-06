@extends('admin.masteradmin')

@section('title')
<h1> Gestión de Empresas</h1>
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
               <div class=" panel-heading">Empresas <a href="" id="btnNuevaEmpresa" title="Nueva Empresa" class=" btn-xs btn btn-success" data-toggle="modal" data-target="#modalEmpresaAgregar"><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), editar o eliminar una Empresa</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <tr>
                               <th>Nombre</th>
                               <th>Localidad</th>
                               <th>Envio</th>
                               <th>$ Viandas</th>
                           </tr>
                           @foreach($listEmpresas as $empresa)
                               <tr >
                                   <td>{{$empresa->nombre}}</td>
                                   <td>{{$empresa->Localidad->nombre}}</td>
                                   <td>{{$empresa->Envio()}}</td>
                                   <td><a href="empresas/{{$empresa->id}}"  class="btn btn-xs btn-success"   title="Precio Viandas"><i class="fa fa-usd"></i></a></td>
                                   <td><a href="#"  class="btn btn-xs btn-info editar" data-idempresa="{{$empresa->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                   <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idempresa="{{$empresa->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                               </tr>
                           @endforeach
                       </table>
                   </div>
               </div>
          </div>
       </div>
   </div>
   <hr>
   @if($listEmpresasBajas->count()>0)
   <div class="row">
    <div class="col-md-12">
        <div class=" panel panel-danger">
           <div class=" panel-heading">Empresas Dadas de baja
               <div class="pull-right">
                   <div class="btn-group">
                       <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                           <i class="fa fa-question-circle"></i><b class="caret"></b>
                       </button>
                       <ul class="multiselect-container dropdown-menu pull-right">
                           <li>Desde Aqui Puede Dar de Altas las empresas dadas de baja</li>
                       </ul>
                   </div>
               </div>
           </div>
           <div class=" panel-body">
               <div class="table-responsive">
                   <table class=" table table-bordered table-condensed table-hover table-responsive">
                       <tr>
                           <th>Nombre</th>
                           <th>Localidad</th>
                       </tr>
                       @foreach($listEmpresasBajas as $empresa)
                           <tr >
                               <td>{{$empresa->nombre}}</td>
                               <td>{{$empresa->Localidad->nombre}}</td>
                               <td><a href="#"  class="btn btn-xs btn-success alta" data-idempresa="{{$empresa->id}}"  title="Dar de Alta Empresa"><i class="fa fa-thumbs-up"></i></a></td>
                           </tr>
                       @endforeach
                   </table>
               </div>
           </div>
      </div>
    </div>
   </div>
   @endif
   <div class="modal fade" id="modalEmpresaAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
               <div class="modal-content">
                     {!!Form::open(['route'=>'admin.empresas.store','method'=>'POST', 'data-toggle='>'validator'])!!}
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             <h4 class="modal-title" id="myModalLabel">Agregando Empresa</h4>
                         </div>
                         <div class="modal-body"><div class=" panel panel-default">
                         <div class=" panel-heading">Empresa</div>
                            <div class=" panel-body">
                             <div clas="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                        {!!Form::label('nombre','Nombre')!!}
                                        {!!Form::Text('nombre',null,['class'=>' form-control','required'])!!}
                                        <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                          {!!Form::label('Localidad','Localidad')!!}
                                          {!!Form::select('idlocalidad', $listLocalidad, null,array('class' => 'form-control'))!!}
                                          <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                           Envio ?
                                           {!!Form::checkbox('envio', 0)!!}
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
   <div class="modal fade" id="modalEmpresaModificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
              <div class="modal-content">
                    {!!Form::open(['route'=>'admin.empresas.update','method'=>'PUT', 'data-toggle='>'validator'])!!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Modificando Empresas</h4>
                        </div>
                        <div class="modal-body"><div class=" panel panel-default">
                        <div class=" panel-heading">Empresa</div>
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
                                           {!!Form::label('Localidad','Localidad')!!}
                                           {!!Form::select('idlocalidad', $listLocalidad,null,array('class' => 'form-control','id'=>'idlocalidadU'))!!}
                                           <span class="help-block with-errors"></span>
                                      </div>
                                      <div class="form-group">
                                            Envio ?
                                            {!!Form::checkbox('envio', 0,false,['id'=>'envioU'])!!}
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
    <div class="modal fade" id="modalEmpresaEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.empresas.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Empresa</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar la Empresa?</h3>
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

<div class="modal fade" id="modalalta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
   <div class="modal-content">
      {!!Form::open(['url'=>['admin/empresas/alta'],'method'=>'POST'])!!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Alta Empresa</h4>
        </div>
        <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        {!!Form::Text('id',null,['class'=>'hidden','id'=>'idempresaA'])!!}
                        <h3>¿Desea dar de alta la Empresa?</h3>
                    </div>
               </div>
        <div class="modal-footer">
            <div class="row ">
                <div class="col-md-12">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    {!!Form::submit('Aceptar', array('class' => 'btn btn-success'))!!}
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
            var id_alimento=$(this).attr('data-idempresa');
            $.ajax({
                 url:"empresas/buscar",
                 type: "POST",
                 dataType: "json",
                data:{'id': id_alimento}
                })
            .done(function(response){
                    //alert(response.datos.titulo);
                    $('#idU').val(response.datos.id);
                    $('#nombreU').val(response.datos.nombre);
                    $('#idlocalidadU').val(response.datos.idlocalidad);
                      if(response.datos.envio==1){
                            $('#envioU').prop('checked',true);
                        }
                        else{
                        $('#envioU').prop('checked',false);
                        }
                        //alert(response.datos.envio);
                    $("#modalEmpresaModificar").modal("show");

                })
                .fail(function(){
                    alert(id_alimento);
                });
        });
        $('body').on('click', '.eliminar', function (event) {
            event.preventDefault();
            var id_alimento=$(this).attr('data-idempresa');
            $("#idD").val(id_alimento);
            $("#modalEmpresaEliminar").modal("show");
        });
        $('body').on('click', '.alta', function (event) {
                        event.preventDefault();
                        var id_arbitro=$(this).attr('data-idempresa');
                        $("#idempresaA").val(id_arbitro);
                        $("#modalalta").modal("show");
                    });

    });

</script>
@endsection

