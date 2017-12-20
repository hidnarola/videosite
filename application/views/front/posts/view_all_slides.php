<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="form-element">
    <h3 class="h3-title">All Slides</h3>
    
    <a href="<?php echo base_url().'user_post/add_post_slide/'.$post_id; ?>" class="btn-black"> Add Slide </a>
    <br>
    <br>
    <form method="post" action="" id="frmblog" enctype="multipart/form-data">

        <ul class="developer list-group drag-ul" id="sortable" >
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
                            <img src="<?php echo base_url().$slide['img_path']; ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/>
                        </a>
                        <span id="span_id_<?php echo $slide['id']; ?>">
                            <?php echo $key + 1; ?>
                            <small>of 
                                <?php echo count($all_slides); ?>
                            </small>
                        </span>
                        <div class="option-02">
                            <a  class="btn btn-success" href="<?php echo base_url().'user_post/edit_post_slide/'.$slide['id'].'/'.$post_type; ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-id="<?php echo $slide['id']; ?>" data-type="<?php echo $post_type; ?>" data-post="<?php echo $post_id; ?>" 
                               onclick="delete_confirm(this)" class="btn btn-danger cursor_pointer"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="list-content">
                        <h2><?php echo $title; ?></h2>                        
                    </div>
                </div>                
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

                for(var i=1; i<=data.length; i++ ){
                    var new_str = i+'<small>of '+data.length+'</small>';
                    $('#span_id_'+data[i-1]).html(new_str);
                }

                $.ajax({
                    url:"<?php echo base_url().'user_post/sort_slide'; ?>",
                    method:"post",
                    dataType:"json",
                    data:{all_order_ids:data,post_type:"<?php echo $post_type; ?>"},
                    success:function(data){
                        
                        $.notify({              
                            message: data.success,
                        },{
                            // settings
                            allow_dismiss: true,
                            newest_on_top: false,
                            animate: {
                                enter: 'animated lightSpeedIn',
                                exit: 'animated lightSpeedOut'
                            },
                            template: '<div data-notify="container" class="success-msg col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                '<span data-notify="message">{2}</span>' +
                            '</div>'
                        });

                    }
                });
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