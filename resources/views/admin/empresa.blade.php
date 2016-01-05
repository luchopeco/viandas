@extends('admin.masteradmin')

@section('title')
<h1>{{$empresa->nombre}}<small> Precios de Viandas. </small></h1>
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
               <div class=" panel-heading">Precio Viandas <a href="" id="btnNuevoPrecio" title="Nuevo Precio Viandas" class=" btn-xs btn btn-success" data-toggle="modal" data-target="#modalPrecioAgregar"><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), o eliminar un precio de tipo de vianda para una empresa</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <tr>
                               <th>Tipo Vianda</th>
                               <th>Precio</th>
                           </tr>
                           @foreach($empresa->ListPreciosViandas as $vianda)
                               <tr >
                                   <td>{{$vianda->nombre}}</td>
                                   <td>{{$vianda->pivot->precio}}</td>
                                   <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idvianda="{{$vianda->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                               </tr>
                           @endforeach
                       </table>
                   </div>
               </div>
          </div>
       </div>
   </div>
   <div class="modal fade" id="modalPrecioAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
               <div class="modal-content">
                    {!!Form::open(['url'=>'admin/empresas/preciovianda','method'=>'POST', 'data-toggle='>'validator'])!!}
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             <h4 class="modal-title" id="myModalLabel">Agregando Precio de Vianda</h4>
                         </div>
                         <div class="modal-body"><div class=" panel panel-default">
                         <div class=" panel-heading">Vianda</div>
                            <div class=" panel-body">
                             <div clas="row">
                                {!!Form::Text('empresa_id',$empresa->id,['class'=>'hidden'])!!}
                                 <div class="col-md-12">
                                     <div class="form-group">
                                           {!!Form::label('Tipo Vianda','Tipo Vianda')!!}
                                           {!!Form::select('tipo_vianda_id', $listTiposViandas, null,array('class' => 'form-control'))!!}
                                           <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                        {!!Form::label('Precio','Precio')!!}
                                        {!!Form::Number('precio',null,['class'=>' form-control','required'])!!}
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
    <div class="modal fade" id="modalPrecioEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                  {!!Form::open(['url'=>'admin/empresas/precioviandaeliminar','method'=>'POST'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando el precio de la vianda</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('empresa_id',$empresa->id,['class'=>'hidden'])!!}
                                   {!!Form::Text('tipo_vianda_id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el precio de la vianda?</h3>
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
        $('body').on('click', '.eliminar', function (event) {
            event.preventDefault();
            var id_alimento=$(this).attr('data-idvianda');
            $("#idD").val(id_alimento);
            $("#modalPrecioEliminar").modal("show");
        });

    });

</script>
@endsection

