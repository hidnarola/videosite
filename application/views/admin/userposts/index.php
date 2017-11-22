<!--<script type="text/javascript" src="<?php // echo DEFAULT_ADMIN_JS_PATH . "pages/datatables_data_sources.js";                            ?>"></script>-->
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Users' Post List</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i>Admin</a></li>
            <li>Users' Post</li>
        </ul>
    </div>
</div>
<?php // pr($post);die;?>
<!-- /page header -->

<!-- Content area -->
<div class="content">

    <?php
    $message = $this->session->flashdata('message');
    echo my_flash($message);
    ?>

    <!-- content area -->    
    <div class="panel panel-flat">
        <!--        <div class="panel-heading text-right">
                    <a href="<?php echo site_url('admin/users/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-user-plus"></i></b> Add new user</a>
                </div>-->
        <table class="table datatable-basic">
            <thead>
<!--                <tr>
                    <th>Total Posts</th>
                    <th><?php // echo array_sum([$post[0]['blog'], $post[0]['video'], $post[0]['gallery']]);  ?></th>
                </tr>-->
                <tr>
                    <th><?php // echo $post[0]['username'] . '\'s';  ?> Videos (<?php // echo $post[0]['video'];  ?>)</th>
                    <th><a href="<?php // echo base_url() . 'admin/users/view_video/' . $id;  ?>" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded btn-sm" title="View Videos"><i class="icon-video-camera"></i></a></th>
                </tr>
                <tr>
                    <th><?php // echo $post[0]['username'] . '\'s';  ?> Blogs (<?php // echo $post[0]['blog'];  ?>)</th>
                    <th><a href="<?php // echo base_url() . 'admin/users/view_blog/' . $id;  ?>" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded btn-sm" title="View Blogs"><i class="icon-blog"></i></a></th>
                </tr>
                <tr>
                    <th><?php // echo $post[0]['username'] . '\'s';  ?> Galleries (<?php // echo $post[0]['gallery'];  ?>)</th>
                    <th><a href="<?php // echo base_url() . 'admin/users/view_gallery/' . $id;  ?>" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm" title="View Gallery"><i class="icon-images2"></i></a></th>
                </tr>
            </thead>
        </table>
    </div>    
</div>
<?php // echo $count; die;?>
<script>
    $(function () {
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });
</script>