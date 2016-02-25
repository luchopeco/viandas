@extends('admin.masteradmin')

@section('title')
<h1> Gestión de Clientes</h1>
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
               <div class=" panel-heading">Clientes <a href="clientes/create" id="btnNuevoCliente" title="Nuevo Cliente" class=" btn-xs btn btn-success" ><i class=" fa fa-plus"></i></a>
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), editar o eliminar un Cliente</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">

                @foreach($listEmpresas as $empresa)
                    <div class=" panel panel-primary">
                         <div class=" panel-heading"> 
                              {{$empresa->nombre}}                              
                         </div>
                         <div class="panel-body">


                             <div class="table-responsive">
                                 <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                                     <tr>
                                         <th>Nombre</th>
                                    
                                         <th>No le Gusta</th>
                                         <th>Domicilio</th>
                                         <th>Telefono</th>
                                         <th>Email</th>
                                         
                                     </tr>
                                     @foreach($listClientes as $cliente)
                                         
                                        @if($cliente->idempresa==$empresa->id)
                                         <tr >
                                             <td>{{$cliente->nombre}} {{$cliente->apellido}}</td>
                                           
                                             <td>
                                             @foreach( $cliente->ListAlimentosNoMeGusta as $alimento)
                                             {{$alimento->nombre}} -
                                             @endforeach
                                             </td>

                                             <!--<td>
                                             @foreach( $cliente->ListDiasDeLaSemana as $dia)
                                             Requiere el dia: {{$dia->nombre}} -  
                                             @endforeach
                                             </td>
                                            -->

                                             <td>{{$cliente->domicilio}}</td>
                                             <td>{{$cliente->telefono}}</td>
                                             <td>{{$cliente->email}}</td>
                                            
                                             <td><a href="clientes/{{$cliente->id}}" class=" btn btn-xs btn-success color-palette" title="Viandas"><i class="fa fa-leaf"></i> </a></td>
                                             
                                             <td><a href="clientes/nomegusta/{{$cliente->id}}"  class=" btn btn-xs bg-black-active color-palette" title="Alimentos No me Gusta"><i class="fa fa-thumbs-down"></i> <i class="fa fa-lemon-o"></i></a></td>
                                             <td><a href="clientes/{{$cliente->id}}/edit"  class="btn btn-xs btn-info editar" data-idcliente="{{$cliente->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                             <td><a href="#" class="btn btn-xs btn-warning baja" data-idcliente="{{$cliente->id}}"  title="Dar de Baja"><i class="fa fa-thumbs-down"></i></a></td>
                                             <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idcliente="{{$cliente->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                                         </tr>

                                         @endif

                                     @endforeach
                                 </table>
                             </div>
                            


                         </div>

                     </div>

                @endforeach

                <div class=" panel panel-success">
                         <div class=" panel-heading"> 
                              Sin Empresa                           
                         </div>
                         <div class="panel-body">


                             <div class="table-responsive">
                                 <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                                     <tr>
                                         <th>Nombre</th>
                                         
                                         <th>No le Gusta</th>
                                         <th>Domicilio</th>
                                         <th>Telefono</th>
                                         <th>Email</th>
                                         
                                     </tr>
                                     @foreach($listClientes as $cliente)
                                         
                                        @if($cliente->idempresa==null)
                                         <tr >
                                             <td>{{$cliente->nombre}} {{$cliente->apellido}}</td>
                                             
                                             <td>
                                             @foreach( $cliente->ListAlimentosNoMeGusta as $alimento)
                                             {{$alimento->nombre}} -
                                             @endforeach
                                             </td>

                                             <!--<td>
                                             @foreach( $cliente->ListDiasDeLaSemana as $dia)
                                             Requiere el dia: {{$dia->nombre}} -  
                                             @endforeach
                                             </td>
                                            -->

                                             <td>{{$cliente->domicilio}}</td>
                                             <td>{{$cliente->telefono}}</td>
                                             <td>{{$cliente->email}}</td>
                                             
                                             <td><a href="clientes/{{$cliente->id}}" class=" btn btn-xs btn-success color-palette" title="Viandas"><i class="fa fa-leaf"></i> </a></td>
                                             
                                             <td><a href="clientes/nomegusta/{{$cliente->id}}"  class=" btn btn-xs bg-black-active color-palette" title="Alimentos No me Gusta"><i class="fa fa-thumbs-down"></i> <i class="fa fa-lemon-o"></i></a></td>
                                             <td><a href="clientes/{{$cliente->id}}/edit"  class="btn btn-xs btn-info editar" data-idcliente="{{$cliente->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                             <td><a href="#" class="btn btn-xs btn-warning baja" data-idcliente="{{$cliente->id}}"  title="Dar de Baja"><i class="fa fa-thumbs-down"></i></a></td>
                                             <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idcliente="{{$cliente->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                                         </tr>

                                         @endif
                                         
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
                 {!!Form::open(['route'=>['admin.clientes.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Cliente</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el Cliente? NO lo podra recuperar perdera todos sus datos y su historia</h3>
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
                {!!Form::open(['url'=>['admin/clientes/baja'],'method'=>'POST'])!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Dando de Baja Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::Text('id',null,['class'=>'hidden','id'=>'idB'])!!}
                            <h3>¿Desea dar de baja un cliente?</h3>
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

