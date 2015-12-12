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
                        <i class="fa fa-calendar"></i> {{$d->nombre}}
                        </div>
                        <div class=" panel-body">
                            @foreach($d->ListViandasClientes as $c)
                                <div>
                                    <i class="fa fa-user"></i> <strong>{{$c->Cliente->nombre}}</strong> | {{$c->TipoVianda->nombre}} | {{$c->cantidad}} unidades.(
                                        @foreach($c->Cliente->ListAlimentosNoMeGusta as $a)
                                        {{$a->nombre}},
                                        @endforeach
                                )</div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>


