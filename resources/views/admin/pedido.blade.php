@extends('admin.masteradmin')

@section('title')
<h1>Nuevo Pedidos</h1>
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
                   <div class=" panel-heading">Nuevo Pedido Manual
                      <div class="pull-right">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-question-circle"></i><span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu pull-right" role="menu">
                                  <li>Desde aqui puede agregar un pedido manual.</li>
                                  <li>Una Vez agregado el pedido queda registrado sin cobrar</li>
                              </ul>
                          </div>
                       </div>
                   </div>
                   <div class=" panel-body">
                        <div class="row">
                            <div class="col-md-6">
                            Cliente
                                <div class="input-group ">
                                    <span class="input-group-addon" title="Cliente"> <i class="fa fa-user"></i></span>
                                   {!!Form::select('cliente_id', $listClientes,null,array('class' => 'form-control'))!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                            Tipo Vianda
                            <div class="input-group ">
                                <span class="input-group-addon" title="Tipo Vianda"> <i class="fa fa-user"></i></span>
                               {!!Form::select('tipo_vianda_id', $listTipoViandas,null,array('class' => 'form-control'))!!}
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Empresa
                                <div class="input-group ">
                                    <span class="input-group-addon" title="¿Desea Envio?"><i class="fa fa-motorcycle"></i></span>
                                     {!!Form::Text('empresa_id', '',['class'=>' hidden','disabled '])!!}
                                    {!!Form::Text('empresa', '',['class'=>' form-control','disabled'])!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                Cantidad
                                {!!Form::Text('cantidad', '1',['class' => 'form-control','required|between:0,99.99'])!!}
                            </div>
                            <div class="col-md-4">
                                Envio
                             <div class="input-group ">
                                <span class="input-group-addon" title="¿Desea Envio?"><i class="fa fa-motorcycle"></i></span>
                                {!!Form::checkbox('envio', '', false ,['class'=>''])!!}
                            </div>
                            </div>
                        </div>
                   </div>
              </div>
       </div>
   </div>
@endsection

@section('script')
<script>
$(function () {


});
</script>
@endsection