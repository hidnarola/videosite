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

        <?php 
            $res = $this->session->flashdata('message'); 
            if(isset($res)){
                echo $res['message'];
            }
        ?>
        <div class="container">
            <h2>Basic Table</h2>
            <a href="<?php echo base_url() . 'user_post/add_blog'; ?>" class="btn btn-primary" title=""> Add Blog </a>
            <a href="<?php echo base_url() . 'user_post/add_video'; ?>" class="btn btn-primary" title=""> Add Video </a>
            <a href="<?php echo base_url() . 'user_post/add_gallery'; ?>" class="btn btn-primary" title=""> Add Gallery </a>
<!--            <table class="table">
                <thead>
                    <tr>
                        <th>Channel Name</th>
                        <th>Channel Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($all_posts))
                    {
                        foreach ($all_posts as $post)
                        {
                            ?>
                            <tr>
                                <td><?php echo $post['channel_name']; ?></td>
                                <td><?php echo $post['channel_slug']; ?></td>
                                <td>
                                    <a href="<?php echo base_url() . 'user_post/edit/' . $post['id']; ?>" title="" class="btn btn-success">  Edit </a>
                                    <a href="<?php echo base_url() . 'user_post/delete/' . $post['id']; ?>" title="" class="btn btn-danger"> Delete </a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>-->
        </div>

    </body>
</html>
