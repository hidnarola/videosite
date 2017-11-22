<?php

class Admin_video_model extends CI_Model
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
    public function get_all_videos()
    {

        $this->db->select('v.id,post_id,title,description,upload_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,v.is_blocked', false);
        $this->db->join('user_post up', 'up.id = v.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('v.is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('video v')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of users based on datatable in user list page
     * @param : @table 
     * @author : HPA
     */
    public function get_videos_count()
    {
        $this->db->join('user_post up', 'up.id = v.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('v.is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('video v')->num_rows();
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
    public function insert_record($table, $blog_array)
    {
        if ($this->db->insert($table, $blog_array))
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

    public function get_all_video_by_user($id)
    {
        $this->db->select('v.id,post_id,title,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,v.is_blocked,username', false);
        $this->db->join('user_post up', 'up.id = v.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('v.is_deleted !=', 1);
        $this->db->where('c.user_id', $id);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));

        $res_data = $this->db->get('video v')->result_array();
//        qry();
//        pr($res_data, 1);
        return $res_data;
    }

    public function get_video_by_user_count($id)
    {
        $this->db->join('user_post up', 'up.id = v.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('v.is_deleted !=', 1);
        $this->db->where('c.user_id', $id);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('video v')->num_rows();
//        pr($res_data,1);    
        return $res_data;
    }

    public function get_videos_by_user_id($id = null)
    {
        $this->db->select('v.id,user_id,title,u.id as userid,u.username,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,v.is_blocked');
        $this->db->join('users u', 'u.id = v.user_id');
        $this->db->where('v.is_deleted !=', 1);
        $this->db->where('user_id', $id);
        $user_blog = $this->db->get('video v')->result_array();
        return $user_blog;
    }

    /**
     * @uses : This function is used to check blog title exist or not
     * @param : @Title, @blog_id  
     * @author : DHK
     */
    public function CheckExist($Title, $VideoId = 0)
    {
        $this->db->from('video');
        $this->db->where('title', $Title);
        $this->db->where('id !=' . $VideoId);
        $query = $this->db->get();
        return $query->num_rows();
    }

}

?>