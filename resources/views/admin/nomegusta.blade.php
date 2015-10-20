@extends('admin.masterAdmin')

@section('title')
<h1><i class="fa fa-user"></i> {{$cliente->nombre}} {{$cliente->apellido}}<small>Alimentos que NO le gustan </small></h1>
@endsection

@section('breadcrumb')
<li><a href="/admin/home"><i class="fa fa-home"></i> Home</a> / <a href="/admin/home"><i class="fa fa-user"></i> Cliente</a> </li>
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
               <div class=" panel-heading"> Alimentos que No le Gustan
                   <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="multiselect dropdown-toggle btn btn-xs btn-warning" data-toggle="dropdown" title="Ayuda">
                               <i class="fa fa-question-circle"></i><b class="caret"></b>
                           </button>
                           <ul class="multiselect-container dropdown-menu pull-right">
                               <li>Desde Aqui Puede Agregar (Click en "+"), editar o eliminar un los alimentos que no le gustan a un cliente</li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class=" panel-body">
                    {!!Form::open(['url'=>'admin/clientes/nomegustaagregar','method'=>'POST'])!!}
                    {!!Form::Text('id',$cliente->id,['class'=>' hidden'])!!}
                    <div class="row">
                    @foreach($listTiposAlimentos as $tipoAlimento)
                        <div class="col-md-4">
                            <div class=" panel panel-default">
                                <div class=" panel-heading">
                                {{$tipoAlimento->nombre}}
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        @foreach($tipoAlimento->ListAlimentos as $alimento)
                                        <?php $desc ='nmg-'.$alimento->id; ?>
                                        <div class="col-md-12">
                                            <p>
                                                <?php $aux = 0; ?>
                                                @foreach($cliente->ListAlimentosNoMeGusta as $nomegusta)
                                                     @if($nomegusta->id == $alimento->id)
                                                        {!!Form::checkbox($desc, $alimento->id, true)!!}
                                                        <?php $aux = 1; ?>
                                                     @endif
                                                @endforeach
                                                @if($aux == 0)
                                                {!!Form::checkbox($desc, $alimento->id)!!}
                                                @endif
                                                {{$alimento->nombre}}
                                            </p>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::submit('Aceptar', array('class' => 'btn btn-success btn-block'))!!}
                        </div>
                    </div>
                    {!! Form::close() !!}
               </div>
          </div>
       </div>
   </div>


    <div class="modal fade" id="modalClienteEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 {!!Form::open(['route'=>['admin.alimentos.destroy'],'method'=>'DELETE'])!!}
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title" id="myModalLabel">Eliminando Alimento</h4>
                   </div>
                   <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                   {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                                   <h3>¿Desea Eliminar el Alimento?</h3>
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
            var id_cliente=$(this).attr('data-idcliente');
            $("#idD").val(id_alimento);
            $("#modalClienteEliminar").modal("show");
        });

    });

</script>
@endsection

