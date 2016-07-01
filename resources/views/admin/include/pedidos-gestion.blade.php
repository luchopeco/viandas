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
                                    <th>Tipo Vianda</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
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
                                    <td>{{$p->TipoVianda->nombre}}</td>
                                    <td>{{$p->cantidad}}</td>
                                    <td>$ {{$p->precio_vianda}}</td>
                                    <td>$ {{$p->precio_envio}}</td>
                                    <td>{{$p->observaciones}}</td>
                                    <td>{{$p->FueCobrado()}}</td>
                                    <td><a href="#"  class="btn btn-xs btn-info editar" data-idpedido="{{$p->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>