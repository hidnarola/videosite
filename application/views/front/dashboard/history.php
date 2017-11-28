<div class="right-panel">
    <div class="container">
        <h2>User History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Post Title</th>
                    <th>Slug</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($history))
                {

                    foreach ($history as $his)
                    {
                        ?>
                        <tr>
                            <td><?php echo $his['username']; ?></td>
                            <?php
                            if ($his['post_type'] == 'blog')
                            {
                                ?>
                                <td><?php echo $his['blog_title']; ?></td>
                                <td><a href="<?php echo base_url() . 'blog/' . $his['slug']; ?>"><?php echo $his['slug']; ?></a></td>
                                <?php
                            }
                            elseif ($his['post_type'] == 'gallery')
                            {
                                ?>
                                <td><?php echo $his['gtitle']; ?></td>
                                <td><a href="<?php echo base_url() . 'gallery/' . $his['slug']; ?>"><?php echo $his['slug']; ?></a></td>
                            <?php
                            }
                            elseif ($his['post_type'] == 'video')
                            {
                                ?>
                                <td><?php echo $his['vtitle']; ?></td>
                                <td><a href="<?php echo base_url() . 'video/' . $his['slug']; ?>"><?php echo $his['slug']; ?></a></td>
                        <?php } ?>
                            
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <div id="pagination">
            <?php
            foreach ($links as $link)
            {
                echo $link;
            }
            ?>
        </div>

    </div>
</div>