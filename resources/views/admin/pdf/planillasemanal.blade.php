<!DOCTYPE html>
<html lang="es">
    <head>
    <style>
    body{
    font-family: verdana, sans-serif;
    }
    table{
    border-collapse: collapse;
    }
    table,td,th{
        border: 1px solid #000000;
        width: 100%;
    }
    th{
        height: 30px;
        text-align: center;
    }
    td{
        min-height: 50px;
        padding-left: 5px;
    }
    </style>
        <!-- Bootstrap 3.3.2 -->

        <!-- Theme style -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div style="font-size: 9; text-align: right" >{{\Carbon\Carbon::now()}}</div>
        <div style="font-size: 14">Planilla Semanal </div>
        <br>
        @foreach($listDiaSemana as $d)
            <div style=" text-align: center">{{$d->nombre}}</div>
            @foreach($listEmpresas as $emp)
                <div> {{$emp->nombre}}. Envio:{{$emp->Envio()}}. @if($emp->Envio()=="SI") Costo:${{$emp->Localidad->costo_envio}} @endif </div>
                <table>
                    <tr>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Pedido</th>
                        <th>Total</th>
                        <th>No Gusta</th>
                        <th>Envio</th>
                    </tr>
                @foreach($d->ListViandasClientes as $vianda)
                    @if( $vianda->Cliente->idempresa == $emp->id)
                    <tr >
                        <td>{{$vianda->Cliente->nombre}} {{$vianda->Cliente->apellido}}</td>
                            <td>{{$vianda->cantidad}}</td>
                        <td>{{$vianda->TipoVianda->nombre}}- $
                            @if($emp->ListPreciosViandas->contains($vianda->TipoVianda))
                            <?php $precio = $emp->ListPreciosViandas->find($vianda->TipoVianda->id)->pivot->precio; ?>
                            {{$precio}}
                            @else
                            <?php $precio = $vianda->TipoVianda->precio; ?>
                            {{$precio}}
                            @endif
                        </td>

                        <td>
                            <?php $total =$vianda->cantidad * $precio; ?>
                            ${{$total}}
                        </td>
                        <td>
                        @foreach($vianda->Cliente->ListAlimentosNoMeGusta as $al)
                            {{$al->nombre}}-
                        @endforeach
                        </td>
                        <td></td>
                    </tr>
                    @endif
                @endforeach
                </table>
                 <div style="height:20px"></div>
            @endforeach
            <div> Sin Empresa </div>
            <table>
                <tr>
                    <th>Cliente</th>
                    <th>Pedido</th>
                    <th>Total</th>
                    <th>No Gusta</th>
                    <th>Envio</th>
                </tr>
            @foreach($listClientesSinEmpresa as $cliente)
                @if($cliente->ListDiasDeLaSemana->contains($d))
                    <?php
                    $cli="";
                     $pedido="";
                     $total=0;
                     $noGusta="";
                     $envio=0;
                     ?>
                    @foreach($cliente->ListViandas as $vianda)
                        @if($vianda->DiaSemana->id == $d->id)
                        <?php
                            $cli=$cliente->nombre ." ".$cliente->apellido;
                            $pedido.= "(".$vianda->cantidad ."-". $vianda->TipoVianda->nombre."-$".$vianda->TipoVianda->precio.")";
                            $total+= $vianda->cantidad * $vianda->TipoVianda->precio;
                            foreach($vianda->Cliente->ListAlimentosNoMeGusta as $al)
                            {
                                $noGusta=$al->nombre;
                            }
                            if($cliente->envio==1)
                            {
                            $envio = $cliente->Localidad->costo_envio;
                            }
                        ?>

                        @endif
                    @endforeach
                     <tr>
                        <td>{{$cli}}</td>
                        <td>{{$pedido}}</td>
                        <td>${{$total}}</td>
                        <td>{{$noGusta}}</td>
                        <td>${{$envio}}</td>
                     </tr>
                @endif
            @endforeach
            </table>
            <div style="height:20px"></div>
        @endforeach
    </body>
</html>