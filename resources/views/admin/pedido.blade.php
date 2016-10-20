@extends('admin.masteradmin')

@section('title')
    <h1>Agregando Pedido</h1>
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
            {!!Form::open(['url'=>'admin/pedidos/agregarPedidoManual','method'=>'POST', 'data-toggle'=>'validator'])!!}
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
                        <div class="col-md-2">
                            Fecha
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                <input class="form-control datepicker" name="fecha_pedido" id="txtfecha" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" value="{{\Carbon\Carbon::now('America/Argentina/Buenos_Aires')->format('d/m/Y')}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            Cliente
                            <div class="input-group ">
                                <span class="input-group-addon" title="Comience a escribir el apellido del cliente"> <i class="fa fa-user"></i></span>
                                {!!Form::text('cliente', '', array('id' => 'auto', 'class'=>'form-control'))!!}
                                {!!Form::text('cliente_id', '', array('id' =>'response', 'style'=>'display:none'))!!}
                            </div>

                        </div>
                        <div class="col-md-2">
                            Cantidad
                            {!!Form::Number('cantidad', '1',['class' => 'form-control','required|between:0,99.99','id'=>'txt-vianda-cantidad'])!!}
                        </div>
                        <div class="col-md-3">
                            Tipo Vianda
                            <div class="input-group ">
                                <span class="input-group-addon" title="Tipo Vianda"> <i class="fa fa-user"></i></span>
                                <select name="tipo_vianda_id" class="form-control" id="cbx-tipo-vianda"  required>
                                    <option value="0" data-precio="0">Seleccionar</option>
                                    @foreach($listTipoViandas as $tv)
                                        <option value="{{$tv->id}}" data-precio="{{$tv->precio}}">{{$tv->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            Precio Vianda
                            <div class="input-group ">
                                <span class="input-group-addon" title="Precio Vianda"> $</span>
                                {!!Form::Number('precio_vianda',0,['class'=>' form-control ','required||between:0,99.99','id'=>'txt-precio-vianda'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Envio
                            <div class="input-group ">
                                <span class="input-group-addon" title="¿Desea Envio?"><i class="fa fa-motorcycle"></i></span>
                                {!!Form::checkbox('envio', '', false ,['class'=>'','id'=>'chk-envio'])!!}
                            </div>
                        </div>
                        <div class="col-md-3 envio hidden">
                            Cadete
                            <div class="input-group">
                                <span class="input-group-addon"title="Cadete"><i class="fa fa-motorcycle"></i>:</span>
                                {!!Form::select('cadete_id', $listCadetes,null,array('class' => 'form-control viandas-cadete-empresa'))!!}
                            </div>
                        </div>
                        <div class="col-md-2 envio hidden">
                            Precio Envio
                            <div class="input-group ">
                                <span class="input-group-addon" title="Costo Envio"> $</span>
                                {!!Form::Number('precio_envio',0,['class'=>' form-control ','required|between:0,99.99','id'=>'txt-precio-envio'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            Observaciones
                            {!!Form::text('observaciones', '', array('class'=>'form-control'))!!}
                        </div>
                        <div class="col-md-3">
                            <strong>Total</strong>
                            <div class="form-group has-success">
                                <div class="input-group ">
                                    <span class="input-group-addon" title="Total"> $</span>
                                    {!!Form::Number('total',0,['class'=>' form-control ','required||between:0,99.99','id'=>'txt-total'])!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::submit('Agregar', array('class' => 'btn btn-success btn-block'))!!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('script')
    <script>
        function sumar(n1, n2) {
            return (parseInt(n1) + parseInt(n2));
        }
        $(function () {
            ///para cambiar los valores de precio pedido segun tipo Vianda
            $("#cbx-tipo-vianda").change(function() {
                var precio=$("#cbx-tipo-vianda option:selected").attr('data-precio');
                $('#txt-precio-vianda').val(precio);
                var total = sumar((precio * $("#txt-vianda-cantidad").val()), $("#txt-precio-envio").val());
                $('#txt-total').val(total);

            });
            /// para multiplicar la cantidad por el precio
            $( "#txt-vianda-cantidad" ).change(function() {
                var precio = $("#cbx-tipo-vianda option:selected").attr('data-precio');
                $('#txt-precio-vianda').val(precio);
                var total = sumar((precio * $("#txt-vianda-cantidad").val()), $("#txt-precio-envio").val());
                $('#txt-total').val(total);
            });

            $( "#txt-precio-envio" ).change(function() {
                var precio = $("#cbx-tipo-vianda option:selected").attr('data-precio');
                var total = sumar((precio * $("#txt-vianda-cantidad").val()), $("#txt-precio-envio").val());
                $('#txt-total').val(total);
            });

            ///cambio segun tengo envio o no
            $("#chk-envio").click(function() {
                $('.envio').toggleClass('hidden');
                if($("#chk-envio").prop('checked')){}
                else {
                    $("#txt-precio-envio").val(0);
                    var precio = $("#cbx-tipo-vianda option:selected").attr('data-precio');
                    var total = sumar((precio * $("#txt-vianda-cantidad").val()), $("#txt-precio-envio").val());
                    $('#txt-total').val(total);
                }

            });

            $("#auto").autocomplete({
                source: "../clientes/like/like",
                minLength: 2,
                select: function( event, ui ) {
                    $('#response').val(ui.item.id);
                }
            });

        });
    </script>
@endsection