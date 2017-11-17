<?php

class Admin_category_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_category()
    {

        $this->db->select('c.id,c.id AS test_id,c.category_name,DATE_FORMAT(created_at,"%d %b %Y <br> %l:%i %p") AS created_at,is_blocked,is_deleted', false);
        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('category_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('categories c')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of users based on datatable in user list page
     * @param : @table 
     * @author : HPA
     */
    public function get_category_count()
    {

        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('category_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('categories c')->num_rows();
        return $res_data;
    }

    /**
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : HPA
     */
    public function get_result($table, $condition = null)
    {
        $this->db->select('*');
        if (!is_null($condition))
        {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @blog_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $category_array)
    {
        if ($this->db->insert($table, $category_array))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * @uses : This function is used to update record
     * @param : @table, @user_id, @user_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $user_array)
    {
        $this->db->where($condition);
        if ($this->db->update($table, $user_array))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * @uses : This function is used to check blog title exist or not
     * @param : @Title, @blog_id  
     * @author : DHK
     */
    public function CheckExist($Name, $CategoryId = 0)
    {
        $this->db->from('categories');
        $this->db->where('category_name', $Name);
        $this->db->where('id !=' . $CategoryId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * @uses : This function is used to check blog title exist or not
     * @param : @Title, @blog_id  
     * @author : DHK
     */
    public function CheckSubExist($Name, $CategoryId = 0)
    {
        $this->db->from('sub_categories');
        $this->db->where('category_name', $Name);
        $this->db->where('id !=' . $CategoryId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * @uses : this function is used to get result based on datatable in user list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_sub_category()
    {
        $this->db->select('s.id,s.id AS test_id,s.category_name,s.main_cat_id,DATE_FORMAT(s.created_at,"%d %b %Y <br> %l:%i %p") AS created_at,s.is_blocked,s.is_deleted,c.category_name as main_category', false);
        $this->db->join('categories c', 'c.id = s.main_cat_id');
        $this->db->where('s.is_deleted !=', 1);
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('s.category_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('sub_categories s')->result_array();
//        echo"data"die
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of users based on datatable in user list page
     * @param : @table 
     * @author : HPA
     */
    public function get_sub_category_count()
    {
        $this->db->where('s.is_deleted !=', 1);
        $this->db->join('categories c', 'c.id = s.main_cat_id');
        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('s.category_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('sub_categories s')->num_rows();
        return $res_data;
    }

    public function find_category_by_name($keyword)
    {
        $this->db->select('id,category_name as name');
        $this->db->like('category_name', $keyword);
        $this->db->where('categories.is_deleted', '0');
        return $this->db->get('categories')->result_array();
    }

    public function get_category_by_id($id)
    {
        $this->db->select('id,category_name');
        $this->db->where('id', $id);
        return $this->db->get('categories')->result_array();
        qry();
    }

}

?>