<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Nutrilife - Gestor Viandas</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="author" content="Adapweb Sistemas">
    <title>::Nutrilife::Gestor de Viandas</title>
        <!-- favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <!-- Bootstrap 3.3.2 -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/js/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="/js/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="/js/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="/js/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
     <link href="/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />

     <link href="/css/dropzone.css" rel="stylesheet" type="text/css" />

     <!-- CSS Propiooo-->
      <link href="/dist/css/css.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="/admin/home" class="logo"><i class="fa fa-home fa-fw"></i><b>Nutrilife</b>Viandas</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              @if (Auth::guest())
              	<li><a href="/auth/login">Ingresar</a></li>
              @else
              	<li class="dropdown">
              	    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" data-toggle="modal" data-target="#modalClave"><i class="fa fa-pencil-square-o"></i> Modificar Clave</a></li>
                        <li><a href="/auth/logout"><i class=" fa fa-power-off"></i> Salir</a></li>
              		</ul>
              	</li>
              	@endif
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Menu Navegacion</li>
            <li <?php if('admin.viandas.index'== Route::current()->getName()||'admin.viandas.index'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/viandas"> <i class="fa fa-tachometer"></i>Panel Control</a></li>
             <li <?php if('admin.clientes.index'== Route::current()->getName()||'admin.clientes.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/clientes"><i class="fa fa-users"></i>Clientes</a></li>
             <li <?php if('viandas\Http\Controllers\Admin\ClientesController'==substr(\Illuminate\Support\Facades\Route::getCurrentRoute()->getActionName(), 0, -15)){echo 'class="active"';} ?>><a href="/admin/loquenogusta"><i class="fa fa-thumbs-down"></i>Lo que no Gusta</a></li>
            <li <?php if('admin.alimentos.index'== Route::current()->getName()||'admin.alimentos.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/alimentos"><i class="fa fa-coffee"></i>Alimentos</a></li>
            <li <?php if('admin.tiposviandas.index'== Route::current()->getName()||'admin.tiposviandas.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/tiposviandas"><i class="fa fa-leaf"></i>Tipos Viandas</a></li>
             <li <?php if('admin.gastos.index'== Route::current()->getName()||'admin.gastos.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/gastos"><i class="fa fa-usd"></i>Gastos</a></li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Configuracion</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if('admin.nolaborables.index'== Route::current()->getName()||'admin.nolaborables.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/nolaborables"><i class="fa fa-calendar"></i>Dias no laborables</a></li>
                <li <?php if('admin.tipogastos.index'== Route::current()->getName()||'admin.tipogastos.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/tipogastos"><i class="fa fa-money"></i>Tipos Gastos</a></li>
                <li <?php if('admin.tiposalimentos.index'== Route::current()->getName()||'admin.tiposalimentos.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/tiposalimentos"><i class="fa fa-lemon-o"></i>Tipos Alimentos</a></li>
                 <li <?php if('admin.empresas.index'== Route::current()->getName()||'admin.empresas.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/empresas"><i class="fa fa-building-o"></i>Empresas</a></li>
                 <li <?php if('admin.localidades.index'== Route::current()->getName()||'admin.localidades.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/localidades"><i class="fa fa-map-marker"></i>Localidades</a></li>
                 <li <?php if('admin.cadetes.index'== Route::current()->getName()||'admin.cadetes.show'== Route::current()->getName()){echo 'class="active"';} ?>><a href="/admin/cadetes"><i class="fa fa-motorcycle"></i>Cadetes</a></li>
                                

              </ul>
            </li>

            <li><a href="#"></a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

        <div id="cargando" style="position: fixed; top: 2%; left: 50%; z-index: 1051;">
        </div>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('title')
        {{--  <h1>
            Dashboard
            <small>Control panel</small>
          </h1>--}}
           <ol class="breadcrumb">
                @yield('breadcrumb')
           {{-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>--}}
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
                 @if(Session::has('mensajeOkSession'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{Session::get('mensajeOkSession')}}
                                </div>
                            </div>
                        </div>
                        </hr>
                 @endif
                @if(Session::has('mensajeErrorSession'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       {{Session::get('mensajeErrorSession')}}
                                </div>
                            </div>
                        </div>
                        </hr>
                @endif
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Tifosi -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-8435509096817410"
                         data-ad-slot="5042061489"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            <br>
            @yield('content')
            <div class="modal fade" id="modalClave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              {!!Form::open(['url'=>'/admin/modificarclave','method'=>'POST', 'data-toggle='>'validator'])!!}
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                      <h4 class="modal-title" id="myModalLabel">Modificando Clave</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class=" panel panel-default">
                                        <div class=" panel-heading">Clave</div>
                                        <div class=" panel-body">
                                          <div clas="row">
                                              <div class="col-md-12">
                                                    <div class="form-group">
                                                        Clave Actual
                                                        <input type="password" class="form-control" name="clave-actual">
                                                        <span class="help-block with-errors"></span>
                                                    </div>
                                                    <div class="form-group">
                                                         Clave Nueva
                                                         <input type="password" class="form-control" name="clave-nueva">
                                                        <span class="help-block with-errors"></span>
                                                    </div>
                                                    <div class="form-group">
                                                         Reingresar Clave Nueva
                                                         <input type="password" class="form-control" name="clave-nueva-2">
                                                        <span class="help-block with-errors"></span>
                                                    </div>
                                              </div>
                                           </div>
                                  </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                      {!!Form::submit('Aceptar', array('class' => 'btn btn-success'))!!}
                                  </div>
                              {!! Form::close() !!}
                        </div>
                      <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
            </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          
        </div>
        <strong> <a href="http://www.adapweb.com.ar">ADAPWEB - INGENIERÍA INFORMÁTICA</a>.</strong>
      </footer>
    </div>
    <!-- ./wrapper -->

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

    <script src="/js/plugins/validator/validator.min.js" type="text/javascript"></script>
        <script>
        $(function () {
            jQuery('.datepicker').datetimepicker({
             lang:'es',
             i18n:{
              de:{
               months:[
                'Enero','Febrero','Marzo','Abril',
                'Mayo','Junio','Julio','Agosto',
                'Septiembre','Octubre','Noviembre','Diciembre',
               ],
               dayOfWeek:[
                "Dom.", "Lun", "Mar", "Mie",
                "Jue", "Vie", "Sab",
               ]
              }
             },
             timepicker:false,
             format:'d/m/Y'
            });
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        </script>
    @yield('script')
  </body>
</html>