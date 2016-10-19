<div class="row">
    <div class="col-md-12">
        <div class=" panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Empresa</th>
                                    <th>Pedido</th>
                                    <th>Total</th>
                                    <th>Envio</th>
                                    <th>Observaciones</th>
                                    <th>Cobrado</th>
                                </tr>
                                @foreach($listPedidos as $p)
                                <tr>
                                    <td> {{$p->FechaPedido()}}</td>
                                    <td>{{$p->Cliente->apellido}}, {{$p->Cliente->nombre}}</td>
                                    @if($p->Cliente->Empresa != null)
                                        <td>{{$p->Cliente->Empresa->nombre}}</td>
                                    @else
                                        <td>Sin Empresa</td>
                                    @endif
                                    <td>
                                    @foreach($p->ListLineasPedido as $lp)
                                        {{$lp->cantidad}} {{$lp->TipoVianda->nombre}} <br>
                                    @endforeach

                                    </td>

                                    <td>$ {{$p->total}}</td>
                                    <td>
                                    @if($p->envio==1)
                                        ${{$p->precio_envio}}
                                    @else
                                        Sin Envio
                                    @endif
                                    </td>
                                    <td>{{$p->observaciones}}</td>
                                    <td>{{$p->FueCobrado()}}</td>
                                    <td><a href="/admin/pedidos/{{$p->id}}/edit"  class="btn btn-xs btn-info" title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                    <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idpedido="{{$p->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua">
                                <i class="fa fa-line-chart" aria-hidden="true"></i>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">Cantidad</span>
                              <span class="info-box-number"> <strong>{{$listPedidos->count()}}</strong></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

