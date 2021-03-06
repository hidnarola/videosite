<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_categories extends CI_Controller
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
        $data['subview'] = 'admin/categories/sub_cat_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in Contact Inquiry list page
     */
    public function list_sub_category()
    {
        $final['recordsTotal'] = $this->Admin_category_model->get_sub_category_count();
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_category_model->get_all_sub_category();
        echo json_encode($final);
    }

    public function action($action, $user_id)
    {

        $where = 'id = ' . $this->db->escape($user_id);
        $check_user = $this->Admin_category_model->get_result('sub_categories', $where);
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
            $this->Admin_category_model->update_record('sub_categories', $where, $update_array);
        }
        else
        {
            $this->session->set_flashdata('message', ['message' => 'Invalid request. Please try again!', 'class' => 'alert alert-danger']);
        }
        redirect('admin/sub_categories');
    }

    /**
     *  Load view for Edit blog 
     * */
    public function edit()
    {
        $category_id = $this->uri->segment(4);
        if (is_numeric($category_id))
        {
            $where = 'id = ' . $this->db->escape($category_id);
            $check_category = $this->Admin_category_model->get_result('sub_categories', $where);
            if ($check_category)
            {
                $data['cat'] = $this->Admin_category_model->get_result('categories', ['is_deleted' => '0']);
                $data['record'] = $check_category[0];
                $data['title'] = 'Admin edit sub category';
                $data['heading'] = 'Edit sub category';
            }
            else
            {
                custom_admin_show_404();
            }
        }
        if ($this->input->post())
        {
            $update_array = [
                'main_cat_id' => $this->input->post('category'),
                'category_name' => $this->input->post('category_name'),
                'is_blocked' => $this->input->post('is_blocked'),
                'icon' => $this->input->post('icon')
            ];

            $result = $this->Admin_category_model->update_record('sub_categories', $where, $update_array);
            if ($result)
            {
                $msg = '';
                $this->session->set_flashdata('message', ['message' => 'Category successfully updated!' . $msg, 'class' => 'success']);
            }
            else
            {

                $this->session->set_flashdata('message', ['message' => 'Error Into Update Category!', 'class' => 'danger']);
            }
            redirect('admin/sub_categories');
        }
        $data['subview'] = 'admin/categories/manage_sub';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Load view for Add blog 
     * */
    public function add()
    {
        $data['title'] = 'Admin add sub category';
        $data['heading'] = 'Add sub category';
        $data['cat'] = $this->Admin_category_model->get_result('categories', ['is_deleted' => '0']);
        if ($this->input->post())
        {
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
            $this->form_validation->set_rules('field_keywords', 'Main Category', 'trim|required');
            $insert_array = [
                'main_cat_id' => $this->input->post('category'),
                'category_name' => $this->input->post('category_name'),
                'created_at' => date("Y-m-d H:i:s a"),
                'is_blocked' => $this->input->post('is_blocked'),
                'icon' => $this->input->post('icon')
            ];
            $result = $this->Admin_category_model->insert_record('sub_categories', $insert_array);
            if ($result)
            {
                $this->session->set_flashdata('message', ['message' => 'Sub Category successfully Inserted!' . $msg, 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Sub Category!', 'class' => 'danger']);
            }
            redirect('admin/sub_categories');
        }
        $data['subview'] = 'admin/categories/manage_sub';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    public function block($id)
    {
//        $id = $id;
        $this->Admin_category_model->update_record('sub_categories', ['id' => $id], ['is_blocked' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Category Successfully blocked.', 'class' => 'success']);
        redirect('admin/sub_categories');
    }

    public function activate($id)
    {
//        $id = $id;
        $this->Admin_category_model->update_record('sub_categories', ['id' => $id], ['is_blocked' => '0']);
        $this->session->set_flashdata('message', ['message' => 'Category Successfully activated.', 'class' => 'success']);
        redirect('admin/sub_categories');
    }

    public function delete($id)
    {
//        $id = $id;
        $this->Admin_category_model->update_record('sub_categories', ['id' => $id], ['is_deleted' => '1']);
        $this->session->set_flashdata('message', ['message' => 'Category Successfully deleted.', 'class' => 'success']);
        redirect('admin/sub_categories');
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

    public function search()
    {
        $result = array();
        if ($this->input->post() && $this->input->post('query'))
        {
            $result = $this->Admin_category_model->find_category_by_name($this->input->post('query'));
            foreach ($result as $key => $row)
            {
                $result[$key]['name'] = $row['name'];
            }
        }
        echo json_encode($result);
    }

    public function select_icon()
    {
        $data['subview'] = 'admin/categories/icon';
        $this->load->view('admin/layouts/layout_main', $data);
    }

}
