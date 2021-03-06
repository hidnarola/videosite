<!--<script type="text/javascript" src="<?php // echo DEFAULT_ADMIN_JS_PATH . "pages/datatables_data_sources.js";                   ?>"></script>-->
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Sub User List</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i>Admin</a></li>
            <li>Sub User</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">

    <?php
    $message = $this->session->flashdata('message');
    echo my_flash($message);
    ?>

    <!-- content area -->    
    <div class="panel panel-flat">
        <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/users/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-user-plus"></i></b> Add new user</a>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>User ID.</th>
                    <th>User Role</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th> 
<!--                    <th>No. Of Blogs</th> 
                    <th>No. Of Videos</th> 
                    <th>No. Of Galleries</th> 
                    <th>Last Login</th>                       -->
                    <th>Created Date</th>                        
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>    
</div>
<?php // echo $count; die;?>
<script>
    $(function () {
        $('.datatable-basic').dataTable({
            processing: true,
            serverSide: true,
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: "First Name,Last Name,Email,...",
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
            },
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            order: [[0, "asc"]],
            ordering: false,
            ajax: 'users/list_user',
            columns: [
                {
                    data: "test_id",
                    visible: true,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    sortable: false,
                    data: "role_name",
                    visible: true
                },
                {
                    sortable: false,
                    data: "fname",
                    visible: true
                },
                {
                    sortable: false,
                    data: "lname",
                    visible: true
                },
                {
                    sortable: false,
                    data: "email_id",
                    visible: true
                },
//                {
//                    sortable: false,
//                    data: "blog",
//                    visible: false
//                },
//                {
//                    sortable: false,
//                    data: "video",
//                    visible: false
//                },
//                {
//                    sortable: false,
//                    data: "gallery",
//                    visible: false
//                },
//                {
//                    sortable: false,
//                    data: "last_login",
//                    visible: false,
//                    render: function (data, type, full, meta) {
//                        var login_date = '';
//                        if (data) {
//                            login_date = data;
//                        } else {
//                            login_date = '-';
//                        }
//                        return login_date;
//                    },
//                },
                {
                    sortable: false,
                    data: "created_at",
                    visible: true
                },
                {
                    data: "is_account_close",
                    visible: true,
                    searchable: false,
                    sortable: false,
                    width: 200,
                    render: function (data, type, full, meta) {
                        var action = '';
//                        var id = encodeURIComponent(btoa(full.id));
                        if (full.is_blocked == '0') {
                            action += '<a href="<?php echo base_url(); ?>admin/users/view_post/' + full.id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded btn-sm" title="View Posts"><i class="icon-books"></i></a>&nbsp;&nbsp;';
//                            action += '<a href="<?php echo base_url(); ?>admin/users/view_video/' + id + '" class="btn border-indigo text-indigo-600 btn-flat btn-icon btn-rounded btn-sm" title="View"><i class="icon-video-camera"></i></a>&nbsp;&nbsp;';
//                            action += '<a href="<?php echo base_url(); ?>admin/users/view_gallery/' + id + '" class="btn border-teal text-teal-600 btn-flat btn-icon btn-rounded btn-sm" title="View"><i class="icon-images2"></i></a>&nbsp;&nbsp;';
                            action += '<a href="<?php echo base_url(); ?>admin/users/edit/' + full.id + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm" title="Edit"><i class="icon-pencil3"></i></a>';
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/block/' + full.id + '" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded"  title="Block"><i class="icon-blocked"></i></a>';
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/delete/' + full.id + '" class="btn border-danger btn_delete text-danger-600 btn-flat btn-icon btn-rounded" title="Delete"><i class="icon-cross2"></i></a>';
                        } else if (full.is_blocked == 1) {
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/activate/' + full.id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"  title="Unblock"><i class="icon-checkmark-circle"></i></a>';
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/delete/' + full.id + '" class="btn border-danger btn_delete text-danger-600 btn-flat btn-icon btn-rounded" title="Delete"><i class="icon-cross2"></i></a>';
                        }
                        return action;
                    }
                }
            ]
        });
        $(document).on("click", ".btn_delete", function (e) {
            e.preventDefault();
            var lHref = $(this).attr('href');
            bootbox.confirm('Are you sure ?', function (res) {
                if (res) {
                    window.location.href = lHref;
                }
            });
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });
</script>