<!DOCTYPE html>
<html lang="es">
    <head>
    <style>
    body{
    font-family: verdana, sans-serif;
    font-size: 10px;
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
        height: 30px;
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
        <div style="font-size: 8; text-align: right" >Nutrilife::Viandas::{{\Carbon\Carbon::now()->format('d-m-Y')}}</div>
        <div style="font-size: 14; font-weight: bold">Planilla Semanal </div>
        <br>

        @foreach($listDiaSemana as $d)
            {{$d->nombre}}
            <div style="font-size: 11px">Sin Empresa</div>
            <table>
                <tr>
                    <th>Cliente</th>
                    <th>Cantidad</th>
                    <th>Pedido</th>
                    <th>Total</th>
                    <th>No Gusta</th>
                    <th>Envio</th>
                </tr>
            @foreach($listPedidos as $p)
                @if($d->id == $p->dia && $p->empresa == null)
                    <tr >
                        <td>{{$p->apellido}}, {{$p->apellido}}</td>
                        <td>{{$p->cantidad}}</td>
                        <td>{{$p->pedido}}</td>
                        <td>{{$p->total}}</td>
                        <td>{{$p->no_me_gusta}}</td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            </table>

            @foreach($listEmpresas as $emp)
                <div style="font-size: 11px">{{$emp->nombre}}</div>
                <table>
                    <tr>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Pedido</th>
                        <th>Total</th>
                        <th>No Gusta</th>
                        <th>Envio</th>
                    </tr>
                @foreach($listPedidos as $p)
                    @if($d->id == $p->dia && $p->empresa == $emp->nombre)
                        <tr >
                            <td>{{$p->apellido}}, {{$p->apellido}}</td>
                            <td>{{$p->cantidad}}</td>
                            <td>{{$p->pedido}}</td>
                            <td>{{$p->total}}</td>
                            <td>{{$p->no_me_gusta}}</td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                </table>
            @endforeach
        @endforeach
    </body>
</html>