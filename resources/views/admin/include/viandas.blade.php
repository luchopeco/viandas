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
                    <div class=" panel panel-default">
                        <div class=" panel-heading">
                        <i class="fa fa-calendar"></i> {{$d->nombre}}  ||
                             <?php $total =0; ?>
                        @foreach($cantidades as $cant)
                             @if($cant->dia == $d->id)
                             <?php $total = $total+$cant->cantidad ?>
                             {{$cant->nombre}}: {{$cant->cantidad}} ||
                             @endif
                        @endforeach
                         Total: {{$total}}
                        </div>
                        <div class=" panel-body">
                            @foreach($listPedidos as $p)
                                    @if($p->dia == $d->id)
                                     <div>
                                        <i class="fa fa-user"></i> <strong>{{$p->apellido}}, {{$p->nombre}}</strong> | {{$p->tipo_vianda}} | {{$p->cantidad}} unidades.({{$p->no_me_gusta}})
                                     </div>
                                    <hr>
                                    @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


