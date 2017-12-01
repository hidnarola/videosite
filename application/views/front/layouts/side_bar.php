<?php
//  $controller_name = $this->router->fetch_class();
//  $method_name = $this->router->fetch_method();
$all_cms_pages = $this->db->get_where('cms_page',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();    

?>

<div class="left-panel">
    <div class="nav-div">
        <ul>
            <li>
                <a href="<?php echo base_url() ?>home">
                    <i class="icon-home">
                    </i> 
                    Home
                </a>
            </li>
            <?php 
                if(isset($all_cms_pages)){
                    foreach ($all_cms_pages as $key =>$cms){
                        if($cms['title'] != 'Home'){
//                            pr($cms);
            ?>
                            <li>
                                <a href="<?php echo base_url(). 'page/'.$cms['slug']; ?>">
                                    <i class="<?php echo $cms['icons']?>">
                                    </i> 
                                    <?php echo $cms['title']?>
                                </a>
                            </li>
            <?php } } } ?>
        </ul>
    </div>
    <div class="ad-div"><img src="<?php echo DEFAULT_ADMIN_IMAGE_PATH ?>front/left-add.jpg" alt="" /></div>
    <div class="category-nav nav-div">
        <ul>
            <?php
            foreach ($categories as $key => $cat)
            {
                ?>

                <li><a href="<?php echo base_url() . 'home/category_detail_page/' . $cat['id']; ?>" class="ct-link"> 
                        <i class="<?php echo $cat['icon'];?>">    
                        </i><?php echo $cat['category_name'] ?></a> <a href="" class="fa fa-angle-down arrow-down"></a></li>
                <ul class="sub-category">
                        <li><a href="">Category 01</a></li>
                        <li><a href="">Category 02</a></li>
                        <li><a href="">Category 03</a></li>
                        <li><a href="">Category 04</a></li>
                        <li><a href="">Category 05</a></li>
                        <li><a href="">Category 06</a></li>
                        <li><a href="">Category 07</a></li>
                        <li><a href="">Category 08</a></li>
                    </ul>
            <?php } ?>
        </ul>
    </div>
</div>

