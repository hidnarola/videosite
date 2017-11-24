<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="jumbotron text-center">
        
        <h1><?php echo $res_channel['channel_name']; ?></h1>

        <?php if($user_loggedin == true) { ?>
            <?php if($is_user_subscribe == false) { ?>
                <a href="<?php echo base_url().'user_channels/subscribe_channel/'.$res_channel['id']; ?>" class="btn btn-success">
                    Subscribe
                </a>
            <?php } else { ?>
                <a href="<?php echo base_url().'user_channels/unsubscribe_channel/'.$res_channel['id']; ?>" class="btn btn-danger">
                    Un-Subscribe
                </a>
            <?php } ?>
        <?php } ?>
    </div>
  
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h3>Column 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
            </div>     
        </div>
    </div>

</body>
</html>
