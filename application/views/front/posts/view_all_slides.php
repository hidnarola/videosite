<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="form-element">
    <h3 class="h3-title">Add Blog</h3>

    <form method="post" action="" id="frmblog" enctype="multipart/form-data">

        <ul class="list-group" id="sortable" >
            <?php 
                if(!empty($all_slides)) {  
                    foreach($all_slides as $key=>$slide) {
                        if($post_type == 'blog'){
                            $title = $slide['blog_title']; 
                        }else{
                            $title = $slide['title']; 
                        }
            ?>
            <li class="list-group-item" id="<?php echo $slide['id']; ?>">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample_<?php echo $key; ?>" aria-expanded="false" aria-controls="collapseExample_<?php echo $key; ?>">
                    Slide <?php echo $key +1; ?> [ Drag Me ]
                </a>
                <div class="collapse" id="collapseExample_<?php echo $key; ?>">
                    <div class="card card-body">
                        <p><?php echo $title; ?></p>
                    </div>
                </div>
                <!-- a.btn.btn-danger -->
            </li>
            <?php } } ?>
        </ul>

    </form>
    <!-- /login form -->
</div>    

<script type="text/javascript">
  
    $( function() {
        $( "#sortable" ).sortable({
            update: function (event, ui) {
                var data =  $( "#sortable" ).sortable( "toArray" );
                
            }
        });        
    });
  

</script>
<!-- / -->