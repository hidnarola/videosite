<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="form-element">
    <h3 class="h3-title">Add Blog</h3>
    
    <a href="<?php echo base_url().'user_post/add_post_slide/'.$post_id; ?>" class="btn btn-primary"> Add Slide </a>
    <br>
    <br>
    <form method="post" action="" id="frmblog" enctype="multipart/form-data">

        <ul class="list-group drag-ul" id="sortable" >
            <?php 
                if(!empty($all_slides)) {  
                    foreach($all_slides as $key=>$slide) {
                        if($post_type == 'blog'){
                            $title = $slide['blog_title']; 
                            $desc = $slide['blog_description'];
                        }else{
                            $title = $slide['title']; 
                            $desc = $slide['description'];
                        }
            ?>
            <li class="list-group-item" id="<?php echo $slide['id']; ?>">

                <div class="listing-l-div cursor_pointer">
                    <div class="big-img">
                        <a href="">
                            <img src="<?php echo base_url().$slide['img_path']; ?>" alt="" />
                        </a>
                        <span><?php echo $key + 1; ?> <small>of <?php echo count($all_slides); ?></small></span>
                        <div class="option-02">
                            <a  class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <a data-id="<?php echo $slide['id']; ?>" data-type="<?php echo $post_type; ?>" data-post="<?php echo $post_id; ?>" 
                               onclick="delete_confirm(this)" class="btn btn-danger cursor_pointer"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="list-content">
                        <h2><?php echo $title; ?></h2>                        
                    </div>
                </div>

                <!-- <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample_<?php echo $key; ?>" aria-expanded="false" aria-controls="collapseExample_<?php echo $key; ?>">
                    Slide <?php echo $key +1; ?> [ Drag Me ]
                </a>
                <div class="collapse" id="collapseExample_<?php echo $key; ?>">
                    <div class="card card-body">
                        <p><?php echo $title; ?></p>
                    </div>
                </div> -->
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
                console.log(data);
            }
        });        
    });

    function delete_confirm(obj){
        var slide_id = $(obj).data('id');
        var slide_type = $(obj).data('type');
        var post_id = $(obj).data('post');

        bootbox.confirm("Are you sure ?", 
            function(result){
                if(result){
                    window.location.href="<?php echo base_url().'user_post/delete_post_slide/'; ?>"+slide_id+'/'+slide_type +'/' + post_id;
                }
            }
        );
    }
  

</script>
<!-- / -->