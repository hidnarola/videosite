<?php

class Admin_users_model extends CI_Model
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
    public function get_all_users()
    {

        $this->db->select('u.id,u.id AS test_id,r.role_name,fname,lname,email_id,
                            DATE_FORMAT(last_login,"%d %b %Y <br> %l:%i %p") AS last_login,DATE_FORMAT(u.created_at,"%d %b %Y <br> %l:%i %p") AS created_at,
                            u.is_blocked,COUNT(DISTINCT blg.id) as blog,COUNT(DISTINCT v.id) as video,COUNT(DISTINCT g.id) as gallery', false);
        $this->db->join('role r', 'u.role_id = r.id');
        $this->db->join('user_channels c', 'u.id = c.user_id', 'left');
        $this->db->join('user_post up', 'up.channel_id = c.id', 'left');
        $this->db->join('blog blg', 'up.id = blg.post_id', 'left');
        $this->db->join('video v', 'up.id = v.post_id', 'left');
        $this->db->join('gallery g', 'up.id = g.post_id', 'left');
        $this->db->where_in('role_id', [2, 3]);
        $this->db->where('u.is_deleted !=', 1);
        $this->db->group_by('u.id');

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('fname LIKE "%' . $keyword['value'] . '%" OR lname LIKE "%' . $keyword['value'] . '%" OR email_id LIKE "%' . $keyword['value'] . '%" OR role_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('users u')->result_array();
//        qry();
//        pr($res_data, 1);
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of users based on datatable in user list page
     * @param : @table 
     * @author : HPA
     */
    public function get_users_count()
    {
//        $this->db->select('u.id,u.id AS test_id,r.role_name,fname,lname,email_id,
//                            DATE_FORMAT(last_login,"%d %b %Y <br> %l:%i %p") AS last_login,DATE_FORMAT(u.created_at,"%d %b %Y <br> %l:%i %p") AS created_at,
//                            u.is_blocked,COUNT(blg.user_id) as total', false);
        $this->db->join('role r', 'u.role_id = r.id');
        $this->db->join('user_channels c', 'u.id = c.user_id', 'left');
        $this->db->join('user_post up', 'up.channel_id = c.id', 'left');
        $this->db->join('blog blg', 'up.id = blg.post_id', 'left');
        $this->db->join('video v', 'up.id = v.post_id', 'left');
        $this->db->join('gallery g', 'up.id = g.post_id', 'left');
        $this->db->where_in('role_id', [2, 3]);
        $this->db->where('u.is_deleted !=', 1);
        $this->db->group_by('u.id');
//        $this->db->join('role r', 'u.role_id = r.id');
//        $this->db->where_in('role_id', [2, 3]);
//        $this->db->where('is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('fname LIKE "%' . $keyword['value'] . '%" OR lname LIKE "%' . $keyword['value'] . '%" OR email_id LIKE "%' . $keyword['value'] . '%" OR role_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('users u')->num_rows();
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

    public function get_all_blogs_by_user($id)
    {
        $this->db->select('b.id,post_id,blog_title,u.id as userid,u.username,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS created_date', false);
        $this->db->join('user_post up', 'up.id = b.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
//        $this->db->where('b.is_deleted !=', 1);
        $this->db->where('c.user_id', $id);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('blog_title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));

        $res_data = $this->db->get('blog b')->result_array();
//        qry();
        return $res_data;
    }

    public function get_blogs_by_user_count($id)
    {
        $this->db->join('user_post up', 'up.id = b.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
//        $this->db->where('b.is_deleted !=', 1);
        $this->db->where('c.user_id', $id);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('blog_title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('blog b')->num_rows();
//        pr($res_data,1);    
        return $res_data;
    }

    public function get_blogs_by_user_id($id = null)
    {
        $this->db->select('b.id,user_id,blog_title,u.id as userid,u.username,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS created_date');
        $this->db->join('users u', 'u.id = b.user_id');
        $this->db->where('b.is_deleted !=', 1);
        $this->db->where('user_id', $id);
        $user_blog = $this->db->get('blog b')->result_array();
        return $user_blog;
    }

    public function get_user_by_id($id)
    {

        $this->db->select('u.id,u.id AS test_id,r.role_name,fname,lname,email_id,username,
                            DATE_FORMAT(last_login,"%d %b %Y <br> %l:%i %p") AS last_login,DATE_FORMAT(u.created_at,"%d %b %Y <br> %l:%i %p") AS created_at,
                            u.is_blocked,COUNT(DISTINCT blg.id) as blog,COUNT(DISTINCT v.id) as video,COUNT(DISTINCT g.id) as gallery');
        $this->db->join('role r', 'u.role_id = r.id');
        $this->db->join('user_channels c', 'u.id = c.user_id', 'left');
        $this->db->join('user_post up', 'up.channel_id = c.id', 'left');
        $this->db->join('blog blg', 'up.id = blg.post_id', 'left');
        $this->db->join('video v', 'up.id = v.post_id', 'left');
        $this->db->join('gallery g', 'up.id = g.post_id', 'left');
        $this->db->where_in('role_id', [2, 3]);
        $this->db->where('u.is_deleted !=', 1);
        $this->db->where('u.id', $id);
        $this->db->group_by('u.id');
        $users = $this->db->get('users u')->result_array();
//        qry();
//        pr($users,1);
        return $users;
    }

}

?>