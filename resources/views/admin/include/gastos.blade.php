
        <div class="table-responsive">
            <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo Gasto</th>
                    <th>Descripcion</th>
                    <th>Monto</th>
                </tr>
                @foreach($listGastos as $gasto)
                <tr >
                    <td>{{Carbon\Carbon::parse( $gasto->fecha)->format('d/m/Y')}}</td>
                    <td>{{$gasto->TipoGasto->descripcion}}</td>
                    <td>{{$gasto->descripcion}}</td>
                    <td>{{$gasto->monto}}</td>
                    <td><a href="#"  class="btn btn-xs btn-info editar" data-idgasto="{{$gasto->id}}"  title="Editar"> <i class=" fa fa-edit"></i></a></td>
                    <td><a href="#" class="btn btn-xs btn-danger eliminar" data-idgasto="{{$gasto->id}}"  title="Eliminar"> <i class=" fa fa-close"></i></a></td>
                </tr>
                @endforeach
            </table>
        </div>
        <div> <h4>Total: ${{$total}}</h4></div>
