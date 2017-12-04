<h2>Channels</h2>
<a href="<?php echo base_url() . 'user_channels/add'; ?>" class="btn btn-primary" title=""> Add Channel </a>
<table class="table">
    <thead>
        <tr>
            <th>Channel Name</th>
            <th>Channel Slug</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($all_channels))
        {
            foreach ($all_channels as $channel)
            {
                ?>
                <tr>
                    <td><?php echo $channel['channel_name']; ?></td>
                    <td><?php echo $channel['channel_slug']; ?></td>
                    <td>
                        <a href="<?php echo base_url() . 'user_channels/edit/' . $channel['id']; ?>" title="" class="btn btn-success">  Edit </a>
                        <!--<a href="<?php // echo base_url() . 'user_channels/delete/' . $channel['id']; ?>" title="" class="btn btn-danger"> Delete </a>-->                            
                        <a href="javascript:void(0)" onclick="delete_channel(<?php echo $channel['id'];?>)" title="delete" class="btn btn-danger"> Delete </a>                            
                    </td>
                </tr>
    <?php }
} ?>
    </tbody>
</table>

<script>
    
    var id = "<?php echo $channel['id'];?>";
    function delete_channel(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this channel!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plz!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = "<?php echo base_url(); ?>user_channels/delete/" + id;
                    } else {
                        swal("Cancelled", "Your user is safe :)", "error");
                    }
                });
    }
</script>