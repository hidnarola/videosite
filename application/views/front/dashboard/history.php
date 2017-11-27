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

    </body>
</html>
