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
            @if($d->ListViandasClientes->count()>0)
            <div class="row">
                <div class="col-md-12">
                    <div class=" panel panel-default">
                        <div class=" panel-heading">
                        <i class="fa fa-calendar"></i> {{$d->nombre}} - Total Pedidos: {{$d->ListViandasClientes->count()}}
                        </div>
                        <div class=" panel-body">
                            @foreach($listClientes as $c)
                                @foreach($c->ListViandas as $v)
                                    @if($v->DiaSemana->id == $d->id)
                                     <div>
                                        <i class="fa fa-user"></i> <strong>{{$c->nombre}}</strong> | {{$v->TipoVianda->nombre}} | {{$v->cantidad}} unidades.(
                                            @foreach($c->ListAlimentosNoMeGusta as $a)
                                            {{$a->nombre}},
                                            @endforeach
                                    )</div>
                                    <hr>
                                    @endif
                                   @endforeach
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>


