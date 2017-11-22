<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserPost extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Post_model', 'Blogs_model', 'admin/Admin_video_model', 'admin/Admin_gallery_model']);
        check_admin_login();
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index()
    {
        $data['all_posts'] = $this->Post_model->get_all_posts();
        $data['subview'] = 'admin/userposts/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    public function view_blog()
    {
        $data['subview'] = 'admin/userposts/blog_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_blog()
    {
        $final['recordsTotal'] = $this->Blogs_model->get_blogs_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Blogs_model->get_all_blogs();
        echo json_encode($final);
    }

    public function view_video()
    {
        $data['subview'] = 'admin/userposts/video_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_video()
    {
        $final['recordsTotal'] = $this->Admin_video_model->get_videos_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_video_model->get_all_videos();
        echo json_encode($final);
    }

    public function view_gallery()
    {
        $data['subview'] = 'admin/userposts/gallery_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_gallery()
    {
        $final['recordsTotal'] = $this->Admin_gallery_model->get_gallery_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_gallery_model->get_all_gallery();
        echo json_encode($final);
    }

}
