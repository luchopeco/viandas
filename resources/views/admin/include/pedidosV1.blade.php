<div class="row">
    <div class="col-md-6">
        <div class="callout callout-info">
            <h4>{{$cantidadTotal}} Pedidos en Total</h4>
        </div>
    </div>
</div>
{!!Form::open(['route'=>'admin.pedidos.store','method'=>'POST', 'data-toggle'=>'validator'])!!}
<?php
//contador Pedido Empresa
$cpe =0;
$cpep=0;
$cpc=0;
?>
 @foreach($listPedidosEmpresa as $emp)
  {!!Form::Text('pedEmp['.$cpe.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
  {!!Form::Text('pedEmp['.$cpe.'][empresa_id]', $emp->Empresa->id ,['class'=>'hidden'])!!}
     <div class=" box box-primary agrupacion-pedidos">
        <div class="box-header with-border">
            <div class="row agrupacion-envio">
                <div class="col-md-3">
                    <i class="fa fa-leaf"></i>  Empresa: {{$emp->Empresa->nombre}} <span class="label label-success">{{$emp->ListPedidos->count()}} Pedidos</span>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">Envio</span>
                        {!!Form::checkbox('pedEmp['.$cpe.'][envio]', $emp->id, $emp->envio,['class'=>'cbx-envio'])!!}
                    </div>
                </div>

                <div class="col-md-2 precio-envio-pedido @if($emp->envio==0) hidden  @endif">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        {!!Form::Number('pedEmp['.$cpe.'][precio_envio]',$emp->precio_envio,['class'=>'form-control '])!!}
                    </div>
                </div>

                <div class="col-md-2 cadete-pedido @if($emp->envio==0) hidden  @endif">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-motorcycle"></i></span>
                        {!!Form::select('pedEmp['.$cpe.'][cadete_id]', $listCadetes,null,array('class' => 'form-control '))!!}
                    </div>
                </div>
                <div class="col-md-2" title="Confirma todos o ninguno de los pedidos de la empresa">
                    <div class="input-group">
                        <span class="input-group-addon">Marcar Todos</span>
                        {!!Form::checkbox('todos', $emp->id, true ,['class'=>'cbx-todos'])!!}
                    </div>
                </div>

            </div>

        </div>
        <div class="box-body">
            <div class="row">
                 @foreach($emp->ListPedidos as $p)
                   {!!Form::Text('pedEmp['.$cpe.'][ped]['.$cpep.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
                   {!!Form::Text('pedEmp['.$cpe.'][ped]['.$cpep.'][cliente_id]', $p->cliente_id,['class'=>'hidden'])!!}
                 <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            {{$p->Cliente->nombre }} {{$p->Cliente->apellido}}
                        </div>
                        <div class="col-md-8">
                            <?php $contadorLinea=0 ?>
                            @foreach($p->ListLineasPedido as $lp)
                            <div class="row tabla-pedidos-padre">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon" title="Cantidad">{{$lp->TipoVianda->nombre}} </span>
                                        {!!Form::Number('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][tipo_vianda_id]',$lp->tipo_vianda_id,['class'=>' form-control hidden'])!!}
                                        {!!Form::Number('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][cantidad]',$lp->cantidad,['class'=>' form-control cantidad-pedido', 'data-precio'=> $emp->Empresa->getPrecioVianda($lp->tipo_vianda_id),'required||between:0,999.99'])!!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon" title="Precio">$</span>
                                        <?php $subtotal = $lp->cantidad * $emp->Empresa->getPrecioVianda($lp->tipo_vianda_id); ?>
                                        {!!Form::Number('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][precio_vianda]',$subtotal,['class'=>' form-control precio-pedido','required|between:0,999.99'])!!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                {!!Form::checkbox('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][confirmado]',1 , true,['class'=>'cbx-confirmar'])!!}
                                </div>
                            </div>
                            <?php $contadorLinea++ ?>
                            @endforeach

                        </div>
                    </div>
                 </div>
                 <?php $cpep++; ?>
                 @endforeach
              </div>
        </div>
     </div>
   <?php $cpe = $cpe+1; ?>
 @endforeach
<hr>
<div class=" box box-primary agrupacion-pedidos">
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-9">
                <i class="fa fa-leaf"></i>  Sin Empresa <span class="label label-success">{{$listPedidosClientes->count()}} Pedidos</span>
            </div>
            <div class="col-md-3" title="Confirma todos o ninguno de los pedidos de la empresa">
                <div class="input-group">
                    <span class="input-group-addon">Marcar Todos</span>
                    {!!Form::checkbox('todos', 1, true ,['class'=>'cbx-todos'])!!}
                </div>
            </div>
        </div>

    </div>
    <div class="box-body">
        @foreach($listPedidosClientes as $p)
        {!!Form::Text('pedCli['.$cpc.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
           {!!Form::Text('pedCli['.$cpc.'][cliente_id]', $p->cliente_id,['class'=>'hidden'])!!}
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-3">{{$p->Cliente->nombre }} {{$p->Cliente->apellido}}</div>
                        <div class="col-md-9">
                            <div class="row agrupacion-envio">
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">Envio</span>
                                        {!!Form::checkbox('pedCli['.$cpc.'][envio]', $p->Cliente->envio, $p->Cliente->envio,['class'=>'cbx-envio'])!!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group precio-envio-pedido @if($p->Cliente->envio==0) hidden  @endif">
                                        <span class="input-group-addon">$</span>
                                        {!!Form::Number('pedCli['.$cpc.'][precio_envio]',$p->Cliente->Localidad->costo_envio,['class'=>'form-control '])!!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group cadete-pedido @if($p->Cliente->envio==0) hidden  @endif">
                                        <span class="input-group-addon"><i class="fa fa-motorcycle"></i></span>
                                        {!!Form::select('pedCli['.$cpc.'][cadete_id]', $listCadetes,null,array('class' => 'form-control '))!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php $contadorLinea=0 ?>
                    @foreach($p->ListLineasPedido as $lp)
                        <div class="row tabla-pedidos-padre">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon" title="Cantidad">{{$lp->TipoVianda->nombre}} </span>
                                    {!!Form::Number('pedCli['.$cpc.'][linea]['.$contadorLinea.'][tipo_vianda_id]',$lp->tipo_vianda_id,['class'=>' form-control hidden'])!!}
                                    {!!Form::Number('pedCli['.$cpc.'][linea]['.$contadorLinea.'][cantidad]',$lp->cantidad,['class'=>' form-control cantidad-pedido', 'data-precio'=> $lp->TipoVianda->precio,'required||between:0,999.99'])!!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon" title="Precio">$</span>
                                    <?php $subtotal = $lp->cantidad * $lp->TipoVianda->precio; ?>
                                    {!!Form::Number('pedCli['.$cpc.'][linea]['.$contadorLinea.'][precio_vianda]',$subtotal,['class'=>' form-control precio-pedido','required|between:0,999.99'])!!}
                                </div>
                            </div>
                            <div class="col-md-2">
                            {!!Form::checkbox('pedCli['.$cpc.'][linea]['.$contadorLinea.'][confirmado]',1 , true,['class'=>'cbx-confirmar'])!!}
                            </div>
                        </div>
                        <?php $contadorLinea++ ?>
                    @endforeach
                </div>
            </div>
            <?php $cpc++ ?>
            <hr>
       @endforeach
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    {!!Form::submit('Aceptar', array('class' => 'btn btn-success btn-block'))!!}
    </div>
</div>
{!! Form::close() !!}


<script>

$(function () {

    /// para multiplicar la cantidad por el precio
    $( ".cantidad-pedido" ).change(function() {
       var precio_actual= $(this).attr('data-precio');
       var precio = $(this).val() * precio_actual;
       $(this).closest('.tabla-pedidos-padre').find('.precio-pedido').val(precio);
    });
    ///para esconder lo referente a envio segun si desea realizar o no envio
     $(".cbx-envio").click(function() {
        $(this).closest('.agrupacion-envio').find('.cadete-pedido').toggleClass('hidden');
        $(this).closest('.agrupacion-envio').find('.precio-envio-pedido').toggleClass('hidden');
        });
     //para confirmar todos los pedidos
     $(".cbx-todos").click(function() {
        var $caca = $(this).closest('.agrupacion-pedidos').find('.cbx-confirmar');
        $caca.prop("checked", !$caca.prop("checked"));
        });


});
</script>
