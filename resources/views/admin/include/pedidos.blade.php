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
                                             <div class="col-md-4"> {{$pedido->Cliente->nombre}} | {{$pedido->TipoVianda->nombre}} | {{$pedido->cantidad}}   </div>
                                             <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Envio</span>
                                                            {!!Form::checkbox($pedido->id, $pedido->id, false)!!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Envio: $</span>
                                                            {!!Form::Text('precio_envio',null,['class'=>' form-control','required'])!!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                         <span class="input-group-addon">Vianda: $</span>
                                                         {!!Form::Text('precio_vianda',null,['class'=>' form-control','required'])!!}
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
                                           <div class="col-md-4"> {{$pedido->Cliente->nombre}} | {{$pedido->TipoVianda->nombre}} | {{$pedido->cantidad}}   </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                     <div class="col-md-4">
                                                         <div class="input-group">
                                                             <span class="input-group-addon">Envio</span>
                                                             {!!Form::checkbox($pedido->id, $pedido->id, false)!!}
                                                         </div>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <div class="input-group">
                                                             <span class="input-group-addon">Envio: $</span>
                                                             {!!Form::Text('precio_envio',null,['class'=>' form-control','required'])!!}
                                                         </div>
                                                     </div>
                                                     <div class="col-md-4">
                                                          <span class="input-group-addon">Vianda: $</span>
                                                          {!!Form::Text('precio_vianda',null,['class'=>' form-control','required'])!!}
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
                                                 <div class="col-md-4">
                                                    {{$vianda->Cliente->nombre}} | {{$vianda->TipoVianda->nombre}} | {{$vianda->cantidad}}
                                                 </div>
                                                 <div class="col-md-8">
                                                     <div class="row">
                                                              <div class="col-md-3">
                                                                  <div class="input-group">
                                                                      <span class="input-group-addon">Envio</span>
                                                                      {!!Form::checkbox($vianda->id, $vianda->id, false,['class'=>' form-control'])!!}
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-3">
                                                                  <div class="input-group">
                                                                      <span class="input-group-addon">Envio: $</span>
                                                                      {!!Form::Text('precio_envio',null,['class'=>' form-control','required'])!!}
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">Vianda: $</span>
                                                                        {!!Form::Text('precio_vianda',$vianda->TipoVianda->precio,['class'=>' form-control','required'])!!}
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
                                            <div class="col-md-4"> {{$vianda->Cliente->nombre}} | {{$vianda->TipoVianda->nombre}} | {{$vianda->cantidad}}   </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Envio</span>
                                                            {!!Form::checkbox($vianda->id, $vianda->id, false,['class'=>' form-control'])!!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Envio: $</span>
                                                            {!!Form::Text('precio_envio',null,['class'=>' form-control','required'])!!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Vianda: $</span>
                                                            {!!Form::Text('precio_vianda',$vianda->TipoVianda->precio,['class'=>' form-control','required'])!!}
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


