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
     <div class=" box box-primary">
        <div class="box-header with-border">
                <i class="fa fa-leaf"></i>  Empresa: {{$emp->Empresa->nombre}} :: Envio {!!Form::checkbox('pedEmp['.$cpe.'][envio]', $emp->id, $emp->envio,['class'=>''])!!} <br>
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
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon" title="Cantidad">{{$lp->TipoVianda->nombre}} </span>
                                        {!!Form::Number('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][tipo_vianda_id]',$lp->tipo_vianda_id,['class'=>' form-control hidden'])!!}
                                        {!!Form::Number('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][cantidad]',$lp->cantidad,['class'=>' form-control cantidad-pedido', 'data-precio'=> $lp->TipoVianda->precio,'required||between:0,999.99'])!!}
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
                                {!!Form::checkbox('pedEmp['.$cpe.'][ped]['.$cpep.'][linea]['.$contadorLinea.'][confirmado]',1 , true)!!}
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
<div class=" box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-leaf"></i>  Sin Empresa
    </div>
    <div class="box-body">
        @foreach($listPedidosClientes as $p)
        {!!Form::Text('pedCli['.$cpc.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
           {!!Form::Text('pedCli['.$cpc.'][cliente_id]', $p->cliente_id,['class'=>'hidden'])!!}
            <div class="row">
                <div class="col-md-4">
                    {{$p->Cliente->nombre }} {{$p->Cliente->apellido}} :: Envio {!!Form::checkbox('pedCli['.$cpc.'][envio]', $p->Cliente->envio, $p->Cliente->envio,['class'=>''])!!}
                </div>
                <div class="col-md-8">
                    <?php $contadorLinea=0 ?>
                    @foreach($p->ListLineasPedido as $lp)
                        <div class="row">
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
                            {!!Form::checkbox('pedCli['.$cpc.'][linea]['.$contadorLinea.'][confirmado]',1 , true)!!}
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


