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
               <div class=" panel-heading">
                              
                @if ($cliente->id==null) 
                  Nuevo Cliente
                @else
                  Modificar Cliente
                @endif    

               </div>
               <div class=" panel-body">

                  <form action="validarCliente" id="formularioCliente">   
                  
                  <input type="hidden" name="accion" value="{{$cliente->id}}">
                           
                         <div class="modal-body">
                          <div class=" panel panel-default">
                            <div class=" panel-heading">Cliente</div>
                              <div class=" panel-body">
                                   <div clas="row">
                                       <div class="col-md-12">
                                           <div class="form-group">
                                              {!!Form::label('nombre','Nombre')!!}
                                              {!!Form::Text('nombre',$cliente->nombre,['class'=>' form-control','required'])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('apellido','Apellido')!!}
                                              {!!Form::Text('apellido',$cliente->apellido,['class'=>' form-control','required'])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('telefono','Teléfono')!!}
                                              {!!Form::Text('telefono',$cliente->telefono,['class'=>' form-control','required'])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('dni','DNI')!!}
                                              {!!Form::Text('dni',$cliente->dni,['class'=>' form-control','required'])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('domicilio','Domicilio')!!}
                                              {!!Form::Text('domicilio',$cliente->domicilio,['class'=>' form-control','required'])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('email','Email')!!}
                                              {!!Form::Text('email',$cliente->email,['class'=>' form-control','required'])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                                                               
                                       </div>
                                   </div>
                                </div>
                           </div>
                      </div>

                   
                        <div class=" panel panel-default">
                            <div class=" panel-heading">Días de la semana</div>
                              <div class=" panel-body">
                                   <div clas="row">
                                       <div class="col-md-12">
                                          
                                          <table class="table">
                                                                                      

                                          <?php

                                          foreach ($diasdelas as $dia) {
                                            ?>
                                              <tr>
                                               <td><input type="checkbox" name="{{$dia->id}}"></input></td>

                                              <td><?php echo $dia->nombre; ?></td>                                             
                                              
                                              <td>Tipo de Viandas: <select>
                                              <?php foreach ($tipos as $tipo) {
                                                echo '<option  >'.$tipo->nombre.'</option>';
                                              } ?></select></td>

                                              <td>Cantidad de viandas: <input type="text"></input> </td>
                                              
                                              <td>Envío: <input type="checkbox"></input> </td>
                                             
                                              
                                              
                                            </tr>


                                            <?php
                                                                
                                          }

                                          ?>

                                          </table>
                                                                               
                                       </div>
                                   </div>
                                </div>
                           </div>



                     
                  






                         <div class="modal-footer">
                             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                             {!!Form::submit('Aceptar', array('class' => 'btn btn-success'))!!}
                         </div>
                  
                    
                  </form>

                 






<?php /*
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <tr>
                               <th>Nombre</th>
                               <th>DNI</th>
                               <th>No le Gusta</th>
                               <th>Domicilio</th>
                               <th>Telefono</th>
                               <th>Email</th>
                               <th>Estado Deuda</th>
                           </tr>
                       
                               <tr >
                                   <td>{{$cliente->nombre}} {{$cliente->apellido}}</td>
                                   <td>{{$cliente->dni}}</td>
                                  

                                   <td>
                                   @foreach( $cliente->ListDiasDeLaSemana as $dia)
                                   Requiere el dia: {{$dia->nombre}} -  
                                   @endforeach
                                   </td>


                                   <td>{{$cliente->domicilio}}</td>
                                   <td>{{$cliente->telefono}}</td>
                                   <td>{{$cliente->email}}</td>
                                   <td>{{$cliente->estado_deuda}}</td>
                                   <td><a href="clientes/nomegusta/{{$cliente->id}}"  class=" btn btn-xs bg-black-active color-palette" title="Alimentos No me Gusta"><i class="fa fa-thumbs-down"></i> <i class="fa fa-lemon-o"></i></a></td>
                                   <td><a href="#"  class="btn btn-xs btn-info editar" data-idcliente="{{$cliente->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                   <td><a href="#" class="btn btn-xs btn-warning baja" data-idcliente="{{$cliente->id}}"  title="Dar de Baja"><i class="fa fa-thumbs-down"></i></a></td>
                                   <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idcliente="{{$cliente->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                               </tr>
                        
                       </table>
                   </div>

                   */ ?>
               </div>
          </div>
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

