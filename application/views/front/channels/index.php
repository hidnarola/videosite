<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        <h2>Basic Table</h2>
        <a href="<?php echo base_url().'user_channels/add'; ?>" class="btn btn-primary" title=""> Add Channel </a>
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
                    if(!empty($all_channels)) { 
                        foreach($all_channels as $channel) {
                ?>
                    <tr>
                        <td><?php echo $channel['channel_name']; ?></td>
                        <td><?php echo $channel['channel_slug']; ?></td>
                        <td>
                            <a href="<?php echo base_url().'user_channels/edit/'.$channel['id']; ?>" title="" class="btn btn-success">  Edit </a>
                            <a href="<?php echo base_url().'user_channels/delete/'.$channel['id']; ?>" title="" class="btn btn-danger"> Delete </a>                            
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
