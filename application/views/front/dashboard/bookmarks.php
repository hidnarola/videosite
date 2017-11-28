<div class="right-panel">
    <div class="container">
        <h2>User Bookmarks</h2>
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
                if (!empty($book))
                {

                    foreach ($book as $books)
                    {
                        ?>
                        <tr>
                            <td><?php echo $books['username']; ?></td>
                            <?php
                            if ($books['post_type'] == 'blog')
                            {
                                ?>
                                <td><?php echo $books['blog_title']; ?></td>
                                <td><a href="<?php echo base_url() . 'blog/' . $books['slug']; ?>"><?php echo $books['slug']; ?></a></td>
                                <?php
                            }
                            elseif ($books['post_type'] == 'gallery')
                            {
                                ?>
                                <td><?php echo $books['gtitle']; ?></td>
                                <td><a href="<?php echo base_url() . 'gallery/' . $books['slug']; ?>"><?php echo $books['slug']; ?></a></td>
                            <?php
                            }
                            elseif ($books['post_type'] == 'video')
                            {
                                ?>
                                <td><?php echo $books['vtitle']; ?></td>
                                <td><a href="<?php echo base_url() . 'video/' . $books['slug']; ?>"><?php echo $books['slug']; ?></a></td>
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