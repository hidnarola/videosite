<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller
{

    var $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['admin/Admin_category_model']);
        $this->load->library(['encryption', 'upload']);
        check_admin_login();
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index()
    {
        $data['subview'] = 'admin/categories/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Contact Inquiry list page
     */
    public function list_category()
    {
        $final['recordsTotal'] = $this->Admin_category_model->get_category_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_category_model->get_all_category();
        echo json_encode($final);
    }

    public function action($action, $user_id)
    {

        $where = 'id = ' . decode($this->db->escape($user_id));
        $check_user = $this->Admin_category_model->get_result('categories', $where);
        if ($check_user)
        {
            if ($action == 'delete')
            {
                $update_array = array(
                    'is_deleted' => 1
                );
                $this->session->set_flashdata('message', ['message' => 'Category successfully deleted!', 'class' => 'alert alert-success']);
            }
            elseif ($action == 'block')
            {
                $update_array = array(
                    'is_blocked' => 1
                );
                $this->session->set_flashdata('message', ['message' => 'Category successfully blocked!', 'class' => 'alert alert-success']);
            }
            else
            {
                $update_array = array(
                    'is_blocked' => 0
                );
                $this->session->set_flashdata('message', ['message' => 'Category successfully unblocked!', 'class' => 'alert alert-success']);
            }
            $this->Admin_category_model->update_record('categories', $where, $update_array);
        }
        else
        {
            $this->session->set_flashdata('message', ['message' => 'Invalid request. Please try again!', 'class' => 'alert alert-danger']);
        }
        redirect('admin/categories');
    }

    /**
     *  Load view for Edit blog 
     * */
    public function edit()
    {
        $category_id = decode($this->uri->segment(4));
        if (is_numeric($category_id))
        {
            $where = 'id = ' . $this->db->escape($category_id);
            $check_category = $this->Admin_category_model->get_result('categories', $where);
            if ($check_category)
            {
                $data['record'] = $check_category[0];
                $data['title'] = 'Admin edit category';
                $data['heading'] = 'Edit category';
            }
            else
            {
                show_404();
            }
        }
        if ($this->input->post())
        {
            $update_array = [
                'category_name' => $this->input->post('category_name'),
                'is_blocked' => $this->input->post('is_blocked'),
                'icon' => $this->input->post('icon')
            ];

            $result = $this->Admin_category_model->update_record('categories', $where, $update_array);
            if ($result)
            {
                $msg = '';
                $this->session->set_flashdata('message', ['message' => 'Category successfully updated!' . $msg, 'class' => 'success']);
            }
            else
            {

                $this->session->set_flashdata('message', ['message' => 'Error Into Update Category!', 'class' => 'danger']);
            }
            redirect('admin/categories');
        }
        $data['subview'] = 'admin/categories/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Load view for Add blog 
     * */
    public function add()
    {
        // die;
        $data['title'] = 'Admin add category';
        $data['heading'] = 'Add category';

        if ($this->input->post())
        {
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
            $insert_array = [
                'category_name' => $this->input->post('category_name'),
                'created_at' => date("Y-m-d H:i:s a"),
                'is_blocked' => $this->input->post('is_blocked'),
                'icon' => $this->input->post('icon')
            ];
            
            $result = $this->Admin_category_model->insert_record('categories', $insert_array);
            if ($result)
            {
                $this->session->set_flashdata('message', ['message' => 'Category successfully Inserted!' . $msg, 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Category!', 'class' => 'danger']);
            }
            redirect('admin/categories');
        }
        $data['subview'] = 'admin/categories/manage';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Check For CAtegory Name Already Exist or Not
     * */
    public function check_category_name_exists($id = 0)
    {
        if (array_key_exists('category_name', $_POST))
        {
            if ($this->Admin_category_model->CheckSubExist($this->input->post('category_name'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

    public function block($id)
    {
        $id = decode($id);

        $this->Admin_category_model->update_record('categories', ['id' => $id], ['is_blocked' => '1']);
        $this->Admin_category_model->update_record('sub_categories', ['main_cat_id' => $id], ['is_blocked' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Category Successfully blocked.', 'class' => 'success']);
        redirect('admin/categories');
    }

    public function activate($id)
    {
        $id = decode($id);
        $this->Admin_category_model->update_record('categories', ['id' => $id], ['is_blocked' => '0']);
        $this->Admin_category_model->update_record('sub_categories', ['main_cat_id' => $id], ['is_blocked' => '0']);
        $this->session->set_flashdata('message', ['message' => 'Category Successfully activated.', 'class' => 'success']);
        redirect('admin/categories');
    }

    public function delete($id)
    {
        $id = decode($id);
        $this->Admin_category_model->update_record('categories', ['id' => $id], ['is_deleted' => '1']);
        $this->Admin_category_model->update_record('sub_categories', ['main_cat_id' => $id], ['is_deleted' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Category Successfully deleted.', 'class' => 'success']);
        redirect('admin/categories');
    }

    public function select_icon()
    {
        $data['subview'] = 'admin/categories/icon';
        $this->load->view('admin/layouts/layout_main', $data);
    }

}
