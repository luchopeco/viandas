@extends('admin.masteradmin')

@section('title')
    <h1>Editando Pedido</h1>
@endsection

@section('breadcrumb')
    <li><a href="/admin/home"><i class="fa fa-home"></i> Home</a> / <a href="/admin/pedido/gestion"><i class="fa fa-shopping-cart"></i> Pedidos</a> </li>
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
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{$pedido->Cliente->apellido}}, {{$pedido->Cliente->nombre}} <small> Editando Pendido</small> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!!Form::open(['route'=>['admin.pedidos.update'],'method'=>'PUT'])!!}
                            <input name="id" class="form-control hidden "   type="text" value="{{$pedido->id}}">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h4>Cabecera Pedido</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Fecha Pedido
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input class="form-control " disabled data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{$pedido->fecha_pedido}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            Total
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    $
                                                </div>
                                                <input class="form-control " disabled  type="text" value="{{$pedido->total}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Observaciones
                                            <textarea name="observaciones" class="form-control " type="text">{{$pedido->observaciones}}</textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Envio
                                                </div>
                                                <input type="checkbox" name="envio" id="cbx-envio" class="" @if($pedido->envio==1) checked @endif >
                                            </div>
                                        </div>
                                        <div class="col-md-6 @if($pedido->envio !=1) hidden @endif ">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-motorcycle"></i>
                                                </div>
                                                {!!Form::select('cadete_id', $listCadetes,$pedido->cadete_id,array('class' => 'form-control '))!!}
                                            </div>
                                        </div>
                                        <div class="col-md-4 @if($pedido->envio !=1) hidden @endif">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    $
                                                </div>
                                                <input class="form-control " name="precio_envio"  type="text" value="{{$pedido->precio_envio}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    {!!Form::submit('Modificar Cabecera', array('class' => 'btn btn-success form-control'))!!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h4>Linea Pedido <a class="btn-success btn-xs btn" title="Nueva LineaPedido" data-toggle="modal" data-target="#modalLpAgregar"> <i class="fa fa-plus"></i></a></h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Pedido</th>
                                                        <th>Subtotal</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($pedido->ListLineasPedido as $lp)
                                                        <tr>
                                                            <td>{{$lp->cantidad}} {{$lp->TipoVianda->nombre}}</td>
                                                            <td>$ {{$lp->cantidad * $lp->precio_vianda}}</td>
                                                            <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idlp="{{$lp->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLpEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!!Form::open(['url'=>['/admin/pedidos/eliminarlinea'],'method'=>'POST'])!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminando LineaPedido</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::Text('id',null,['class'=>'hidden','id'=>'idD'])!!}
                            <h3>¿Desea Eliminar la Linea Selecccionada?</h3>
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

    <div class="modal fade" id="modalLpAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!!Form::open(['url'=>['/admin/pedidos/agregarlinea'],'method'=>'POST', 'data-toggle='>'validator'])!!}
                <input name="pedido_id" class="form-control hidden "   type="text" value="{{$pedido->id}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Agregando Linea Pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            Cantidad
                            {!!Form::Number('cantidad', '1',['class' => 'form-control','required|between:0,99.99','id'=>'txt-cantidad-vianda'])!!}
                        </div>
                        <div class="col-md-4">
                            Tipo Vianda
                            <div class="input-group ">
                                <span class="input-group-addon" title="Tipo Vianda"><i class="fa fa-leaf"></i></span>
                                <select name="tipo_vianda_id" class="form-control" id="cbx-tipo-vianda"  required>
                                    <option value="" data-precio="0" required>Seleccionar</option>
                                    @foreach($listTipoViandas as $tv)
                                        <option value="{{$tv->id}}" data-precio="{{$tv->precio}}">{{$tv->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            Precio Vianda
                            <div class="input-group ">
                                <span class="input-group-addon" title="Precio Vianda"> $</span>
                                {!!Form::Number('precio_vianda',0,['class'=>' form-control ','required||between:0,99.99','id'=>'txt-precio-vianda'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row ">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                {!!Form::submit('Agregar', array('class' => 'btn btn-success'))!!}
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
            ///para esconder lo referente a envio segun si desea realizar o no envio
            $("#cbx-envio").click(function() {
                $(this).closest('.row').find('.col-md-4').toggleClass('hidden');
                $(this).closest('.row').find('.col-md-6').toggleClass('hidden');

            });
            $('body').on('click', '.eliminar', function (event) {
                event.preventDefault();
                var id_alimento=$(this).attr('data-idlp');
                $("#idD").val(id_alimento);
                $("#modalLpEliminar").modal("show");
            });
            ///para cambiar los valores de precio pedido segun tipo Vianda
            $("#cbx-tipo-vianda").change(function() {
                var precio=$("#cbx-tipo-vianda option:selected").attr('data-precio') * $("#txt-cantidad-vianda").val();
                $('#txt-precio-vianda').val(precio);
            });
            /// para multiplicar la cantidad por el precio
            $( "#txt-cantidad-vianda" ).change(function() {
                var precio = $("#cbx-tipo-vianda option:selected").attr('data-precio') * $("#txt-cantidad-vianda").val();
                $('#txt-precio-vianda').val(precio);
            });
        });
    </script>
@endsection