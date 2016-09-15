@extends('admin.masteradmin')

@section('title')
<h1> Gestión de Clientes</h1>
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
               <div class=" panel-heading">
                
               <div class="panel-body">



                    <?php 
                    $action = '';
                    if(Route::current()->getName()=='admin.clientes.create'){
                     
                      ?>
                      {!!Form::open(['route'=>'admin.clientes.store','method'=>'POST', 'data-toggle='>'validator'])!!}
                    <?php
                    }
                    else{
                       ?>
                      {!!Form::open(['route'=>'admin.clientes.update','method'=>'PUT', 'data-toggle='>'validator'])!!}
                    <?php               
                    }
                    ?>           
                 
                  
                  <input type="hidden" name="id" value="{{$cliente->id}}">
                           
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
                                              {!!Form::Text('telefono',$cliente->telefono,['class'=>' form-control',''])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('dni','DNI')!!}
                                              {!!Form::Text('dni',$cliente->dni,['class'=>' form-control',''])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>
                                           <div class="form-group">
                                              {!!Form::label('domicilio','Domicilio')!!}
                                              {!!Form::Text('domicilio',$cliente->domicilio,['class'=>' form-control',''])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>

                                          <div class="form-group">
                                              {!!Form::label('localidad','Localidad')!!}

                                              <select class="form-control" name="idlocalidad" id="localidad">
                                                 
                                               <?php foreach ($localidades as $localidad) {                                               
                                                 ?> 
                                                       <option value="<?php echo $localidad->id; ?>"
                                                       <?php if($cliente->idlocalidad==$localidad->id){echo 'selected="selected"';} ?> ><?php echo $localidad->nombre; ?>
                                                       </option>
                                              <?php  } ?>
                                             </select>
                                             
                                              <span class="help-block with-errors"></span>
                                           </div> 

                                           <div class="form-group">
                                              {!!Form::label('email','Email')!!}
                                              {!!Form::Text('email',$cliente->email,['class'=>' form-control',''])!!}
                                              <span class="help-block with-errors"></span>
                                           </div>

                                           <div class="form-group">
                                              {!!Form::label('empresa','Empresa')!!}

                                              <select class="form-control" name="idempresa" id="empresa" onchange="cambiaEmpresa();">
                                                 <option value="0" <?php if($cliente->idempresa==null){echo 'selected="selected"';} ?> >NINGUNA</option>
                                               <?php foreach ($empresas as $empresa) {                                               
                                                 ?> 
                                                       <option value="<?php echo $empresa->id; ?>"
                                                       <?php if($cliente->idempresa==$empresa->id){echo 'selected="selected"';} ?> ><?php echo $empresa->nombre; ?>
                                                       </option>
                                              <?php  } ?>
                                             </select>
                                             
                                              <span class="help-block with-errors"></span>
                                           </div>

                                            <div class="form-group enviocliente">
                                              {!!Form::label('envio','Envío a domicilio ?')!!}

                                              <div class="form-group checkbox">
                                                <label>
                                                <input name="envio" value="1" type="checkbox" <?php if($cliente->envio == 1){echo 'checked="checked"';} ?> >Envío</label>
                                              </div>
                                           
                                             
                                              <span class="help-block with-errors"></span>
                                           </div>


                                            <div class="form-group">
                                              {!!Form::label('cadete','Cadete')!!}

                                              <select class="form-control" name="idcadete" id="cadete" >
                                                 <option value="0" <?php if($cliente->idcadete==null){echo 'selected="selected"';} ?> >NINGUNO</option>
                                               <?php foreach ($cadetes as $cadete) {                                               
                                                 ?> 
                                                       <option value="<?php echo $cadete->id; ?>"
                                                       <?php if($cliente->idcadete==$cadete->id){echo 'selected="selected"';} ?> ><?php echo $cadete->nombre.' '.$cadete->apellido; ?>
                                                       </option>
                                              <?php  } ?>
                                             </select>
                                             
                                              <span class="help-block with-errors"></span>
                                           </div>

                                           
                                                                               
                                       </div>
                                   </div>
                                </div>
                           </div>
                      </div>
    
    
                


                         <div class="modal-footer">
                             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                             {!!Form::submit('Aceptar', array('class' => 'btn btn-success'))!!}
                         </div>
                  
                    
                  {!! Form::close() !!}

                 






<?php /*
                   

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

<script>
        $(document).ready(function(){
          
          if($('#empresa').val()==0){
            $('.enviocliente').show();
          }
          else{
            $('.enviocliente').hide();
          }

        });

        function cambiaEmpresa(){

          if($('#empresa').val()==0){
            $('.enviocliente').show();
          }else{
            $('.enviocliente').hide();
          }

        }
    </script>
@endsection

