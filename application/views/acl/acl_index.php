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
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <div class="container-fluid">
                            <!-- BEGIN PAGE TITLE -->
                            <div class="page-title">
                                <h1> <?php echo $title; ?> </h1>
                            </div>
                            <!-- END PAGE TITLE -->
                        </div>
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">
                        <div class="container">
                            <!-- BEGIN PAGE BREADCRUMBS -->
                            <ul class="page-breadcrumb breadcrumb">
                                <li>
                                    <a href="<?php echo base_url(); ?>">Inicio</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Permisos</span>
                                </li>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                            <!-- BEGIN PAGE CONTENT INNER -->
                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light portlet-fit portlet-form ">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-settings font-dark"></i>
                                                    <span class="caption-subject font-dark sbold uppercase"> Asignación de Permisos </span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <?php echo get_bootstrap_alert(); ?>
                                                <?php echo validation_errors("<div class='alert alert-danger'>", "</div>"); ?>
                                                <?php echo form_open('acl/edit_acl', array('class' => 'horizontal-form', 'id' => 'form1')); ?>
                                                <?php echo form_hidden('targetid', $targetid) ?>
                                                <?php echo form_hidden('targettype', $targettype) ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php if (empty($rows)): ?>
                                                                <div class="message">
                                                                    <p>Sin información</p>
                                                                </div>
                                                            <?php else: ?>
                                                                <table class="table table-striped table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><?php echo 'Recurso'; ?></th>
                                                                        <th class="text-center"><?php echo 'R'; ?></th>
                                                                        <th class="text-center"><?php echo 'I'; ?></th>
                                                                        <th class="text-center"><?php echo 'U'; ?></th>
                                                                        <th class="text-center"><?php echo 'D'; ?></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    foreach ($rows as $row) {
                                                                        //if is an user
                                                                        $r_name = 'R[]';
                                                                        $i_name = 'I[]';
                                                                        $u_name = 'U[]';
                                                                        $d_name = 'D[]';
                                                                        $r_disable = '';
                                                                        $i_disable = '';
                                                                        $u_disable = '';
                                                                        $d_disable = '';
                                                                        if ($targettype == 2) {
                                                                            if ($row->R_G == 1) {
                                                                                $r_name = 'R';
                                                                                $r_disable = 'disabled';
                                                                            }
                                                                            if ($row->I_G == 1) {
                                                                                $i_name = 'I';
                                                                                $i_disable = 'disabled';
                                                                            }
                                                                            if ($row->U_G == 1) {
                                                                                $u_name = 'U';
                                                                                $u_disable = 'disabled';
                                                                            }
                                                                            if ($row->D_G == 1) {
                                                                                $d_name = 'D';
                                                                                $d_disable = 'disabled';
                                                                            }
                                                                        }
                                                                        echo '<tr>';
                                                                        echo '<td>' . form_hidden('id[]', $row->RESOURCEID) . $row->resource . '</td>';
                                                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $r_name, 'id' => 'R' . $row->resources_id, 'value' => $row->resources_id, 'checked' => (bool)$row->R, $r_disable => '')) . '</td>';
                                                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $i_name, 'id' => 'I' . $row->resources_id, 'value' => $row->resources_id, 'checked' => (bool)$row->I, $i_disable => '')) . '</td>';
                                                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $u_name, 'id' => 'U' . $row->resources_id, 'value' => $row->resources_id, 'checked' => (bool)$row->U, $u_disable => '')) . '</td>';
                                                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $d_name, 'id' => 'D' . $row->resources_id, 'value' => $row->resources_id, 'checked' => (bool)$row->D, $d_disable => '')) . '</td>';
                                                                        echo '</tr>';
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn green">Guardar</button>
                                                            <?php $dir = ($targettype == 1) ? 'groups' : 'users'; ?>
                                                            <a class="btn default" href="<?php echo base_url() . $dir ?>">Regresar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <?php echo $this->cargar_elementos_manager->carga_simple('menus/menu_right'); ?>
                </div>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
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
    })
</script>
</body>

</html>