<div class="row">
    <div class="col-md-12">
        <div class=" panel panel-default">
            <div class=" panel-heading">
               <i class="fa fa-leaf"></i> Pedidos Registrados
                    <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                               <i class="fa fa-question-circle"></i><span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu pull-right" role="menu">
                               <li></li>
                               <li></li>
                           </ul>
                       </div>
                    </div>
            </div>
            <div class=" panel-body">
                @foreach($listEmpresas as $empresa)
                    <div class="row">
                        <div class="col-md-12">
                            <div class=" panel panel-default">
                                <div class=" panel-heading">
                                    <i class="fa fa-building-o"></i> {{$empresa->nombre}}
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        @foreach($listPedidos as $pedido)
                                            @if($pedido->Cliente->idempresa == $empresa->id)
                                             <div class="col-md-12"> {{$pedido->Cliente->nombre}} | {{$pedido->TipoVianda->nombre}} | {{$pedido->cantidad}}   </div>
                                            @endif
                                        @endforeach
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
                                    @foreach($listPedidos as $pedido)
                                        @if($pedido->Cliente->idempresa == null)
                                           <div class="col-md-12"> {{$pedido->Cliente->nombre}} | {{$pedido->TipoVianda->nombre}} | {{$pedido->cantidad}}   </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class=" panel panel-default">
            <div class=" panel-heading">
               <i class="fa fa-leaf"></i> Pedidos Sin Registrar
                    <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                               <i class="fa fa-question-circle"></i><span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu pull-right" role="menu">
                               <li></li>
                               <li></li>
                           </ul>
                       </div>
                    </div>
            </div>
            <div class=" panel-body">
                @foreach($listEmpresas as $empresa)
                    <div class="row">
                        <div class="col-md-12">
                            <div class=" panel panel-default">
                                <div class=" panel-heading">
                                    <i class="fa fa-building-o"></i> {{$empresa->nombre}}
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        @foreach($listViandas as $vianda)
                                            @if($vianda->Cliente->idempresa == $empresa->id)
                                                 <div class="col-md-12"> {{$vianda->Cliente->nombre}} | {{$vianda->TipoVianda->nombre}} | {{$vianda->cantidad}}   </div>
                                            @endif
                                        @endforeach
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
                                    @foreach($listViandas as $vianda)
                                        @if($vianda->Cliente->idempresa == null)
                                           <div class="col-md-12"> {{$vianda->Cliente->nombre}} | {{$vianda->TipoVianda->nombre}} | {{$vianda->cantidad}}   </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


