{!!Form::open(['route'=>'admin.pedidos.store','method'=>'POST', 'data-toggle='>'validator'])!!}
<div class="row">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class=" panel panel-default">
                                <div class=" panel-heading">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class="fa fa-building-o"></i> {{$empresa->nombre}}
                                        </div>
                                        @if($empresa->envio == 1)
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"title="Cadete"><i class="fa fa-motorcycle"></i>:</span>
                                                    {!!Form::select('id', $listCadetes,null,array('class' => 'form-control'))!!}
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-5">Sin Envio</div>
                                        @endif
                                    </div>
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach($listViandas as $vianda)
                                                @if($vianda->Cliente->idempresa == $empresa->id)
                                                    <div class="row">
                                                         <div class="col-md-3">
                                                            {{$vianda->Cliente->nombre}} {{$vianda->Cliente->apellido}}
                                                         </div>
                                                         <div class="col-md-9">
                                                             <div class="row">
                                                                @if($empresa->envio == 1)
                                                                      <div class="col-md-2"></div>
                                                                      <div class="col-md-2">
                                                                          <div class="input-group">
                                                                              <span class="input-group-addon" title="Costo Envio"><i class="fa fa-motorcycle"></i>: $</span>
                                                                              {!!Form::Text('precio_envio',$empresa->Localidad->costo_envio,['class'=>' form-control','required'])!!}
                                                                          </div>
                                                                      </div>
                                                                @else
                                                                      <div class="col-md-2"></div>
                                                                      <div class="col-md-2"></div>
                                                                @endif
                                                                      <div class="col-md-5">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" title="Costo Vianda">{{$vianda->cantidad}} {{$vianda->TipoVianda->nombre}}: $</span>
                                                                                 <?php $subtotal = $vianda->cantidad * $vianda->TipoVianda->precio; ?>
                                                                                {!!Form::Text('precio_vianda',$subtotal,['class'=>' form-control','required'])!!}
                                                                            </div>
                                                                      </div>
                                                                      <div class="col-md-3">
                                                                          <div class="input-group">
                                                                              <div class="input-group-btn">
                                                                                <button type="button" class="btn btn-danger">OK</button>
                                                                              </div>
                                                                               {!!Form::checkbox($vianda->id, $vianda->id, false,['class'=>' form-control'])!!}
                                                                           </div>
                                                                      </div>
                                                             </div>
                                                         </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                            @endforeach
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
                                        @foreach($listViandas as $vianda)
                                            @if($vianda->Cliente->idempresa == null)
                                                <div class="row">
                                                    <div class="col-md-3"> {{$vianda->Cliente->nombre}} {{$vianda->Cliente->apellido}}    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" title="¿Realizar Envio?"><i class="fa fa-motorcycle"></i>:</span>
                                                                    {!!Form::checkbox($vianda->id, $vianda->id, false,['class'=>' form-control'])!!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" title="Costo Envio"><i class="fa fa-motorcycle"></i>: $</span>
                                                                    {!!Form::Text('precio_envio',$vianda->Cliente->Localidad->costo_envio,['class'=>' form-control','required'])!!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" title="Costo Vianda">{{$vianda->cantidad}} {{$vianda->TipoVianda->nombre}}: $</span>
                                                                    <?php $subtotal = $vianda->cantidad * $vianda->TipoVianda->precio; ?>
                                                                    {!!Form::Text('precio_vianda',$subtotal,['class'=>' form-control','required'])!!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                  <div class="input-group">
                                                                      <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-danger">OK</button>
                                                                      </div>
                                                                       {!!Form::checkbox($vianda->id, $vianda->id, false,['class'=>' form-control'])!!}
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class=" box box-primary">
            <div class="box-header with-border">
               <i class="fa fa-leaf"></i> Pedidos Registrados
                    <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                               <i class="fa fa-question-circle"></i><span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu pull-right" role="menu">
                               <li>Pedidos que ya fueron confirmados</li>
                               <li></li>
                           </ul>
                       </div>
                    </div>
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
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"title="Cadete"><i class="fa fa-motorcycle"></i>:</span>
                                                    {!!Form::select('id', $listCadetes,null,array('class' => 'form-control'))!!}
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-5">Sin Envio</div>
                                        @endif
                                    </div>
                                </div>
                                <div class=" panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach($listPedidos as $pedido)
                                                @if($pedido->Cliente->idempresa == $empresa->id)
                                                <div class="row">
                                                     <div class="col-md-3"> {{$pedido->Cliente->nombre}}   </div>
                                                     <div class="col-md-9">
                                                        <div class="row">
                                                             @if($empresa->envio == 1)
                                                                    <div class="col-md-2"></div>
                                                                    <div class="col-md-2">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon" title="Costo Envio"><i class="fa fa-motorcycle"></i>: $</span>
                                                                            {!!Form::Text('precio_envio',$empresa->Localidad->costo_envio,['class'=>' form-control','required'])!!}
                                                                        </div>
                                                                    </div>
                                                             @else
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-2"></div>
                                                             @endif
                                                            <div class="col-md-5">
                                                                 <span class="input-group-addon" title="Costo Vianda">{{$pedido->cantidad}}  {{$pedido->TipoVianda->nombre}} : $</span>
                                                                 {!!Form::Text('precio_vianda',null,['class'=>' form-control','required'])!!}
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="input-group">
                                                                   <div class="input-group-btn">
                                                                     <button type="button" class="btn btn-danger">OK</button>
                                                                   </div>
                                                                    {!!Form::checkbox($pedido->id, $pedido->id, false,['class'=>' form-control'])!!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </div>
                                                 </div>
                                                 <hr>
                                                @endif
                                            @endforeach
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
                                        @foreach($listPedidos as $pedido)
                                            @if($pedido->Cliente->idempresa == null)
                                                <div class="row">
                                                    <div class="col-md-3"> {{$pedido->Cliente->nombre}}    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                             <div class="col-md-2">
                                                                 <div class="input-group">
                                                                     <span class="input-group-addon">Envio</span>
                                                                     {!!Form::checkbox($pedido->id, $pedido->id, false)!!}
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-2">
                                                                 <div class="input-group">
                                                                     <span class="input-group-addon" title="Costo Envio"><i class="fa fa-motorcycle"></i>: $</span>
                                                                     {!!Form::Text('precio_envio',null,['class'=>' form-control','required'])!!}
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-5">
                                                                  <span class="input-group-addon" title="Costo Vianda">{{$pedido->cantidad}}{{$pedido->TipoVianda->nombre}}: $</span>
                                                                  {!!Form::Text('precio_vianda',null,['class'=>' form-control','required'])!!}
                                                             </div>
                                                             <div class="col-md-3">
                                                                <div class="input-group">
                                                                   <div class="input-group-btn">
                                                                     <button type="button" class="btn btn-danger">OK</button>
                                                                   </div>
                                                                    {!!Form::checkbox($pedido->id, $pedido->id, false,['class'=>' form-control'])!!}
                                                                </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
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
</div>
<div class="row">
    <div class="col-md-12">
    {!!Form::submit('Aceptar', array('class' => 'btn btn-success btn-block'))!!}
    </div>
</div>


