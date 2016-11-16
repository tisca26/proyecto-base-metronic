<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Blank Page :D</h1>
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
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Layouts</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="note note-info">
                    <p> A black page template with a minimal dependency assets to use as a base for any custom page you create </p>
                </div>
                <p><?php echo $line . '<-line' ?></p>
                <?php echo trans_line('inicio_msg') . ' <-aqui' ?>
                <p>
                    URI -> <?php echo base_url() . lang_segment() ?>
                </p>
                <p>
                    Uri completa <?php echo base_url_lang(); ?>
                </p>
                <p>
                    <?php echo get_attr_session('ID') ?>
                </p>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
</div>