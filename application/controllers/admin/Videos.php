<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['admin/Admin_video_model']);
        $this->load->library(['encryption', 'upload']);
        check_admin_login();
    }

    /**
     * Function load view of blog list.
     */
    public function index()
    {

        $data['subview'] = 'admin/videos/index';
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

    /**
     * Function is used to perform action (Delete,Block,Unblock)
     */
    public function action($action, $video_id)
    {

        $where = 'id = ' . decode($this->db->escape($video_id));
        $check_video = $this->Admin_video_model->get_result('video', $where);
        if ($check_video)
        {
            if ($action == 'delete')
            {
                $update_array = array(
                    'is_deleted' => 1
                );
                $this->session->set_flashdata('message', ['message' => 'Video successfully deleted!', 'class' => 'success']);
            }
            elseif ($action == 'block')
            {
                $update_array = array(
                    'is_blocked' => 1
                );
                $this->session->set_flashdata('message', ['message' => 'Video successfully blocked!', 'class' => 'success']);
            }
            else
            {
                $update_array = array(
                    'is_blocked' => 0
                );
                $this->session->set_flashdata('message', ['message' => 'Video successfully unblocked!', 'class' => 'success']);
            }
            $this->Blogs_model->update_record('video', $where, $update_array);
        }
        else
        {
            $this->session->set_flashdata('message', ['message' => 'Invalid request. Please try again!', 'class' => 'danger']);
        }
        redirect(site_url('admin/videos'));
    }

    /**
     *  Load view for Edit blog 
     * */
    public function edit()
    {

        $video_id = decode($this->uri->segment(4));
        if (is_numeric($video_id))
        {
            $where = 'id = ' . $this->db->escape($video_id);
            $check_video = $this->Admin_video_model->get_result('video', $where);
            if ($check_video)
            {
                $data['record'] = $check_video[0];
                $data['title'] = 'Admin edit Video';
                $data['heading'] = 'Edit Video';
            }
            else
            {
                show_404();
            }
        }
        if ($this->input->post())
        {

            //--------------- For Multiple File Upload  -----------
            $img_path = '';
            $success = 0;
            $unsuccess = 0;
            if (isset($_FILES['upload_path']['name']) && $_FILES['upload_path']['name'][0] != NULL)
            {
                $location = 'uploads/videos/';
                foreach ($_FILES['upload_path']['name'] as $key => $data)
                {
                    $res = $this->filestorage->FileArrayInsert($location, 'upload_path', 'video', '10485760', $key); // 10 MB
                    if ($res['status'] == '1')
                    {
                        if ($key == 0)
                        {
                            $upload_path = $res['msg'];
                        }
                        else
                        {
                            $upload_path = $upload_path . "|" . $res['msg'];
                        }
                        $success = $success + 1;
                    }
                    else
                    {
                        $unsuccess = $unsuccess + 1;
                    }
                }
                //--------- For Delete Old Image -------
                if ($this->input->post('Hupload_path') != '')
                {
                    $old_upload = explode('|', $this->input->post('Hupload_path'));
                    foreach ($old_upload as $key => $upload)
                    {
                        $this->filestorage->DeleteImage($location, $upload);
                    }
                }
            }
            else
            {
                $img_path = $this->input->post('Hupload_path');
            }
            //----------------------------------------
            $update_array = [
                'user_id' => $this->session->userdata('admin')['id'],
                'title' => $this->input->post('title'),
                'slug' => $this->input->post('slug'),
                'description' => htmlspecialchars($this->input->post('description')),
                'upload_path' => $upload_path,
                'is_blocked' => $this->input->post('is_blocked'),
            ];

            $result = $this->Admin_video_model->update_record('video', $where, $update_array);
            if ($result)
            {
                $msg = '';
                if ($success != 0 || $unsuccess != 0)
                {
                    $msg = "<br>" . $success . " Video Uploaded Successfully <br>" . $unsuccess . " Video Not Upload";
                }
                $this->session->set_flashdata('message', ['message' => 'Video successfully updated!' . $msg, 'class' => 'success']);
            }
            else
            {

                $this->session->set_flashdata('message', ['message' => 'Error Into Update Video!', 'class' => 'danger']);
            }
            redirect('admin/videos');
        }
        $data['subview'] = 'admin/videos/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Load view for Add blog 
     * */
    public function add()
    {

        $data['title'] = 'Admin add Video';
        $data['heading'] = 'Add Video';
        if ($this->input->post())
        {
            //--------------- For Multiple File Upload  -----------
            $upload_path = '';
            $success = "0";
            $unsuccess = "0";
            if (isset($_FILES['upload_path']['name']) && $_FILES['upload_path']['name'][0] != NULL)
            {
                $location = 'uploads/videos/';
                pr($location);
                foreach ($_FILES['upload_path']['name'] as $key => $data)
                {
                    $res = $this->filestorage->FileArrayInsert($location, 'upload_path', 'video', '10485760', $key); // 10 MB
                    pr($res);
                    if ($res['status'] == '1')
                    {
                        if ($key == 0)
                        {
                            $upload_path = $res['msg'];
                            echo"if"; pr($upload_path); 
                        }
                        else
                        {
                            $upload_path = $upload_path . "|" . $res['msg'];
                            echo"else";pr($upload_path);
                        }
                        $success = $success + 1;
                        echo"if";pr($success);
                    }
                    else
                    {
                        $unsuccess = $unsuccess + 1;
                        echo"else";pr($unsuccess);
                    }
                }
                pr($_FILES);
            }
            //----------------------------------------
            $insert_array = [
                'user_id' => $this->session->userdata('admin')['id'],
                'title' => $this->input->post('title'),
                'slug' => $this->input->post('slug'),
                'description' => htmlspecialchars($this->input->post('description')),
                'upload_path' => $upload_path,
                'is_blocked' => $this->input->post('is_blocked'),
                'created_at' => date("Y-m-d H:i:s a"),
            ];
            pr($insert_array,1);
            $result = $this->Admin_video_model->insert_record('video', $insert_array);
            if ($result)
            {
                $msg = "<br>" . $success . " Video Uploaded Successfully <br>" . $unsuccess . " Video Not Upload";
                $this->session->set_flashdata('message', ['message' => 'Video successfully Inserted!' . $msg, 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Video!', 'class' => 'danger']);
            }
            redirect('admin/videos');
        }
        $data['subview'] = 'admin/videos/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For Blog Title Already Exist or Not
     * */
    public function check_video_title_exists($id = 0)
    {
        if (array_key_exists('title', $_POST))
        {
            if ($this->Admin_video_model->CheckExist($this->input->post('title'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

}
