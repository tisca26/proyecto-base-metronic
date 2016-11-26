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
                    <a href="<?php echo base_url_lang() . 'users'; ?>"><?php echo trans_line('breadcrumb_users'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo trans_line('breadcrumb_users_agregar'); ?></span>
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
                        <?php echo form_open('users/insert_user', array('id' => 'current_form')); ?>
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
                                        <?php echo form_input('nick', set_value('nick'), 'id="nick" placeholder="' . trans_line('username_placeholder_usuario') . '" class="form-control"'); ?>
                                        <label for="nick"><?php echo trans_line('username_usuario'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                            class="help-block"><?php echo trans_line('username_usuario_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-checkboxes">
                                        <label for=""><?php echo trans_line('estatus'); ?></label>
                                        <div class="md-checkbox-list">
                                            <div class="md-checkbox">
                                                <input type="checkbox" id="enableuser" name="enableuser" value="1"
                                                       class="md-check" <?php echo set_checkbox('enableuser', '1'); ?>>
                                                <label for="enableuser">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span
                                                        class="box"></span> <?php echo trans_line('estatus_activo'); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('nombre', set_value('nombre'), 'id="nombre" placeholder="' . trans_line('nombre_placeholder') . '" class="form-control"'); ?>
                                        <label for="nombre"><?php echo trans_line('nombre'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('nombre_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('apellidos', set_value('apellidos'), 'id="apellidos" placeholder="' . trans_line('apellidos_placeholder') . '" class="form-control"'); ?>
                                        <label for="apellidos"><?php echo trans_line('apellidos'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('apellidos_ayuda'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('password', set_value('password'), 'id="password" placeholder="' . trans_line('contrasena_placeholder') . '" class="form-control"'); ?>
                                        <label for="password"><?php echo trans_line('contrasena'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('contrasena_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('repassword', set_value('repassword'), 'id="repassword" placeholder="' . trans_line('recontrasena_placeholder') . '" class="form-control"'); ?>
                                        <label for="repassword"><?php echo trans_line('recontrasena'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('recontrasena_ayuda'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('correo', set_value('correo'), 'id="correo" placeholder="' . trans_line('email_placeholder') . '" class="form-control"'); ?>
                                        <label for="correo"><?php echo trans_line('email'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span class="help-block"><?php echo trans_line('email_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-radios">
                                        <label for="form_control_1"><?php echo trans_line('grupo'); ?></label>
                                        <div class="md-radio-list">
                                            <?php foreach ($groups as $gr): ?>
                                                <div class="md-radio">
                                                    <input type="radio" id="radio_group_<?php echo $gr->ID; ?>"
                                                           name="radio_group" value="<?php echo $gr->ID; ?>"
                                                           class="md-radiobtn" <?php echo set_radio('radio_group', $gr->ID); ?>>
                                                    <label for="radio_group_<?php echo $gr->ID ?>">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> <?php echo $gr->NAME; ?> </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green">Guardar</button>
                                    <a class="btn default" href="<?php echo base_url_lang() . 'users' ?>">Regresar</a>
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

        var form1 = $('#current_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                nick: {
                    required: "<?php echo trans_line('required'); ?>",
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>")
                },
                nombre: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>"
                },
                apellidos: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>"
                },
                password: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>"
                },
                repassword: {
                    required: "<?php echo trans_line('required'); ?>",
                    equalTo: "<?php echo trans_line('equal_to_pass'); ?>"
                },
                correo: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>",
                    email: "<?php echo trans_line('correo'); ?>"
                },
                radio_group: {
                    required: "<?php echo trans_line('required'); ?>"
                }
            },
            rules: {
                nick: {
                    minlength: 3,
                    required: true
                },
                nombre: {
                    minlength: 3,
                    required: true
                },
                apellidos: {
                    minlength: 3,
                    required: true
                },
                password: {
                    minlength: 2,
                    required: true
                },
                repassword: {
                    required: true,
                    equalTo: "#password"
                },
                correo: {
                    minlength: 3,
                    required: true,
                    email: true
                },
                radio_group: {
                    required: true
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