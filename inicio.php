<!DOCTYPE html>
<html>
<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title>DEM-RRHH</title>
  <meta name="keywords" content="Manejador de contenido" />
  <meta name="description" content="AbsoluteAdmin - A Responsive HTML5 Admin UI Framework">
  <meta name="author" content="AbsoluteAdmin/gsantucci-github:santu1987">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="site_media/img/favicon.ico" />
  <!--- BLOQUE DE CSS -->
  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
  <link rel="stylesheet" type="text/css" href="site_media/css/index.css">
  <link rel="stylesheet" type="text/css" href="site_media/css/theme.css">
  <link rel="stylesheet" type="text/css" href="site_media/css/admin-forms.css">
  <link rel="stylesheet" type="text/css" href="site_media/css/main.css">
  <link rel="stylesheet" type="text/css" href="site_media/css/bootstrap-select.css">
  <link rel="stylesheet" type="text/css" href="site_media/css/bootstrap.css">
  <link href="site_media/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="shortcut icon" href="site_media/img/favicon.ico">
  <!-- Datatables CSS -->
  <link rel="stylesheet" type="text/css" href="site_media/plugins/datatable/css/dataTables.bootstrap.css">
  <!-- Datatables Editor Addon CSS -->
  <link rel="stylesheet" type="text/css" href="site_media/plugins/datatable/css/dataTables.editor.css">
  <!-- Datatables ColReorder Addon CSS -->
  <link rel="stylesheet" type="text/css" href="site_media/plugins/datatable/css/dataTables.colReorder.min.css">
