<div class=" panel panel-default">
    <div class=" panel-heading">
       <i class="fa fa-leaf"></i> Viandas
            <div class="pull-right">
               <div class="btn-group">
                   <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                       <i class="fa fa-question-circle"></i><span class="caret"></span>
                   </button>
                   <ul class="dropdown-menu pull-right" role="menu">
                       <li>El orden a mostrar de cada cliente es</li>
                       <li>[cliente] | [tipo vianda] | [canridad] unidades. [ (alimentos q no gustan) ]</li>
                   </ul>
               </div>
            </div>
    </div>
    <div class=" panel-body">
        @foreach($listDiaSemana as $d)
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class=" box-header with-border">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-aqua">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Dia</span>
                                          <span class="info-box-number"> <strong>{{$d->nombre}}</strong></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <?php $total =0; ?>
                                @foreach($cantidades as $cant)
                                    @if($cant->dia == $d->id)
                                    <?php $total = $total+$cant->cantidad ?>
                                    <div class="col-md-3">
                                     <div class="info-box">
                                         <span class="info-box-icon bg-green">
                                             <i class="fa fa-leaf"></i>
                                         </span>
                                         <div class="info-box-content">
                                           <span class="info-box-text">{{$cant->nombre}}</span>
                                           <span class="info-box-number"> <strong>{{$cant->cantidad}}</strong></span>
                                         </div>
                                         <!-- /.info-box-content -->
                                     </div>
                                 </div>
                                    @endif
                                @endforeach
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-red">
                                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total</span>
                                            <span class="info-box-number"> <strong>Total: {{$total}}</strong></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" box-body">
                            @foreach($listPedidosEmpresa as $emp)
                            @if($emp->dia_id = $d->id)
                                <div class="row">
                                    <div class="callout callout-info">
                                        <h4>{{$emp->Empresa->nombre}}</h4>
                                    </div>
                                 @foreach($emp->ListPedidos as $p)
                                     <div class="col-md-3" style="height: 180px; overflow: visible">
                                        <div class="box box-default">
                                            <div class="box-header with-border">
                                                <i class="fa fa-user"></i> <strong>{{$p->Cliente->apellido}}, {{$p->Cliente->nombre}}</strong>
                                            </div>
                                            <div class="box-body">
                                                @foreach($p->ListLineasPedido as $lp)
                                                    <span>{{$lp->cantidad}} {{$lp->TipoVianda->nombre}} / </span>
                                                @endforeach
                                                <div>
                                                @foreach($p->Cliente->ListAlimentosNoMeGusta as $nmg)
                                                    <small>{{$nmg->nombre}},</small>
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                @endforeach
                                </div>
                            @endif
                            @endforeach
                            <div class="row">
                                <div class="callout callout-info">
                                    <h4>Clientes Sin Empresa</h4>
                                </div>
                             @foreach($listPedidosClientes as $p)
                                @if( $p->dia_id = $d->id)
                                 <div class="col-md-3" style="height: 180px; overflow: visible">
                                    <div class="box box-default">
                                        <div class="box-header with-border">
                                            <i class="fa fa-user"></i> <strong>{{$p->Cliente->apellido}}, {{$p->Cliente->nombre}}</strong>
                                        </div>
                                        <div class="box-body">
                                            @foreach($p->ListLineasPedido as $lp)
                                                <span>{{$lp->cantidad}} {{$lp->TipoVianda->nombre}} / </span>
                                            @endforeach
                                            <div>
                                            @foreach($p->Cliente->ListAlimentosNoMeGusta as $nmg)
                                                <small>{{$nmg->nombre}},</small>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


