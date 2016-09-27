@extends('admin.masteradmin')

@section('title')
<h1> LIQUIDAR CADETES</h1>
@endsection

@section('breadcrumb')
<li><a href="/admin/home"><i class="fa fa-home"></i> Home</a></li>
@endsection

@section('content')
   @if(Session::has('mensajeOk'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{Session::get('mensajeOk')}}
                </div>
            </div>
        </div>
        </hr>
   @endif
   @if(Session::has('mensajeError'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('mensajeError')}}
                </div>
            </div>
        </div>
        </hr>
   @endif
   <div class="row">
       <div class=" col-md-12">
          <div class=" panel panel-default">
              
               <div class=" panel-body">
                   <div class="table-responsive">
                       <table id="editar"  class=" table table-bordered table-condensed table-hover table-responsive">
                           <div class="col-md-6">
                             
                             <SELECT NAME="cadete" id="cadete" class="form-control">
                               
                              <option value="0"> SELECCIONAR CADETE </option>
                                   @foreach($cadetes as $loc)

                                    <option value="{{$loc->id}}">{{$loc->nombre}} - {{$loc->apellido}}</option>
                                       
                                   @endforeach

                             </SELECT>


                           </div>
                       

                       </table>


                        <div class="col-md-3">

                                <div class="form-group">
                                    <label>Fecha desde</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                          {!!Form::date('fechaDesde',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>' form-control datepicker','required','id'=>'txtfechaDesde'])!!}
                                          
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>Fecha Hasta</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                          {!!Form::date('fechaHasta',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>' form-control datepicker','required','id'=>'txtfechaHasta'])!!}
                                          
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                       
                                         <button id="liquidacion">
                                           Ver Liquidación
                                         </button>
                            
                            </div>
                   </div>
               </div>
          </div>
       </div>
   </div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" media="screen" />
  
   <div  class="row">

       <div id="resultados" class="col-md-6">
         
       </div>
        <span id="resultadostotal" class="col-md-6" style="font-size:30px"></span>

    

   </div>
   

   <table id="cobros" class="display" style="display:none;" cellspacing="0" width="100%">
                                  <thead>
                                      <tr>
                                          <th>Cliente</th>
                                          <th>Fecha Pedido</th>
                                                                                
                                          <th>Envío</th>
                                          
                                         
                                      </tr>
                                  </thead>
                                  <tfoot>
                                      <tr>
                                          <th>Cliente</th>
                                          <th>Fecha Pedido</th>
                                                                                 
                                          <th>Envío</th>
                                         
                                      </tr>
                                  </tfoot>
                                  <tbody>
                                  </tbody>
                                </table>



  
  
@endsection

@section('script')
<script>

    function validar(){
      return true;
    }

    $(function () {
      
      $('#liquidacion').click(function(){
          if (validar()) { 

          $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');

          var fechaDesde= $("#txtfechaDesde").val();
          var fechaHasta= $("#txtfechaHasta").val();  
          var id_cadete = $('#cadete').val();       
          
            $.ajax({
                url:"/admin/pedidos/liquidarcadeteunico",
                type: "GET",
                dataType: "html",
                data:{'idcadete': id_cadete, 'fechahasta':fechaHasta , 'fechadesde':fechaDesde  }
                
            })
            .done(function(response){
                //$('#respuesta').html(response);
               // $('#cargando').html('');
               
               // $('#resultados').html(response);

                activardatatable(response);
                $('#cargando').html('');
 
            })
            .fail(function(){
                //alert(fd);
                $('#cargando').html('');
            });

          }
      });

    });

</script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


<script>
  $(document).ready(function() {
    // $('#cobros').DataTable();
} );

function activardatatable(respuesta){

  $('#cobros').show();
  var pedidosliquidados = JSON.parse(respuesta);
  var totalliquidado = pedidosliquidados.pop();
  //alert(totalliquidado);
$('#resultados').show();
$('#resultados').html('');
$('#resultados').html('El total del cadete es: ');

$('#resultadostotal').html(totalliquidado);
  $('#resultadostotal').html(totalliquidado);

  $('#resultados').show();


    console.log(pedidosliquidados);
    var dataT = null;
    
     if(dataT!=null){
      table.destroy();
     }
      dataT= $('#cobros').DataTable({
        "data": pedidosliquidados ,
        "filter": true,
        "destroy": true,
        "pageLength": 2000
     });
     
  }
</script>

@endsection