</head>
<body class="admin-elements-page" data-spy="scroll" data-target="#nav-spy" data-offset="300" onload="nobackbutton();">
  <!-- Start: Main -->
  <div id="main">
    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top navbar-shadow bg-info">
      <div class="navbar-branding">
        <a class="navbar-brand" href="dashboard.html">
          <b>DEM</b>-RRHH Horas Extras
        </a>
        <span id="toggle_sidemenu_l">
          <i class="fa fa-bars"></i>
        </span>
      </div>
      <ul class="nav navbar-nav navbar-left">
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown menu-merge">
          <a href="admin_forms-elements.html#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
          	<img src="site_media/img/user.png" alt="avatar" class="mw30 br64">
          	<span class="hidden-xs pl15" id="tipo_usuario2"></span>
            <span class="caret caret-tp hidden-xs"></span>
          </a>
          <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
            <li class="dropdown-header clearfix">
            </li>
            <li class="dropdown-footer">
              <a href="#" class="" id="cerrar_session" name="cerrar_session">
              <span class="fa fa-power-off pr5"></span> Cerrar </a>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- End: Header -->
    <!-- Start: Barra Izquierda -->
    <aside id="sidebar_left" class="nano nano-light affix">
      <!-- Start: Sidebar Left Content -->
      <div class="sidebar-left-content nano-content">
        <!-- Start: Sidebar Header -->
        <header class="sidebar-header">
          <!-- Sidebar Widget - Author -->
          <div class="sidebar-widget author-widget">
            <div class="media">
              <a class="media-left" href="admin_forms-elements.html#">
                <img src="site_media/img/user.png" class="img-responsive">
              </a>
              <div class="media-body">
                <div class="media-links">
                   <a href="admin_forms-elements.html#" class="sidebar-menu-toggle">@<span id="nombre_usuario"></span> -</a> <a id="cerrar_session2" name="cerrar_session2" href="#">Cerrar</a>
                </div>
                <div class="media-author"><span id="tipo_usuario"></span></div>
              </div>
            </div>
          </div>
          <!-- End-Author -->
        </header>
        <!-- End: Sidebar Header -->
        <!-- Menu izquierdo -->
        <!-- Start: Sidebar Menu -->
        <ul class="nav sidebar-menu">
          <li class="sidebar-label pt20">Menu</li>
          <!-- Cargar horas extras -->
          <li id="op_cargar_horas_li" class="ocultar">
            <a class="accordion-toggle" href="" id="op_constancias">
                <span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                <span class="sidebar-title">Carga de horas extras</span>  
            </a>
          </li>
          <!-- Validar horas extras-->
          <li id="op_validar_horas_li" class="ocultar">
            <a class="accordion-toggle" href="" id="op_constancias">
                <span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                <span class="sidebar-title">Validar horas extras</span>  
            </a>
          </li>
          <!-- Generar TXT-->
          <li id="op_cargar_horas_li" class="ocultar">
            <a class="accordion-toggle" href="" id="op_constancias">
                <span><i class="fa fa-file-excel-o" aria-hidden="true"></i></span>
                <span class="sidebar-title">Generar TXT</span>  
            </a>
          </li>
          <!-- Administrar-->
          <li>
            <a href="#" style=" padding-left: 20px;" class="accordion-toggle"  id="op_usuarios">
              <i class="fa fa-address-card" aria-hidden="true"></i>
              <span class="sidebar-title">Administrar</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li id="op_usuarios_registros_li">
                <a href="" id="op_usuarios_registros">
                  <i class="fa fa-user-circle-o" aria-hidden="true"></i>  Registrar usuarios </a>
              </li>
              <li id="op_usuarios_permisos_li">
                <a href="" id="op_usuarios_permisos">
                  <i class="fa fa-cogs" aria-hidden="true"></i>   Asignar permisos </a>
              </li>
              <li>
                <a href="" id="op_adminsitrar_auditoria">
                  <i class="fa fa-database" aria-hidden="true"></i>  Auditoria
                </a>
              </li>
            </ul>  
          </li>
        </ul>
        <!-- END: Sidebar Menu -->
        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">
          <!-- Start: Topbar -->
          <!-- End: Topbar -->

          <!-- Begin: Content -->
          <section id="content" class="table-layout animated fadeIn">

          <!-- end: .tray-right -->
          </section>
          <!-- End: Content -->

        </section>
      </div>
    </aside>
    <!--Cuerpo de formularios -->
    <section id="content_wrapper">
    	<section id="content" class="table-layout">
    		<div id="cuerpo_principal" name="cuerpo_principal">
        <!-- -->
        <div class="cuerpo_ini">
          <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
            <div class="img_ppal">
                  <div id='icono_principal' class='options-circles options-circles-area'><i class="fa fa-balance-scale" aria-hidden="true" style="font-size: 40pt;margin-top: 14pt;"></i></div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
             <div class="texto_fila1"><h1>Dirección Ejecutiva de la Magistratura (D.E.M)</h1></div>
          </div>  
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="texto_fila1"><h1>Bienvenido a Admin template v:2.0</h1></div>
          </div>
        </div>
        <!-- -->  
        </div>
    	</section>
    </section>
    <!-- -->

  </div>
  <form id="form_inicio" name="form_inicio">
  </form>  
  <!-- End: Main -->
  <!-- BEGIN: PAGE SCRIPTS -->
  <!-- jQuery -->
  <script src="site_media/js/jquery-1.9.1.min.js"></script>
  <script src="site_media/js/jquery-ui.min.js"></script>
  <script src="site_media/js/jquery-migrate-1.1.0.min.js"></script>
  <script src="site_media/js/bootstrap-select.min.js"></script>
  <!-- Theme Javascript -->
  <script src="site_media/js/libs_template/utility.js"></script>
  <script src="site_media/js/libs_template/demo.js"></script>
  <script src="site_media/js/libs_template/main.js"></script>
  <script src="site_media/js/principal.js"></script>
  <script src="site_media/js/fbasic.js"></script>
  <!-- END: PAGE SCRIPTS -->
  <!--DATA TABLES-->
  <!-- Datatables -->
  <script src="site_media/plugins/datatable/js/jquery.dataTables.js"></script>
  <!-- Datatables Tabletools addon -->
  <script src="site_media/plugins/datatable/js/dataTables.tableTools.min.js"></script>
  <!-- Datatables ColReorder addon -->
  <script src="site_media/plugins/datatable/js/dataTables.colReorder.min.js"></script>
  <!-- Datatables Bootstrap Modifications  -->
  <script src="site_media/plugins/datatable/js/dataTables.bootstrap.js"></script>
  <!-- html to Markdown-->
  <script src="site_media/plugins/to-markdown/to-markdown.js"></script>  
  <!-- -->
  <!-- VIEWS-JS --> 
  <script src="site_media/js/views_js/inicio.js"></script>
  <!-- -->
</body>
</html>
