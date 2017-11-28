<div class="right-panel">
    <div class="container">
        <h2>User Bookmarks</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Post Title</th>
                    <!--<th>Activity</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($bookmark))
                {

                    foreach ($bookmark as $book)
                    {
                        ?>
                        <tr>
                            <td><?php echo $book->user_id; ?></td>
                            <td><?php echo $book->post_id; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <div id="pagination">
            <ul class="tsc_pagination">

                <!-- Show pagination links -->
                <?php
                foreach ($links as $link)
                {
                    echo "<li>" . $link . "</li>";
                }
                ?>
            </ul>
        </div>

    </div>
</div>