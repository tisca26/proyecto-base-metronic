<?php

if (!function_exists('generateRowsByLevel')) {
    /**
     * @param array $level The current navigation level array
     * @param string $output The output to be added to
     * @param lang language abreviature to genrate correct links
     * @param int $depth The current depth of the tree to determine classname
     */
    function generateRowsByLevel($level, &$output, $depth = 0)
    {
        $depthClassMapping = array(0 => 'parent', 1 => 'child', 2 => 'grandchild');
        foreach ($level as $row) {
            $output .= "<tr>";
            $output .= "<td>" . $row['id'] . "</td>";
            $output .= "<td style='padding-left: " . $depth * 2.5 . "%;'>" . $row['name'] . "</td>";
            $output .= "<td class='text-center' >";
            $active = (strcmp($row['status'], 'active') == 0) ? 'check' : 'close';
            $output .= "<i class='fa fa-" . $active . "'> </i>";
            $output .= "</td>";
            $output .= "<td style='text-align:center' >" . $row['parentid'] . "</td>";
            $output .= "<td class='text-center'>" . $row['orderr'] . "</td>";
            $output .= "<td >" . $row['page_uri'] . "</td>";
            $output .= "<td >" . $row['icon'] . "</td>";
            $output .= '<td class="text-center">';
            $active = (strcmp($row['status'], 'active') == 0) ? trans_line('desactivar') : trans_line('activar');
            $output .= anchor_sin_url($active,
                array(
                    'class' => 'badge badge-warning badge-roundless activate_confirmation',
                    'data-toggle' => 'confirmation', 'data-placement' => 'top',
                    'data-original-title' => trans_line('confirmacion_desactivar_titulo'),
                    'data-btn-ok-label' => trans_line('confirmacion_desactivar_ok'),
                    'data-btn-ok-icon' => 'icon-like', 'data-btn-ok-class' => 'btn-success',
                    'data-btn-cancel-label' => trans_line('confirmacion_desactivar_cancel'),
                    'data-btn-cancel-icon' => "icon-close", 'data-btn-cancel-class' => 'btn-danger',
                    'data-id' => $row['id']
                ));
            $output .= '|';
            $output .= anchor('/menu/edit_menu/' . $row['id'], trans_line('editar'), array('class' => 'badge badge-primary badge-roundless'));
            $output .= '|';
            $output .= anchor_sin_url(trans_line('borrar'),
                array(
                    'class' => 'badge badge-danger badge-roundless delete_confirmation',
                    'data-toggle' => 'confirmation', 'data-placement' => 'top',
                    'data-original-title' => trans_line('confirmacion_borrado_titulo'),
                    'data-btn-ok-label' => trans_line('confirmacion_borrado_ok'),
                    'data-btn-ok-icon' => 'icon-like', 'data-btn-ok-class' => 'btn-success',
                    'data-btn-cancel-label' => trans_line('confirmacion_borrado_cancel'),
                    'data-btn-cancel-icon' => "icon-close", 'data-btn-cancel-class' => 'btn-danger',
                    'data-id' => $row['id']
                ));
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
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?php echo trans_line('titulo_pagina'); ?></h1>
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
                    <a href="<?php echo base_url_lang(); ?>"><?php echo trans_line('breadcrumb_home'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo trans_line('breadcrumb_menu'); ?></span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="portlet light ">
                    <div class="portlet-body">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', '</div>'); ?>
                        <?php echo get_bootstrap_alert(); ?>
                        <a href="<?php echo base_url_lang() . 'menu/insert_menu' ?>" class="btn btn-success">
                            <i class="fa fa-plus"></i> <?php echo trans_line('agregar_menu'); ?></a>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> <?php echo trans_line('id'); ?></th>
                                    <th> <?php echo trans_line('nombre'); ?></th>
                                    <th class="text-center"> <?php echo trans_line('estatus'); ?></th>
                                    <th class="text-center"> <?php echo trans_line('id_padre'); ?></th>
                                    <th class="text-center"> <?php echo trans_line('orden'); ?></th>
                                    <th> <?php echo trans_line('url'); ?></th>
                                    <th> <?php echo trans_line('icono'); ?></th>
                                    <th class="text-center"> <?php echo trans_line('acciones'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $output = "";
                                generateRowsByLevel($navlist, $output);
                                echo $output;
                                ?>
                                </tbody>
                            </table>
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
<script type="application/javascript">
    $(document).ready(function () {
        $('.delete_confirmation').on('confirmed.bs.confirmation', function () {
            var id = $(this).attr('data-id');
            window.location.href = "<?php echo base_url_lang() . '/menu/delete_menu/' ?>" + id;
        });
        $('.activate_confirmation').on('confirmed.bs.confirmation', function () {
            var id = $(this).attr('data-id');
            window.location.href = "<?php echo base_url_lang() . 'menu/change_menu_status/' ?>" + id;
        });
    });// FIN DOCUMENT READY
</script>