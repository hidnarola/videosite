        <div class="container">
            <h2>User History</h2>
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
                    if (!empty($history))
                    {
                        foreach ($history as $key => $his)
                        {
                            ?>
                            <tr>
                                <td><?php echo $his['user_id']; ?></td>
                                <td><?php echo $his['post_id']; ?></td>
                                <!--<td><?php // echo $his['activity']; ?></td>-->
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>