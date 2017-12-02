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
                        <a href="<?php echo base_url() . 'user_channels/delete/' . $channel['id']; ?>" title="" class="btn btn-danger"> Delete </a>                            
                    </td>
                </tr>
    <?php }
} ?>
    </tbody>
</table>

