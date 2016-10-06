 <div class="col-md-12">
 <div class="box box-primary">
    <div class="box-header">
        <h2>Detalle Pedido</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="callout callout-info">
                    <h4>{{$pedido->Empresa->nombre}}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="callout callout-danger">
                    <h4>Total: $ {{$pedido->total}}</h4>
                </div>
            </div>
            @if($pedido->envio==1)
                <div class="col-md-4">
                    <div class="callout callout-success">
                        <p><i class="fa fa-motorcycle"></i> {{$pedido->Cadete->nombre}} - $ {{$pedido->precio_envio}}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                 <div class="table-responsive">
                    <table class="table table-bordered ">
                        <tr>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Pedido</th>
                            <th>Total</th>
                            <th>Observaciones</th>
                            <th>Cobrado</th>
                        </tr>
                          @foreach($pedido->ListPedidos as $p)
                        <tr>
                            <td> {{$p->FechaPedido()}}</td>
                            <td>{{$p->Cliente->nombre}}</td>
                            <td>
                                @foreach($p->ListLineasPedido as $lp)
                                {{$lp->cantidad}} {{$lp->TipoVianda->nombre}} /
                                @endforeach
                            </td>
                            <td>$ {{$p->total}}</td>
                            <td>{{$p->observaciones}}</td>
                            <td>{{$p->FueCobrado()}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="callout callout-defaut">
                   <h4>{{$pedido->ListPedidos->count()}} Pedidos</h4>
                </div>
            </div>
        </div>
    </div>
 </div>
</div>