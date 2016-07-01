{!!Form::open(['route'=>'admin.pedidos.store','method'=>'POST', 'data-toggle'=>'validator'])!!}
<?php $contador=0; ?>
<?php $contadorR=0; ?>
<div class="row pedido-ajax">
    <div class="col-md-12">
        <div class=" box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-leaf"></i> Pedidos Sin Registrar
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-question-circle"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>Pedidos que se deben confirmar. Estos Vienen por la configuracion del cliente</li>
                                <li></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box-body">
                @foreach($listEmpresas as $empresa)
                    <?php $validador=0; ?>
                    @foreach($listViandas as $vi)
                        @if($empresa->id == $vi->Cliente->idempresa)
                        <?php $validador = 1;?>
                        @endif
                    @endforeach
                    @if($validador==1)
                    <div class="row">
                        <div class="col-md-12">
                            <div class=" panel panel-default viandas-empresa">
                                <div class=" panel-heading">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class="fa fa-building-o"></i> {{$empresa->nombre}}
                                        </div>
                                        @if($empresa->envio == 1)
                                        <?php $env = true; ?>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"title="Cadete"><i class="fa fa-motorcycle"></i>:</span>
                                                    {!!Form::select('id', $listCadetes,null,array('class' => 'form-control viandas-cadete-empresa'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group ">
                                                    <span class="input-group-addon" title="Costo Envio"> $</span>
                                                    {!!Form::Number('precio_envio',$empresa->Localidad->costo_envio,['class'=>' form-control costo-envio-empresa','required|between:0,999.99'])!!}
                                                </div>
                                            </div>
                                        @else
                                             <?php $env = false; ?>
                                            <div class="col-md-5">Sin Envio</div>
                                        @endif
                                    </div>
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        <div class="table-responsive no-padding">
                                            <table class="table table-hover  table-striped">
                                                <tbody>
                                                    @foreach($listViandas as $vianda)
                                                        @if($vianda->Cliente->idempresa == $empresa->id)
                                                        <?php $contador++; ?>
                                                        {!!Form::Text('pedidos['.$contador.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
                                                        {!!Form::Text('pedidos['.$contador.'][empresa_id]', $empresa->id ,['class'=>'hidden'])!!}
                                                        {!!Form::checkbox('pedidos['.$contador.'][envio]', $vianda->id, $env,['class'=>'hidden'])!!}
                                                        {!!Form::select('pedidos['.$contador.'][cadete_id]', $listCadetes,null,array('class' => 'hidden form-control cbx-cadete'))!!}
                                                        {!!Form::Text('pedidos['.$contador.'][precio_envio]',$empresa->Localidad->costo_envio,['class'=>' form-control hidden costo_envio'])!!}
                                                        {!!Form::Text('pedidos['.$contador.'][tipo_vianda_id]',$vianda->TipoVianda->id,['class'=>' form-control hidden'])!!}
                                                        <tr class="tabla-pedidos-padre">
                                                            <td>
                                                                {{$vianda->Cliente->nombre}} {{$vianda->Cliente->apellido}}
                                                                {!!Form::Text('pedidos['.$contador.'][cliente_id]',$vianda->Cliente->id,['class'=>' form-control hidden'])!!}
                                                            </td>
                                                            @if($empresa->ListPreciosViandas->contains($vianda->TipoVianda))
                                                            <?php
                                                                $precio_vianda= $empresa->ListPreciosViandas->find($vianda->TipoVianda->id)->pivot->precio;
                                                            ?>
                                                            @else
                                                               <?php $precio_vianda= $vianda->TipoVianda->precio;?>
                                                            @endif
                                                            <td style=" width: 200px">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" title="Cantidad">{{$vianda->TipoVianda->nombre}} </span>
                                                                    {!!Form::Number('pedidos['.$contador.'][cantidad]',$vianda->cantidad,['class'=>' form-control cantidad-pedido', 'data-precio'=> $precio_vianda,'required||between:0,999.99'])!!}
                                                                </div>
                                                            </td>
                                                            <td style=" width: 120px">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" title="Costo Vianda"> $</span>
                                                                    <?php $subtotal = $vianda->cantidad * $precio_vianda ?>
                                                                    {!!Form::Number('pedidos['.$contador.'][precio_vianda]',$subtotal,['class'=>' form-control precio-pedido','required|between:0,999.99'])!!}
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center">{!!Form::checkbox('pedidos['.$contador.'][confirmado]', $vianda->id, true)!!}</td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <?php $validador=0; ?>
                @foreach($listViandas as $vi)
                    @if(empty($vi->Cliente->idempresa))
                    <?php $validador = 1;?>
                    @endif
                @endforeach
                @if($validador==1)
                <div class="row">
                <div class="col-md-12">
                    <div class=" panel panel-default">
                        <div class=" panel-heading">
                            <i class="fa fa-building-o"></i> Sin Empresa
                        </div>
                        <div class=" panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive no-padding">
                                        <table class="table table-hover table-striped">
                                            <tbody>
                                            @foreach($listViandas as $vianda)
                                            @if($vianda->Cliente->idempresa == null)
                                            <?php $contador++; ?>
                                            {!!Form::Text('pedidos['.$contador.'][cliente_id]',$vianda->Cliente->id,['class'=>' form-control hidden'])!!}
                                            {!!Form::Text('pedidos['.$contador.'][fecha_pedido]', $fecha_pedido,['class'=>'hidden'])!!}
                                            {!!Form::Text('pedidos['.$contador.'][empresa_id]', '0' ,['class'=>'hidden'])!!}
                                            {!!Form::select('pedidos['.$contador.'][cadete_id]', $listCadetes,null,array('class' => 'hidden form-control'))!!}
                                            {!!Form::Text('pedidos['.$contador.'][tipo_vianda_id]',$vianda->TipoVianda->id,['class'=>' form-control hidden'])!!}
                                            <tr class="tabla-pedidos-padre">
                                                <td>{{$vianda->Cliente->nombre}} {{$vianda->Cliente->apellido}}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" title="¿Desea Envio?"><i class="fa fa-motorcycle"></i></span>
                                                        {!!Form::checkbox('pedidos['.$contador.'][envio]', $vianda->id, $vianda->Cliente->envio,['class'=>'cbx-pedido'])!!}
                                                    </div>
                                                </td>
                                                <td style=" width: 200px">
                                                    <div class="input-group @if( $vianda->Cliente->envio==0) hidden  @endif cadete-pedido">
                                                        <span class="input-group-addon" title="Cadete"><i class="fa fa-motorcycle"></i></span>
                                                        {!!Form::select('pedidos['.$contador.'][cadete_id]', $listCadetes,null,array('class' => 'form-control'))!!}
                                                    </div>
                                                </td>
                                                <td style=" width: 120px">
                                                    <div class="input-group @if( $vianda->Cliente->envio==0) hidden  @endif precio-envio-pedido">
                                                        <span class="input-group-addon" title="Costo Envio">$</span>
                                                        {!!Form::Number('pedidos['.$contador.'][precio_envio]',$vianda->Cliente->Localidad->costo_envio,['class'=>' form-control','required|between:0,99.99'])!!}
                                                    </div>
                                                </td>
                                                <td>
                                                </td>
                                                <td style=" width: 200px">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" title="Cantidad">{{$vianda->TipoVianda->nombre}}</span>
                                                        {!!Form::Number('pedidos['.$contador.'][cantidad]',$vianda->cantidad,['class'=>' form-control cantidad-pedido','required|between:0,999.99', 'data-precio'=> $vianda->TipoVianda->precio])!!}
                                                    </div>
                                                </td>
                                                <td style=" width: 120px">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" title="Costo Vianda"> $</span>
                                                        <?php $subtotal = $vianda->cantidad * $vianda->TipoVianda->precio; ?>
                                                        {!!Form::Number('pedidos['.$contador.'][precio_vianda]',$subtotal,['class'=>' form-control precio-pedido','required|between:0,99.99'])!!}
                                                    </div>
                                                </td>
                                                <td> {!!Form::checkbox('pedidos['.$contador.'][confirmado]', $vianda->id, true)!!}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endif

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="box-collapse"  class=" box box-info collapsed-box">
            <div class="box-header with-border">
                <i class="fa fa-leaf"></i> Pedidos Registrados
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" id="btn-collapsed" ><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div>
            <div class=" box-body">
                @foreach($listEmpresas as $empresa)
                    <div class="row">
                        <div class="col-md-12">
                            <div class=" panel panel-default">
                                <div class=" panel-heading">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class="fa fa-building-o"></i> {{$empresa->nombre}}
                                        </div>
                                        @if($empresa->envio == 1)
                                        <?php $envR = true; ?>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"title="Cadete"><i class="fa fa-motorcycle"></i>:</span>
                                                    @if($listPedidos->isEmpty())
                                                    {!!Form::select('id', $listCadetes,null,array('class' => 'form-control','disabled'))!!}
                                                    @else
                                                    {!!Form::select('id', $listCadetes,$listPedidos[0]->cadete_id,array('class' => 'form-control','disabled'))!!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon" title="Costo Envio"><i class="fa fa-motorcycle"></i>: $</span>
                                                     @if($listPedidos->isEmpty())
                                                    {!!Form::Text('precio_envio',$empresa->Localidad->costo_envio,['class'=>' form-control','required','disabled'])!!}
                                                    @else
                                                    {!!Form::Text('precio_envio',$listPedidos[0]->precio_envio,['class'=>' form-control','required','disabled'])!!}
                                                      @endif
                                                </div>
                                            </div>
                                        @else
                                            <?php $envR = false; ?>
                                            <div class="col-md-5">Sin Envio</div>
                                        @endif
                                    </div>
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive no-padding">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach($listPedidos as $pedido)
                                                            @if($pedido->Cliente->idempresa == $empresa->id)
                                                            <?php $contadorR++; ?>
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][id]', $pedido->id,['class'=>'hidden'])!!}
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][fecha_pedido]', $pedido->fecha_pedido,['class'=>'hidden'])!!}
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][empresa_id]', $pedido->empresa_id ,['class'=>'hidden'])!!}
                                                            {!!Form::checkbox('pedidos_r['.$contadorR.'][envio]', $pedido->id, $envR,['class'=>'hidden'])!!}
                                                            {!!Form::select('pedidos_r['.$contadorR.'][cadete_id]', $listCadetes,$pedido->cadete_id,array('class' => 'hidden form-control'))!!}
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][precio_envio]',$pedido->precio_envio,['class'=>' form-control hidden'])!!}
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][tipo_vianda_id]',$pedido->tipo_vianda_id,['class'=>' form-control hidden'])!!}
                                                            <tr>
                                                                <td>
                                                                    {{$pedido->Cliente->nombre}}  {{$pedido->Cliente->apellido}}
                                                                    {!!Form::Text('pedidos_r['.$contadorR.'][cliente_id]',$pedido->Cliente->id,['class'=>' form-control hidden'])!!}
                                                                </td>
                                                                <td>
                                                                  @if(!empty($pedido->observaciones)) {!!Form::Text('pedidos['.$contadorR.'][observaciones]',$pedido->observaciones,['class'=>' form-control ','title'=>'Observaciones','disabled'])!!}@endif
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" title="Cantidad">{{$pedido->TipoVianda->nombre}}</span>
                                                                        {!!Form::Text('pedidos_r['.$contadorR.'][cantidad]',$pedido->cantidad,['class'=>' form-control','required','disabled'])!!}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" title="Costo Vianda">$</span>
                                                                        {!!Form::Text('pedidos_r['.$contadorR.'][precio_vianda]',$pedido->precio_vianda,['class'=>' form-control','required','disabled'])!!}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <div class=" panel panel-default">
                            <div class=" panel-heading">
                                <i class="fa fa-building-o"></i> Sin Empresa
                            </div>
                            <div class=" panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive no-padding">
                                            <table class="table table-hover">
                                                <tbody>
                                                @foreach($listPedidos as $pedido)
                                                @if($pedido->Cliente->idempresa == null)
                                                <?php $contadorR++;
                                                if($pedido->envio==1){$envp = true;}else{$envp=false;}
                                                ?>
                                                {!!Form::Text('pedidos_r['.$contadorR.'][id]', $pedido->id,['class'=>'hidden'])!!}
                                                {!!Form::Text('pedidos_r['.$contadorR.'][fecha_pedido]', $pedido->fecha_pedido,['class'=>'hidden'])!!}
                                                {!!Form::Text('pedidos_r['.$contadorR.'][empresa_id]', '$pedido->empresa_id' ,['class'=>'hidden'])!!}
                                                {!!Form::select('pedidos_r['.$contadorR.'][cadete_id]', $listCadetes,$pedido->cadete_id,array('class' => 'hidden form-control'))!!}
                                                {!!Form::Text('pedidos_r['.$contadorR.'][tipo_vianda_id]',$pedido->tipo_vianda_id,['class'=>' form-control hidden'])!!}
                                                <tr>
                                                    <td>{{$pedido->Cliente->nombre}} {{$pedido->Cliente->apellido}} </td>
                                                    <td>
                                                        @if($envp==1)
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="¿Realizar Envio?"><i class="fa fa-motorcycle"></i>:</span>
                                                            {!!Form::checkbox('pedidos_r['.$contadorR.'][envio]', $pedido->id, $envp,['disabled'])!!}
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                     @if($envp==1)
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="Cadete"><i class="fa fa-motorcycle"></i></span>
                                                            {!!Form::select('pedidos_r['.$contador.'][cadete_id]', $listCadetes , $pedido->cadete_id ,array('class' => 'form-control','disabled'))!!}
                                                        </div>
                                                     @endif
                                                    </td>
                                                    <td>
                                                    @if($envp==1)
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="Costo Envio">$</span>
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][precio_envio]',$pedido->precio_envio,['class'=>' form-control','required','disabled'])!!}
                                                        </div>
                                                         @endif
                                                    </td>
                                                    <td>
                                                       @if(!empty($pedido->observaciones)) {!!Form::Text('pedidos['.$contadorR.'][observaciones]',$pedido->observaciones,['class'=>' form-control ','title'=>'Observaciones','disabled'])!!}@endif
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="Cantidad">{{$pedido->TipoVianda->nombre}}</span>
                                                            {!!Form::Number('pedidos_r['.$contadorR.'][cantidad]',$pedido->cantidad,['class'=>' form-control','required','disabled'])!!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-addon" title="Costo Vianda">$</span>
                                                            {!!Form::Text('pedidos_r['.$contadorR.'][precio_vianda]',$pedido->precio_vianda,['class'=>' form-control','required','disabled'])!!}
                                                        </div>
                                                    </td>

                                                </tr>
                                                @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    {!!Form::submit('Aceptar', array('class' => 'btn btn-success btn-block'))!!}
    </div>
</div>
{!! Form::close() !!}

<!-- Cargo de nuevo las librerias por el ajax -->
<!-- jQuery 2.1.3 -->
<script src="/js/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- jQuery UI 1.11.2 -->
<script src="/js/plugins/jQueryUI/jquery-ui-1.10.3.min.js" type="text/javascript"></script>



<script>
$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
$(function () {

    ///para cambiar los valores de cada pedido segun la empresa
    $( ".viandas-cadete-empresa" ).change(function() {
        $(this).closest('.viandas-empresa').find('.cbx-cadete').val($(this).val());
    });
    $( ".costo-envio-empresa" ).blur(function() {
            $(this).closest('.viandas-empresa').find('.costo_envio').val($(this).val());
    });
    ///para colapsar los pedidos registrados
    $('#btn-collapsed').click(function(event) {
        event.preventDefault();
      $('#box-collapse').toggleClass('collapsed-box',500);
    });
    /// para multiplicar la cantidad por el precio
    $( ".cantidad-pedido" ).change(function() {
       var precio_actual= $(this).attr('data-precio');
       var precio = $(this).val() * precio_actual;
       $(this).closest('.tabla-pedidos-padre').find('.precio-pedido').val(precio);
    });
    ///para esconder lo referente a envio segun si desea realizar o no envio
     $(".cbx-pedido").click(function() {
        $(this).closest('.tabla-pedidos-padre').find('.cadete-pedido').toggleClass('hidden');
        $(this).closest('.tabla-pedidos-padre').find('.precio-envio-pedido').toggleClass('hidden');
        });


});
</script>

