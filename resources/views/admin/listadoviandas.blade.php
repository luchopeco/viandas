@extends('admin.masteradmin')

@section('title')
<h1> Listado de Viandas</h1>
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
                   <div class=" panel-heading">Viandas
                   </div>
                   <div class=" panel-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Dia</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                         {!!Form::select('id', $listDiaSemanaSelect,null,array('class' => 'form-control','id'=>'cbxDiaSemana'))!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"> Todos
                            <div><input type="checkbox" name="todos" id="chkTodos" class="" ></div>
                            </div>
                            <div class="col-md-2">
                            .
                                <button type="button" id="btnBuscar" title="Buscar" class="btn btn-success btn-block"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="col-md-2">
                               . <a href="repor/planillasemanal" target="_blank" class="btn btn-primary btn-block" title="Imprimir Planilla Semanal">
                                    <i class="fa fa-print"></i>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12" id="tabla-viandas"></div>
                        </div>
                   </div>
              </div>
       </div>
   </div>
@endsection

@section('script')
<script>
function buscarViandas(){
    $('#cargando').html('<button class="btn btn-default btn-lg"><i class="fa fa-spinner fa-spin"></i>Cargando....</button>');
    //event.preventDefault();
    ///si tengo q buscar todos
    if($("#cbxDiaSemana").is(":disabled"))
    {
        $.ajax({
            url:"viandas/buscartodas",
            type: "POST",
            dataType: "html"
        })
        .done(function(response){
            $('#tabla-viandas').html(response);
            $('#cargando').html('');
        })
        .fail(function(){
            alert(fd);
            $('#cargando').html('');
        });
    }
    else{
        var id= $("#cbxDiaSemana").val();
        $.ajax({
                url:"viandas/buscar",
                type: "POST",
                dataType: "html",
                data:{'id': id}
            })
            .done(function(response){
                $('#tabla-viandas').html(response);
                $('#cargando').html('');
            })
            .fail(function(){
                alert(fd);
                $('#cargando').html('');
            });

    }

}
$(function () {



         ///Activo o desactivo el combo del dia de la semana
        $("#chkTodos").click(function() {
        if($("#cbxDiaSemana").is(":disabled"))
          $("#cbxDiaSemana").attr('disabled',false);
          else
          $("#cbxDiaSemana").attr('disabled', true);
        });

       ///seteo el dia de la semana
       var fecha = new Date();
       var dia = fecha.getDay()+1;
       $("#cbxDiaSemana").val(dia);

        ///luego de setear busco las viandas
       buscarViandas();

        ////cuando busco
       $("#btnBuscar").click(function(){
            buscarViandas();
       });


    });

</script>
@endsection

