<?php // pr($all_posts, 1);    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo DEFAULT_ADMIN_JS_PATH ?>jquery.jscroll"></script>
    </head>
    <body>

        <?php
        $res = $this->session->flashdata('message');
        if (isset($res))
        {
            echo $res['message'];
        }
        ?>
        <div class="container">
            <h2>Basic Table</h2>

            <a href="<?php echo base_url() . 'user_post/add_blog'; ?>" class="btn btn-primary" title=""> Add Blog </a>
            <div class="infinite-scroll">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Blog Title</th>
                            <th>Blog Slug</th>
                            <th>Video Title</th>
                            <th>Video Slug</th>
                            <th>Gallery Title</th>
                            <th>Gallery Slug</th>
                            <!--<th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($all_posts))
                        {
                            foreach ($all_posts as $post)
                            {
//                            if ($post['post_type'] == 'blog')
//                            {
                                ?>

                                <tr>
                                    <td><?php echo $post['blog_title']; ?></td>
                                    <td><?php echo $post['slug']; ?></td>
                                    <td><?php echo $post['vtitle']; ?></td>
                                    <td><?php echo $post['slug']; ?></td>
                                    <td><?php echo $post['gtitle']; ?></td>
                                    <td><?php echo $post['slug']; ?></td>
        <!--                                    <td>
                                        <a href="<?php echo base_url() . 'user_post/edit_blog/' . $post['id']; ?>" title="" class="btn btn-success">  Edit </a>
                                        <a href="<?php echo base_url() . 'user_post/delete_blog/' . $post['id']; ?>" title="" class="btn btn-danger"> Delete </a>                           
                                        <a href="<?php echo base_url() . 'user_post/view_blog/' . $post['id']; ?>" title="" class="btn btn-primary"> View </a>                           
                                    </td>-->
                                </tr>
                                <?php
//                            }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </body>
</html>
<!--<div class="scroll">
    <h3>Page 1</h3>
    <p>Content here...</p>
    <a href="example-page2.html">next page</a>
</div>-->
<script>
//    $('.scroll').jscroll();

    $('.infinite-scroll').jscroll();
    $('.infinite-scroll').jscroll({
        loadingHtml: '<img src="loading.gif" alt="Loading" /> Loading...',
        padding: 20,
        nextSelector: 'a.jscroll-next:last',
        contentSelector: 'li'
    });
</script>