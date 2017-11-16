<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  
<html> 
    <?php $this->load->view('front/layouts/layout_header'); ?>
    <?php $this->load->view($subview); ?>
    <?php $this->load->view('front/layouts/layout_footer'); ?>
</body>
</html>