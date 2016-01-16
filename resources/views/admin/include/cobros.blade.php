{!!Form::open(['route'=>'admin.pedidos.store','method'=>'POST', 'data-toggle='>'validator'])!!}
<?php $contador=0; ?>
<div class="row">
    <div class="col-md-12">
        <div class=" box box-primary">
            <div class="box-header with-border">
               <i class="fa fa-leaf"></i> 
                    <div class="pull-right">
                       <div class="btn-group">
                           <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                               <i class="fa fa-question-circle"></i><span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu pull-right" role="menu">
                               <li>Pedidos que se deben confirmar. Estos Vienen por la configuracion del cliente</li>
                               <li></li>
                           </ul>
                       </div>
                    </div>
            </div>
            <div class="box-body">
              
                <div class="row">
                    <div class="col-md-12">
                        <div class=" panel panel-default">
                            <div class=" panel-heading">
                                <i class="fa fa-building-o"></i>  COBROS
                            </div>
                            <div class=" panel-body">                     


                                  <?php 

                                  $montoTotal=0;

                                 // echo 'La empresa actual seleccionada es: '.$empresaActual;
                                  if (empty($empresaActual)) {
                                    // SIN EMPRESA

                                      foreach ($listPedidos as $p ) {
                                        $totalpedido=$p->precio_vianda + $p->precio_envio;
                                        $montoTotal = $montoTotal + $totalpedido;
                                        ?>
                                        <div class="row">
                                        <?php 
                                        // aca vamos generando las columnas
                                        echo '<div class="col-md-2 col-sm-4 col-xs-6">';        
                                        echo $p->cliente->nombre.' - '.$p->cliente->apellido; 
                                        echo '</div>';

                                        echo '<div class="col-md-2 col-sm-4 col-xs-6">';        
                                        echo $p->fecha_pedido; 
                                        echo '</div>';

                                        echo '<div class="col-md-2 col-sm-4 col-xs-6">';        
                                        echo $p->tipovianda->nombre." - ".$p->cantidad;  
                                        echo '</div>';
                                        
                                       
                                        echo '<div class="col-md-2 col-sm-4 col-xs-6">Precio: ';        
                                        echo $p->precio_vianda.' + Envio: '.$p->precio_envio; 
                                        echo '</div>'; 

                                        echo '<div class="col-md-2 col-sm-4 col-xs-6">Total: ';        
                                        echo $totalpedido;
                                        echo '</div>'; 
                                                                            

                                        echo '<div class="col-md-2 col-sm-4 col-xs-6">';        
                                        $c='';
                                        if(!empty($p->cobrado)){$c='checked="checked"';}

                                        echo '<input type="checkbox" '.$c.' name="'.$p->id.' id="pedido_'.$p->id.'" "></input>';

                                        echo '</div>';


                                        ?>
                                        </div>
                                        <?php 
                                      }

                                  } // CIERRA IF EMPRESA

                                  else{

                                      ?>
                                        <div class="row">
                                      <?php 
                                        echo "La liquidacion total de una empresa:";

                                      ?>
                                        </div>
                                      <?php 
                                  }

                                  
                                   ?>



                            </div>
                        </div>
                    </div>
                </div>

             


            </div>
        </div>
    </div>
</div>
<div class="row">
   
</div>
   <div class="row">
                                   <div class="col-md-6">
                                     monto total = <?php echo $montoTotal; ?>
                                   </div>
                                   </div>
<div class="row">
    <div class="col-md-12">
    {!!Form::submit('Aceptar', array('class' => 'btn btn-success btn-block'))!!}
    </div>
</div>



<!-- Cargo de nuevo las librerias por el ajax -->
<!-- jQuery 2.1.3 -->
<script src="/js/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- jQuery UI 1.11.2 -->
<script src="/js/plugins/jQueryUI/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="/js/jquery.datetimepicker.js" type="text/javascript"></script>
<script>

</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="/dist/js/app.min.js" type="text/javascript"></script>

<script>
  $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
</script>

