@extends('admin.masteradmin')

@section('title')
<h1> Gestión de Cadetes en Baja</h1>
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
               <div class=" panel-heading">Cadetes de baja 
                   <div class="pull-right">
                      
                       
                   </div>
               </div>
               <div class=" panel-body">


                <div class=" panel panel-success">
                         <div class=" panel-heading"> 
                             Cadetes inactivos                         
                         </div>
                         <div class="panel-body">


                             <div class="table-responsive">
                                 <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                                     <tr>
                                         <th>Nombre y apellido</th>
                                         
                                        
                                         <th>Telefono</th>
                                         
                                         
                                     </tr>
                                     @foreach($listDeleted as $cadete)
                                         
                                        
                                         <tr >
                                             <td>{{$cadete->nombre}} {{$cadete->apellido}}</td>
                                            
                                            
                                             <td>{{$cadete->telefono}}</td>
                                            
                                             
                                             
                                             <td><a href="#" class="btn btn-xs btn-warning baja" data-idcliente="{{$cadete->id}}"  title="Dar de Alta"><i class="fa fa-thumbs-up"></i></a></td>
                                             <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idcliente="{{$cadete->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                                         </tr>

                                         
                                         
                                     @endforeach
                                 </table>
                             </div>
                            


                         </div>

                     </div>
                



               </div>
          </div>
       </div>
   </div>


    <div class="modal fade" id="modalClienteEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.cadetes.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Cadete</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el Cadete? NO lo podra recuperar perdera todos sus datos y su historia</h3>
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

    <div class="modal fade" id="modalClienteBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!!Form::open(['url'=>['admin/cadetes/alta'],'method'=>'POST'])!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Dando de Alta Cadete</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::Text('id',null,['class'=>'hidden','id'=>'idB'])!!}
                            <h3>¿Desea dar de alta un Cadete?</h3>
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
        $('body').on('click', '.baja', function (event) {
            event.preventDefault();
            var id_cliente=$(this).attr('data-idcliente');
            $("#idB").val(id_cliente);
            $("#modalClienteBaja").modal("show");
        });
         $('body').on('click', '.eliminar', function (event) {
            event.preventDefault();
            var id_cliente=$(this).attr('data-idcliente');
            $("#idD").val(id_cliente);
            $("#modalClienteEliminar").modal("show");
        });

    });

</script>
@endsection

