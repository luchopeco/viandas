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
    font-size: 10pt;
    }
    table{
    border-collapse: collapse;
    }
    table,td,th{
        border: 0.5mm solid #000000;
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
        <div style="font-size: 8; text-align: right" >Nutrilife::Viandas::{{\Carbon\Carbon::now()->format('d-m-Y')}}</div>
        <div style="fontsize: 14; font-weight: bold; text-align: center">Planilla Semanal </div>
        @foreach($listDiaSemana as $d)
            <h1>{{$d->nombre}}</h1>
            <div ><h2>Sin Empresa</h2></div>
            <table>
                <tr>
                    <th style="width:45mm ;">Cliente</th>
                    <th style="width: 65mm">No Gusta</th>
                    <th style="width:10mm ">Cant.</th>
                    <th style="width: 30mm">Pedido</th>
                    <th style="width: 15mm">Total</th>
                    <th style="width: 10mm">Envio</th>
                </tr>
            @foreach($listPedidos as $p)
                @if($d->id == $p->dia && $p->empresa == null)
                    <tr >
                        <td>{{$p->apellido}}, {{$p->nombre}}</td>
                        <td style="font-size: 8pt">{{$p->no_me_gusta}}</td>
                        <td style="text-align: center;">{{$p->cantidad}}</td>
                        <td style="text-align: center;">{{$p->pedido}}</td>
                        <td style="text-align: center;">$ {{$p->total}}</td>
                        <td style="text-align: center;">{{$p->envio}}</td>
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
                      <th style="width: 75mm;">No Gusta</th>
                      <th style="width:10mm ">Cant.</th>
                      <th style="width: 35mm">Pedido</th>
                      <th style="width: 15mm">Total</th>
                    </tr>
                @foreach($listPedidos as $p)
                    @if($d->id == $p->dia && $p->empresa == $emp->nombre)
                        <tr >
                            <td>{{$p->apellido}}, {{$p->nombre}}</td>
                            <td style="font-size: 8pt">{{$p->no_me_gusta}}</td>
                            <td style="text-align: center;">{{$p->cantidad}}</td>
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