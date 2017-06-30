<?php

if (!function_exists('generateRowsByLevel')) {
    /**
     * @param array $level The current navigation level array
     * @param string $output The output to be added to
     * @param lang language abreviature to genrate correct links
     * @param int $depth The current depth of the tree to determine classname
     */
    function generateRowsByLevel($level, &$output, $depth = 0.3)
    {
        foreach ($level as $row) {
            $output .= "<tr>";
            $output .= "<td class='text-center'>" . $row['menu_id'] . "</td>";
            $output .= "<td style='padding-left: " . $depth * 2.5  . "%;'>" . $row['nombre'] . "</td>";
            $output .= "<td class='text-center' >";
            $active = ($row['estatus'] == 1) ? 'check' : 'close';
            $output .= "<i class='fa fa-" . $active . "'> </i>";
            $output .= "</td>";
            $output .= "<td style='text-align:center' >" . $row['parent_id'] . "</td>";
            $output .= "<td class='text-center'>" . $row['orden'] . "</td>";
            $output .= "<td >" . $row['page_uri'] . "</td>";
            $output .= "<td >" . $row['icon'] . "</td>";
            $output .= '<td class="text-center">';
            $active = ($row['estatus'] == 1) ? 'Desactivar' : 'Activar';
            $output .= '<div class="clearfix">';
            $output .= '<button class="btn btn-sm yellow btn_estatus" data-toggle="confirmation" data-btn-cancel-label="No" data-btn-ok-label="Si" data-original-title="¿Desea cambiar el estatus de este registro?" title="Cambio de estatus" data-id="' . $row['menu_id'] . '"> ' . $active . ' <i class="fa fa-cog"></i></button>';
            $output .= '<a href="' . base_url('menu/editar/' . $row['menu_id']) . '" class="btn btn-sm blue"> <i class="fa fa-file-o"></i> Editar </a>';
            $output .= '<button class="btn btn-sm red btn_borrar" data-toggle="confirmation" data-btn-cancel-label="No" data-btn-ok-label="Si" data-original-title="¿Desea borrar este registro?" title="Borrar elemento" data-id="' . $row['menu_id'] . '"> Borrar <i class="fa fa-times"></i></button>';
            $output .= '</div>';
            $output .= "</td>";
            $output .= "</tr>";
            // if the row has any children, parse those to ensure we have a properly
            // displayed nested table
            if (!empty($row['children'])) {
                generateRowsByLevel($row['children'], $output, $depth + 1);
            }
        }
    }
}
?>

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
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-head">
                        <div class="container-fluid">
                            <div class="page-title">
                                <h1> Menu </h1>
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
                                    <span>Menu</span>
                                </li>
                            </ul>
                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light portlet-fit portlet-datatable ">
                                            <div class="portlet-title">
                                                <a type="button" class="btn btn-primary"
                                                   href="<?php echo base_url('menu/insertar'); ?>"> <i
                                                            class="fa fa-plus"></i> Agregar </a>
                                            </div>
                                            <div class="portlet-body">
                                                <?php echo get_bootstrap_alert(); ?>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center"> Menu ID</th>
                                                            <th> Nombre</th>
                                                            <th class="text-center"> Estatus</th>
                                                            <th class="text-center"> Padre</th>
                                                            <th class="text-center"> Orden</th>
                                                            <th> Url</th>
                                                            <th class="text-center"> Icono</th>
                                                            <th class="text-center"> Acciones</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $out = '';
                                                        generateRowsByLevel($navlist, $out);
                                                        echo $out; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <?php echo $this->cargar_elementos_manager->carga_simple('menus/menu_right'); ?>
                </div>
            </div>
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
<script src="<?php echo cdn_assets(); ?>global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js"
        type="text/javascript"></script>
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
        $('.btn_borrar').on('confirmed.bs.confirmation', function () {
            $id = $(this).attr('data-id');
            window.location.replace('<?php echo base_url()?>menu/borrar/' + $id);
        });

        $('.btn_estatus').on('confirmed.bs.confirmation', function () {
            $id = $(this).attr('data-id');
            window.location.replace('<?php echo base_url()?>menu/cambiar_estatus/' + $id);
        });
    })
</script>
</body>

</html>