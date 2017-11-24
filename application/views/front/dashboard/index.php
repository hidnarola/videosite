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
            <div class="jumbotron">
                <h1>Bootstrap Tutorial</h1>      
                <p>Bootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile-first projects on the web.</p>
            </div>

            <a href="<?php echo base_url() . 'dashboard/view_history'; ?>" class="btn btn-success" target="_blank">History</a>

            <p>User channel List</p>

            <?php
            if (!empty($all_channels))
            {
                foreach ($all_channels as $channel)
                {
                    ?>
                    <a href="<?php echo base_url() . 'channel/' . $channel['channel_slug']; ?>" class="btn btn-primary" target="_blank">
                        <?php echo $channel['channel_name']; ?>            
                    </a>
                    <br/>
                    <br/>
                <?php
                }
            }
            ?>

        </div>

    </body>
</html>
