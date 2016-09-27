
<?php
//contador Pedido Empresa
$cpe =0;
?>
 @foreach($listPedidosEmpresa as $emp)
 {!!Form::Text('pedEmp['.$cpe.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
 {!!Form::Text('pedEmp['.$cpe.'][empresa_id]', $emp->Empresa->id ,['class'=>'hidden'])!!}
   Empresa: {{$emp->Empresa->nombre}} :: Envio {!!Form::checkbox('pedEmp['.$cpe.'][envio]', $emp->id, $emp->envio,['class'=>''])!!} <br>
   -----------------------------------<br>
   @foreach($emp->ListPedidos as $p)
    Cliente: {{$p->Cliente->nombre }} {{$p->Cliente->apellido}}.<br>
    Pedidos:
    @foreach($p->ListLineasPedido as $lp)
       {{$lp->cantidad}} {{$lp->TipoVianda->nombre}} <br>
    @endforeach
    ---------<br>
   @endforeach
   <?php $cpe = $cpe+1; ?>
 @endforeach
----------------------------------<br>
Pedidos Sin Empresa:-----------<br>
@foreach($listPedidosClientes as $p)
    Cliente: {{$p->Cliente->nombre }} {{$p->Cliente->apellido}}.<br>
    Pedidos:
    @foreach($p->ListLineasPedido as $lp)
       {{$lp->cantidad}} {{$lp->TipoVianda->nombre}} ::
    @endforeach
    <br>---------<br>
   @endforeach


