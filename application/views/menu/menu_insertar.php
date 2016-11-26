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
                    <a href="<?php echo base_url_lang() . 'users'; ?>"><?php echo trans_line('breadcrumb_menu'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo trans_line('breadcrumb_menu_agregar'); ?></span>
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
                        <?php echo form_open('menu/insert_menu', array('id' => 'current_form')); ?>
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <?php echo trans_line('jquery_invalid'); ?>
                            </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button>
                                <?php echo trans_line('jquery_valid'); ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('name', set_value('name'), 'id="name" placeholder="' . trans_line('name_placeholder') . '" class="form-control"'); ?>
                                        <label for="name"><?php echo trans_line('name'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                                class="help-block"><?php echo trans_line('name_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('shortdesc', set_value('shortdesc'), 'id="shortdesc" placeholder="' . trans_line('shortdesc_placeholder') . '" class="form-control"'); ?>
                                        <label for="shortdesc"><?php echo trans_line('shortdesc'); ?>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('shortdesc_ayuda'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_dropdown('parentid', $menus, '', 'class="form-control"') ?>
                                        <label for="parentid"><?php echo trans_line('parentid'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('parentid_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-checkboxes">
                                        <label for=""><?php echo trans_line('estatus'); ?></label>
                                        <div class="md-checkbox-list">
                                            <div class="md-checkbox">
                                                <input type="checkbox" id="status" name="status" value="1"
                                                       class="md-check" <?php echo set_checkbox('status', '1'); ?>>
                                                <label for="status">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> <?php echo trans_line('estatus_activo'); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-radios">
                                        <label for=""></label>
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" id="radio_res"
                                                       name="radiourl" value="0"
                                                       class="md-radiobtn" <?php echo set_radio('radiourl', 0, TRUE); ?>>
                                                <label for="radio_res">
                                                    <span></span>
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> <?php echo trans_line('resources'); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_dropdown('resource', $resources, '', 'id="resource" class="form-control"') ?>
                                        /<br/>
                                        <?php echo form_input('page_res', set_value('page_res'), 'id="page_res" placeholder="' . trans_line('resources_placeholder') . '" class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-radios">
                                        <label for=""></label>
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" id="radio_url"
                                                       name="radiourl" value="1"
                                                       class="md-radiobtn" <?php echo set_radio('radiourl', 1); ?>>
                                                <label for="radio_url">
                                                    <span></span>
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> <?php echo trans_line('resources_estandar'); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('page_uri', set_value('page_uri'), 'id="page_uri" placeholder="' . trans_line('page_uri_placeholder') . '" class="form-control"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('order', set_value('order'), 'id="order" placeholder="' . trans_line('order_placeholder') . '" class="form-control"'); ?>
                                        <label for="order"><?php echo trans_line('order'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('order_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('icon', set_value('icon'), 'id="icon" placeholder="' . trans_line('icono_placeholder') . '" class="form-control"'); ?>
                                        <label for="icon"><?php echo trans_line('icono'); ?>
                                        </label>
                                        <a class="badge badge-primary badge-roundless" href="<?php echo base_url_lang() . 'menu/icons'; ?>" target="_blank">Ver íconos</a>
                                        <span class="help-block"><?php echo trans_line('icono_ayuda'); ?></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green">Guardar</button>
                                    <a class="btn default" href="<?php echo base_url_lang() . 'menu' ?>">Regresar</a>
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
    var valida_radio_enlace = function () {
        if ($('#radio_res').is(':checked')) {
            $('#page_uri').prop('disabled', true);
            $('#resource').prop('disabled', false);
            $('#page_res').prop('disabled', false);
        }
        if ($('#radio_url').is(':checked')) {
            $('#page_uri').prop('disabled', false);
            $('#resource').prop('disabled', true);
            $('#page_res').prop('disabled', true);
        }
    };
    $(document).ready(function () {
        valida_radio_enlace();
        $("input[name=radiourl]:radio").change(function () {
            valida_radio_enlace();
        });

        var form1 = $('#current_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                name: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>"
                },
                parentid: {
                    required: "<?php echo trans_line('required'); ?>"
                },
                radiourl: {
                    required: "<?php echo trans_line('required'); ?>"
                },
                order: {
                    required: "<?php echo trans_line('required'); ?>",
                    digits: "<?php echo trans_line('digits'); ?>"
                }
            },
            rules: {
                name: {
                    minlength: 3,
                    required: true
                },
                parentid: {
                    required: true
                },
                radiourl: {
                    required: true
                },
                order: {
                    required: true,
                    digits: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();
                form.submit();
            }
        });

    });// FIN DOCUMENT READY
</script>