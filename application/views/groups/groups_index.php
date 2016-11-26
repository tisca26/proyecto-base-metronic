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
                    <span><?php echo trans_line('breadcrumb_groups'); ?></span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="portlet light ">
                    <div class="portlet-body">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', '</div>'); ?>
                        <?php echo get_bootstrap_alert(); ?>
                        <a href="<?php echo base_url_lang() . 'groups/form_insert' ?>" class="btn btn-success">
                            <i class="fa fa-plus"></i> <?php echo trans_line('agregar_grupo'); ?></a>
                        <hr>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="users_table">
                            <thead>
                            <tr>
                                <th> <?php echo trans_line('grupo_tabla'); ?></th>
                                <th> <?php echo trans_line('estatus_tabla'); ?></th>
                                <th> <?php echo trans_line('acciones_tabla'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rows as $grp): ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $grp->NAME; ?></td>
                                    <td> <i class="fa fa-<?php echo ($grp->ENABLE)? 'check' : 'close'; ?>"> </i></td>
                                    <td>
                                        <a href="<?php echo base_url_lang() . 'groups/form_edit/' . $grp->ID ?>"
                                           class="badge badge-primary badge-roundless"> <?php echo trans_line('editar_tabla'); ?> </a>
                                        <a class="badge badge-danger badge-roundless delete_confirmation"
                                           data-toggle="confirmation" data-placement="top"
                                           data-original-title="<?php echo trans_line('confirmacion_borrado_titulo'); ?>"
                                           data-btn-ok-label="<?php echo trans_line('confirmacion_borrado_ok'); ?>"
                                           data-btn-ok-icon="icon-like" data-btn-ok-class="btn-success"
                                           data-btn-cancel-label="<?php echo trans_line('confirmacion_borrado_cancel'); ?>"
                                           data-btn-cancel-icon="icon-close" data-btn-cancel-class="btn-danger"
                                           data-id="<?php echo $grp->ID ?>">
                                            <?php echo trans_line('borrar_tabla'); ?>
                                        </a>
                                        <a href="<?php echo base_url_lang() . 'acl/form_acl/' . $grp->ID . '/1'; ?>"
                                           class="badge badge-info badge-roundless"> <?php echo trans_line('permisos_tabla'); ?> </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
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
        var table = $('#users_table');
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": "<?php echo trans_line('sortAscending'); ?>",
                    "sortDescending": "<?php echo trans_line('sortDescending'); ?>"
                },
                "emptyTable": "<?php echo trans_line('emptyTable'); ?>",
                "info": "<?php echo trans_line('info'); ?>",
                "infoEmpty": "<?php echo trans_line('infoEmpty'); ?>",
                "infoFiltered": "<?php echo trans_line('infoFiltered'); ?>",
                "lengthMenu": "<?php echo trans_line('lengthMenu'); ?>",
                "search": "<?php echo trans_line('search'); ?>",
                "zeroRecords": "<?php echo trans_line('zeroRecords'); ?>",
                "paginate": {
                    "previous": "<?php echo trans_line('previous'); ?>",
                    "next": "<?php echo trans_line('next'); ?>",
                    "last": "<?php echo trans_line('last'); ?>",
                    "first": "<?php echo trans_line('first'); ?>"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 9,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {
                    "sortable": false,
                    "targets": [1, 2]
                },
                {
                    "className": "text-center",
                    "targets": [1, 2]
                }
            ],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        $('.delete_confirmation').on('confirmed.bs.confirmation', function () {
            var id = $(this).attr('data-id');
            window.location.href = "<?php echo base_url_lang() . 'groups/delete_group/' ?>" + id;
        });
    });// FIN DOCUMENT READY
</script>