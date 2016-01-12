@extends('admin.masteradmin')

@section('title')
<h1>Viandas de: <small>{{$cliente->nombre}} {{$cliente->apellido}} - @if($cliente->Empresa!=null) {{$cliente->Empresa->nombre}} @endif</small></h1>
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
       <div class=" col-md-12">
          <div class=" panel panel-default">
               <div class=" panel-heading">Viandas <a href="" id="btnNuevaViandas" title="Nueva Vianda" class=" btn-xs btn btn-success" data-toggle="modal" data-target="#modalViandaAgregar"><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"),eliminar viandas para los clientes.</li>
                               <li>En caso de modificar una, eliminela y agregue una nueva</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <tr>
                               <th>Dia</th>
                               <th>Tipo Vianda</th>
                               <th>Cantidad</th>
                           </tr>
                           @foreach($cliente->ListViandas as $v)
                               <tr >
                                   <td>{{$v->DiaSemana->nombre}}</td>
                                   <td>{{$v->TipoVianda->nombre}}</td>
                                   <td>{{$v->cantidad}}</td>
                                   <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idvianda="{{$v->cliente_id}}-{{$v->dia_semana_id}}-{{$v->tipo_vianda_id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                               </tr>
                           @endforeach
                       </table>
                   </div>
               </div>
          </div>
       </div>
   </div>
   <div class="modal fade" id="modalViandaAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
               <div class="modal-content">
                     {!!Form::open(['route'=>'admin.viandasclientes.store','method'=>'POST', 'data-toggle='>'validator'])!!}
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             <h4 class="modal-title" id="myModalLabel">Agregando Vianda</h4>
                         </div>
                         <div class="modal-body"><div class=" panel panel-default">
                         <div class=" panel-heading">Vianda</div>
                            <div class=" panel-body">
                             <div clas="row">
                                 <div class="col-md-12">
                                    {!!Form::Text('cliente_id',$cliente->id,['class'=>' form-control hidden '])!!}
                                     <div class="form-group">
                                        Dia
                                        {!!Form::select('dia_semana_id', $listdiasSemana, null,array('class' => 'form-control'))!!}
                                        <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                         Tipo Vianda
                                          {!!Form::select('tipo_vianda_id', $listtiposViandas, null,array('class' => 'form-control'))!!}
                                          <span class="help-block with-errors"></span>
                                     </div>
                                     <div class="form-group">
                                           Cantidad
                                           {!!Form::Text('cantidad',null,['class'=>' form-control','required'])!!}
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
    <div class="modal fade" id="modalViandaEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.viandasclientes.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Vianda</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar la Vianda?</h3>
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
            $("#modalViandaEliminar").modal("show");
        });

    });

</script>
@endsection

