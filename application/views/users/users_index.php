<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="es" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>Bill E Zone</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Preview page of Metronic Admin Theme #3 for " name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN PAGE FIRST SCRIPTS -->
    <script src="<?php echo cdn_assets(); ?>global/plugins/pace/pace.min.js" type="text/javascript"></script>
    <!-- END PAGE FIRST SCRIPTS -->
    <!-- BEGIN PAGE TOP STYLES -->
    <link href="<?php echo cdn_assets(); ?>global/plugins/pace/themes/pace-theme-big-counter.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE TOP STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
          rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?php echo cdn_assets(); ?>global/plugins/datatables/datatables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
          rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo cdn_assets(); ?>global/css/components.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo cdn_assets(); ?>layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo cdn_assets(); ?>layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="<?php echo cdn_assets(); ?>layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid">
<div class="page-wrapper">
    <?php echo $this->cargar_elementos_manager->carga_simple('menus/menu_completo'); ?>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- ----------------------------------------------------- BEGIN CONTAINER ----------------------------------------------------- -->
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-head">
                        <div class="container-fluid">
                            <div class="page-title">
                                <h1>Usuarios</h1>
                            </div>
                        </div>
                    </div>
                    <div class="page-content">
                        <div class="container">
                            <ul class="page-breadcrumb breadcrumb">
                                <li>
                                    <a href="<?php echo base_url(); ?>">Inicio</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Usuarios</span>
                                </li>
                            </ul>
                            <!-- --------------------------- INICIO CONTENIDO --------------------------- -->
                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light portlet-fit portlet-datatable ">
                                            <div class="portlet-title">
                                                <a type="button" class="btn btn-primary" href="<?php echo base_url('users/insertar');?>"> <i class="fa fa-plus"></i> Agregar </a>
                                            </div>
                                            <div class="portlet-body">
                                                <?php echo get_bootstrap_alert(); ?>
                                                <table class="table table-striped table-bordered table-hover order-column"
                                                       id="tabla1">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center"> Username </th>
                                                        <th class="text-center"> Email </th>
                                                        <th class="text-center"> Apellidos </th>
                                                        <th class="text-center"> Nombres </th>
                                                        <th class="text-center"> Grupos </th>
                                                        <th class="text-center"> Estatus </th>
                                                        <th class="text-center"> Opciones </th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th class="text-center"> Username </th>
                                                        <th class="text-center"> Email </th>
                                                        <th class="text-center"> Apellidos </th>
                                                        <th class="text-center"> Nombres </th>
                                                        <th class="text-center"> Grupos </th>
                                                        <th class="text-center"> Estatus </th>
                                                        <th class="text-center"> Opciones </th>
                                                    </tr>
                                                    </tfoot>
                                                    <tbody>
                                                    <?php foreach ($usuarios as $usuario): ?>
                                                        <tr class="odd gradeX">
                                                            <td class="text-center"> <?php echo $usuario->username; ?> </td>
                                                            <td class="text-center"> <?php echo $usuario->email; ?> </td>
                                                            <td class="text-center"> <?php echo $usuario->apellido_paterno . ' ' . $usuario->apellido_materno; ?> </td>
                                                            <td class="text-center"> <?php echo $usuario->nombre; ?> </td>
                                                            <td class="text-center"> <?php echo $usuario->grupos; ?> </td>
                                                            <td class="text-center" data-order = "<?php echo $usuario->estatus; ?>"> <?php $status = ((bool)$usuario->estatus)? 'check' : 'times'; ?><i class="fa fa-<?php echo $status; ?>"></i> </td>
                                                            <td class="text-center">
                                                                <div class="clearfix">
                                                                    <button class="btn btn-sm red btn_borrar"
                                                                            data-toggle="confirmation"
                                                                            data-btn-cancel-label="No"
                                                                            data-btn-ok-label="Si"
                                                                            data-original-title="¿Desea borrar este registro?"
                                                                            title="Borrar elemento"
                                                                            data-id="<?php echo $usuario->usuarios_id; ?>">
                                                                        Borrar <i class="fa fa-times"></i>
                                                                    </button>

                                                                    <a href="<?php echo base_url('users/editar') . '/' . $usuario->usuarios_id; ?>" class="btn btn-sm blue">
                                                                        <i class="fa fa-file-o"></i> Editar </a>
                                                                    <a href="<?php echo base_url('acl/frm_acl/' . $usuario->usuarios_id . '/2'); ?>" class="btn btn-sm yellow">
                                                                        <i class="fa fa-lock"></i> Permisos </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- --------------------------- FIN CONTENIDO --------------------------- -->
                        </div>
                    </div>
                </div>
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <?php echo $this->cargar_elementos_manager->carga_simple('menus/menu_right'); ?>
                </div>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- -----------------------------------------------------END CONTAINER ----------------------------------------------------- -->
        </div>
    </div>
    <div class="page-wrapper-row">
        <?php echo $this->cargar_elementos_manager->carga_simple('footers/footer1'); ?>
    </div>
</div>

<!--[if lt IE 9]>
<script src="<?php echo cdn_assets(); ?>global/plugins/respond.min.js"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/excanvas.min.js"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo cdn_assets(); ?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo cdn_assets(); ?>global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo cdn_assets(); ?>global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo cdn_assets(); ?>layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="<?php echo cdn_assets(); ?>layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });

        $('.btn_borrar').on('confirmed.bs.confirmation', function () {
            $id = $(this).attr('data-id');
            window.location.replace('<?php echo base_url()?>users/borrar/' + $id);
        });

        var tabla1 = $('#tabla1');

        // begin: third table
        tabla1.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activar para ordenar la columna ascendentemente",
                    "sortDescending": ": activar para ordenar la columna descendentemente"
                },
                "emptyTable": "Sin datos disponibles",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered1 de _MAX_ total de registros)",
                "lengthMenu": "Ver _MENU_",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "previous": "Ant",
                    "next": "Sig",
                    "last": "Ult",
                    "first": "Prim"
                }
            },
            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "lengthMenu": [
                [6, 15, 20, -1],
                [6, 15, 20, "Todos"] // change per page values here
            ],
            // set the initial value
            "pageLength": 6,
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [6]
                }, {
                    "searchable": false,
                    "targets": [6]
                }

            ],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });
    })
</script>
</body>

</html>