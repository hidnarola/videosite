<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserPost extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Post_model']);
        check_admin_login();
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index()
    {
        // $data['all_posts'] = $this->Post_model->get_all_posts($id);
        $data['res_gallery'] = $this->db->get_where('user_post', ['post_type' => 'gallery', 'is_deleted' => '0'])->num_rows();
        $data['res_video'] = $this->db->get_where('user_post', ['post_type' => 'video', 'is_deleted' => '0'])->num_rows();
        $data['res_blog'] = $this->db->get_where('user_post', ['post_type' => 'blog', 'is_deleted' => '0'])->num_rows();
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
        $final['recordsTotal'] = $this->Post_model->get_blogs_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Post_model->get_all_blogs();
        echo json_encode($final);
    }

    public function block_blog($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_blocked' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Blog Successfully blocked.', 'class' => 'success']);
        redirect('admin/userpost/view_blog');
    }

    public function activate_blog($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_blocked' => '0']);
        $this->session->set_flashdata('message', ['message' => 'Blog Successfully activated.', 'class' => 'success']);
        redirect('admin/userpost/view_blog');
    }

    public function delete_blog($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_deleted' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Blog Successfully deleted.', 'class' => 'success']);
        redirect('admin/userpost/view_blog');
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
        $final['recordsTotal'] = $this->Post_model->get_videos_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Post_model->get_all_videos();
        echo json_encode($final);
    }

    public function block_video($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_blocked' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Video Successfully blocked.', 'class' => 'success']);
        redirect('admin/userpost/view_video');
    }

    public function activate_video($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_blocked' => '0']);
        $this->session->set_flashdata('message', ['message' => 'Video Successfully activated.', 'class' => 'success']);
        redirect('admin/userpost/view_video');
    }

    public function delete_video($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_deleted' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Video Successfully deleted.', 'class' => 'success']);
        redirect('admin/userpost/view_video');
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
        $final['recordsTotal'] = $this->Post_model->get_gallery_count(['post_type' => 'gallery']);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Post_model->get_all_gallery(['post_type' => 'gallery']);
        echo json_encode($final);
    }

    public function block_gallery($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_blocked' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Gallery Successfully blocked.', 'class' => 'success']);
        redirect('admin/userpost/view_gallery');
    }

    public function activate_gallery($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_blocked' => '0']);
        $this->session->set_flashdata('message', ['message' => 'Gallery Successfully activated.', 'class' => 'success']);
        redirect('admin/userpost/view_gallery');
    }

    public function delete_gallery($id)
    {
        $this->Post_model->update_record('user_post', ['id' => $id], ['is_deleted' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Gallery Successfully deleted.', 'class' => 'success']);
        redirect('admin/userpost/view_gallery');
    }

}
