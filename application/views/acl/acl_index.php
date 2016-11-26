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
                    <a href="<?php echo base_url_lang() . 'users'; ?>"><?php echo trans_line('breadcrumb_acl'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo trans_line('breadcrumb_acl_last'); ?></span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <?php echo get_bootstrap_alert(); ?>
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <span><?php echo trans_line('titulo_forma'); ?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', '</div>'); ?>
                        <?php echo form_open('acl/edit_acl', array('id' => 'current_form')); ?>
                        <div class="form-body">
                            <?php echo form_hidden('targetid', $targetid) ?>
                            <?php echo form_hidden('targettype', $targettype) ?>

                            <?php if (empty($rows)): ?>
                                <div class="message">
                                    <?php echo 'Sin información' ?>
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
                                        echo '<td>' . form_hidden('id[]', $row->RESOURCEID) . $row->RESOURCE . '</td>';
                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $r_name, 'id' => 'R' . $row->ID, 'value' => $row->ID, 'checked' => (bool)$row->R, $r_disable => '')) . '</td>';
                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $i_name, 'id' => 'I' . $row->ID, 'value' => $row->ID, 'checked' => (bool)$row->I, $i_disable => '')) . '</td>';
                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $u_name, 'id' => 'U' . $row->ID, 'value' => $row->ID, 'checked' => (bool)$row->U, $u_disable => '')) . '</td>';
                                        echo '<td class="text-center" >' . form_checkbox(array('name' => $d_name, 'id' => 'D' . $row->ID, 'value' => $row->ID, 'checked' => (bool)$row->D, $d_disable => '')) . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green">Guardar</button>
                                    <?php $dir = ($targettype == 1) ? 'groups' : 'users'; ?>
                                    <a class="btn default" href="<?php echo base_url_lang() . $dir ?>">Regresar</a>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
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

    });// FIN DOCUMENT READY
</script>