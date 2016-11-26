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
                    <a href="<?php echo base_url_lang() . 'empresas'; ?>"><?php echo trans_line('breadcrumb_empresas'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo trans_line('breadcrumb_empresas_editar'); ?></span>
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
                        <?php echo form_open('empresas/editar_empresa', array('id' => 'current_form')); ?>
                        <input type="hidden" name="empresas_id" value="<?php echo $empr->empresas_id; ?>">
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
                                        <?php echo form_input('razon_social', set_value('razon_social', $empr->razon_social), 'id="razon_social" placeholder="' . trans_line('razon_social_placeholder') . '" class="form-control"'); ?>
                                        <label for="razon_social"><?php echo trans_line('razon_social'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                            class="help-block"><?php echo trans_line('razon_social_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('rfc', set_value('rfc', $empr->rfc), 'id="rfc" placeholder="' . trans_line('rfc_placeholder') . '" class="form-control"'); ?>
                                        <label for="rfc"><?php echo trans_line('rfc'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                            class="help-block"><?php echo trans_line('rfc_ayuda'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('telefono', set_value('telefono', $empr->telefono), 'id="telefono" placeholder="' . trans_line('telefono_placeholder') . '" class="form-control"'); ?>
                                        <label for="telefono"><?php echo trans_line('telefono'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                            class="help-block"><?php echo trans_line('telefono_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('email', set_value('email', $empr->email), 'id="email" placeholder="' . trans_line('email_placeholder') . '" class="form-control"'); ?>
                                        <label for="email"><?php echo trans_line('email'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                            class="help-block"><?php echo trans_line('email_ayuda'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <?php echo form_input('direccion', set_value('direccion', $empr->direccion), 'id="direccion" placeholder="' . trans_line('direccion_placeholder') . '" class="form-control"'); ?>
                                        <label for="direccion"><?php echo trans_line('direccion'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <span
                                            class="help-block"><?php echo trans_line('direccion_ayuda'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green">Guardar</button>
                                    <a class="btn default"
                                       href="<?php echo base_url_lang() . 'empresas' ?>">Regresar</a>
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
                razon_social: {
                    required: "<?php echo trans_line('required'); ?>",
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>")
                },
                rfc: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>",
                    maxlength: jQuery.validator.format("<?php echo trans_line('maxlength'); ?>")
                },
                telefono: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>",
                    maxlength: jQuery.validator.format("<?php echo trans_line('maxlength'); ?>"),
                    digits: "<?php echo trans_line('digits'); ?>"
                },
                email: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>",
                    email: "<?php echo trans_line('correo'); ?>"
                },
                direccion: {
                    minlength: jQuery.validator.format("<?php echo trans_line('minlength'); ?>"),
                    required: "<?php echo trans_line('required'); ?>",
                    maxlength: jQuery.validator.format("<?php echo trans_line('maxlength'); ?>")
                }
            },
            rules: {
                razon_social: {
                    minlength: 3,
                    required: true
                },
                rfc: {
                    minlength: 12,
                    required: true,
                    maxlength: 14
                },
                telefono: {
                    minlength: 10,
                    required: true,
                    maxlength: 14,
                    digits: true
                },
                email: {
                    minlength: 4,
                    required: true,
                    email: true
                },
                direccion: {
                    minlength: 3,
                    required: true,
                    maxlength: 490
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