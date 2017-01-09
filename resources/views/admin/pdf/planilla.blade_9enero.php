<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        @page {
            margin-top: 10mm;
            margin-left: 10mm;
            margin-right: 10mm;
            margin-bottom: 10mm;
        }
        body{
            font-family: verdana, sans-serif;
            font-size: 8pt;
        }
        table{
            border-collapse: collapse;
        }
        table,td,th{
            border: 0.3mm solid #000000;
        }
        th{
            text-align: center;
        }
        td{

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
<div style="font-size: 8px; text-align: right" >Nutrilife::Viandas::{{\Carbon\Carbon::now()->format('d-m-Y')}}</div>
<div style="font-size: 14px; font-weight: bold; text-align: center">Planilla Semanal </div>
<div style="font-size: 14px; text-align: center">Resumen</div>
<table style="text-align: center">
    <tr>
        <th style="width:26mm ;">Tipo Vianda</th>
        <th style="width:26mm ;">Lunes</th>
        <th style="width:26mm ;">Martes</th>
        <th style="width:26mm ;">Miercoles</th>
        <th style="width:26mm ;">Jueves</th>
        <th style="width:26mm ;">Viernes</th>
        <th style="width:26mm ;">Total</th>
    </tr>
    @foreach($cantidades as  $cant)
        <tr>
            <td>{{$cant->nombre}}</td>
            <td>{{$cant->lunes}}</td>
            <td>{{$cant->martes}}</td>
            <td>{{$cant->miercoles}}</td>
            <td>{{$cant->jueves}}</td>
            <td>{{$cant->viernes}}</td>
            <td>{{$cant->total}}</td>
        </tr>
    @endforeach
</table>

<br>
<hr><br>
<table>
    <tr style="background: lightgrey;font-size: 15px;">
        <th style="width: 45mm;height:10mm">Cliente</th>
        <th style="width: 30mm" >Lunes</th>
        <th style="width: 30mm">Martes</th>
        <th style="width: 30mm" >Miércoles</th>
        <th style="width: 30mm">Jueves</th>
        <th style="width: 30mm">Viernes</th>
        <th style="width: 10mm">Envío</th>
        <th style="width: 30mm">Total</th>
        <th style="width: 10mm">Pago</th>
    </tr>




@foreach($listClientes as $cliente)

<?php $totalCliente=0; ?>
    <tr>
        <th style="height:10mm">{{$cliente->apellido}} , {{$cliente->nombre}}</th>
        <th style="font-size:10px;">
        <?php $diaactual=0; ?>
        @foreach($listPedidos as $p)

            @if($p->dia==2 && $p->empresa == null && $cliente->id == $p->clienteID)
                {{$p->pedido}}
                <?php $totalCliente += $p->total; ?>
                <?php $diaactual=1; ?>
            @endif

        @endforeach

        <?php if(!$diaactual){echo '<span style="font-size:20px;">X';} ?>

        </th>

         <th style="font-size:10px;">
         <?php $diaactual=0; ?>
        @foreach($listPedidos as $p)

            @if($p->dia==3 && $p->empresa == null && $cliente->id == $p->clienteID)
                {{$p->pedido}}
                <?php $totalCliente += $p->total; ?>
                <?php $diaactual=1; ?>
            @endif

        @endforeach
        <?php if(!$diaactual){echo '<span style="font-size:20px;">X';} ?>

        </th>

         <th style="font-size:10px;">
         <?php $diaactual=0; ?>
        @foreach($listPedidos as $p)

            @if($p->dia==4 && $p->empresa == null && $cliente->id == $p->clienteID)
                {{$p->pedido}}
                <?php $totalCliente += $p->total; ?>
                <?php $diaactual=1; ?>
            @endif

        @endforeach
        <?php if(!$diaactual){echo '<span style="font-size:20px;">X';} ?>

        </th>

         <th style="font-size:10px;">
         <?php $diaactual=0; ?>
        @foreach($listPedidos as $p)

            @if($p->dia==5 && $p->empresa == null && $cliente->id == $p->clienteID)
                {{$p->pedido}}
                <?php $totalCliente += $p->total; ?>
                <?php $diaactual=1; ?>
            @endif

        @endforeach
        <?php if(!$diaactual){echo '<span style="font-size:20px;">X';} ?>

        </th>
         <th style="font-size:10px;">
         <?php $diaactual=0; ?>
        @foreach($listPedidos as $p)

            @if($p->dia==6 && $p->empresa == null && $cliente->id == $p->clienteID)
                {{$p->pedido}}
                <?php $totalCliente += $p->total; ?>
                <?php $diaactual=1; ?>
            @endif

        @endforeach
        <?php if(!$diaactual){echo '<span style="font-size:20px;">X';} ?>

        </th>

        <th>
            @if($cliente->envio==1)
                SI
            @else
            NO
            @endif
        </th>
        <th><?php echo $totalCliente ?></th>

        <th></th>
    </tr>
@endforeach
</table>


@foreach($listDiaSemana as $d)
    <h1>{{$d->nombre}}</h1>
    <div ><h2>Sin Empresa</h2></div>
    <table>
        <tr>
            <th style="width:45mm ;">Cliente</th>
            <!--<th style="width: 50mm">No Gusta</th>-->
            {{--<th style="width:10mm ">Cant.</th>--}}
            <th style="width: 40mm">Pedido</th>
            <th style="width: 10mm">Total</th>
            <th style="width: 10mm">Envio</th>
            <th style="width: 10mm">Conf.</th>
            <th style="width: 10mm">Pago</th>
        </tr>
        @foreach($listPedidos as $p)
            @if($d->id == $p->dia && $p->empresa == null)
                <tr >
                    <td>{{$p->apellido}}, {{$p->nombre}}</td>
                <!--    <td style="font-size: 8pt">{{$p->no_me_gusta}}</td>-->
                    {{--<td style="text-align: center;">{{$p->cantidad}}</td>--}}
                    <td style="text-align: center;">{!!$p->pedido!!}</td>
                    <td style="text-align: center;">${{$p->total}}</td>
                    <td style="text-align: center;">{{$p->envio}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        @endforeach
    </table>

    @foreach($listEmpresas as $emp)
        <?php $contador=0; ?>
        @foreach($listPedidos as $p)
            @if($d->id == $p->dia && $p->empresa == $emp->nombre)
                <?php $contador =1;
                break;?>
            @endif
        @endforeach
        @if($contador==1)
            <div><h2>{{$emp->nombre}} @if($emp->envio==1) - Con Envio @else - Sin Envio @endif</h2></div>
            <table>
                <tr>
                    <th style="width:45mm ;">Cliente</th>
                 <!--   <th style="width: 75mm;">No Gusta</th> -->
                    {{--<th style="width:10mm ">Cant.</th>--}}
                    <th style="width: 35mm">Pedido</th>
                    <th style="width: 15mm">Total</th>
                </tr>
                @foreach($listPedidos as $p)
                    @if($d->id == $p->dia && $p->empresa == $emp->nombre)
                        <tr >
                            <td>{{$p->apellido}}, {{$p->nombre}}</td>
                       <!--     <td style="font-size: 8pt">{{$p->no_me_gusta}}</td>-->
                            {{--<td style="text-align: center;">{{$p->cantidad}}</td>--}}
                            <td style="text-align: center;">{{$p->pedido}}</td>
                            <td style="text-align: center;">$ {{$p->total}}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @endif
    @endforeach
    <div style="page-break-after: always;"></div>
@endforeach
</body>
</html>