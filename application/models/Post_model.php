<?php

class Post_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in cms list page
     * @param : @table 
     * @author : HPA
     */
    public function get_all_post()
    {

        $this->db->select('id,channel_id,post_type,slug,DATE_FORMAT(up.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked,c.id as channelid, c.channel_id', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->where('up.is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('channel_name LIKE "%' . $keyword['value'] . '%" OR post_type LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('user_post up,(SELECT @a:= 0) AS a')->result_array();
        return $res_data;
    }

    /**
     * @uses : this function is used to count rows of cms based on datatable in cms list page
     * @param : @table 
     * @author : HPA
     */
    public function get_post_count()
    {

        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->where('up.is_deleted !=', 1);

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('channel_name LIKE "%' . $keyword['value'] . '%" OR post_type LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $res_data = $this->db->get('user_post up')->num_rows();
        return $res_data;
    }

    /**
     * @uses : This function is used get result from the table
     * @param : @table 
     * @author : HPA
     */
    public function get_result($table, $condition = null, $is_single = null)
    {
        $this->db->select('*');
        if (!is_null($condition))
        {
            $this->db->where($condition);
        }

        $query = $this->db->get($table);

        if ($is_single !== null)
        {
            return $query->row_array();
        }
        else
        {
            return $query->result_array();
        }
    }

    /**
     * @uses : This function is used to update record
     * @param : @table, @cms_id, @cms_array = array of update  
     * @author : HPA
     */
    public function update_record($table, $condition, $cms_array)
    {
        $this->db->where($condition);
        if ($this->db->update($table, $cms_array))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * @uses : This function is used to insert record
     * @param : @table, @cms_array = array of update  
     * @author : HPA
     */
    public function insert_record($table, $data)
    {
        $this->db->insert($table, $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_all_posts_by_user_id($user_id)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path,g.id as galleryid,g.post_id as gallerypost_id,g.title,g.description,g.img_path,v.id as videoid,v.post_id as videopostid,v.title,v.description,v.upload_path');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->where('u.id = ', $user_id);
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_blogs_by_post_id($blog_post_id)
    {
//        $this->db->select('b.id,post_id,blog_title,blog_description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type');
//        $this->db->join('user_post up', 'up.id = b.post_id', 'left');
//        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
//        $this->db->join('users u', 'u.id = c.user_id', 'left');
//        $this->db->where('b.post_id = ', $blog_post_id);
//        $this->db->where('b.is_deleted !=', '1');
        $this->db->select('b.id,post_id,blog_title,blog_description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type');
        $this->db->join('user_post up', 'up.id = b.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('b.is_deleted !=', 1);
        $this->db->where('b.post_id', $blog_post_id);
        $blogs = $this->db->get('blog b')->result_array();
        qry();
        pr($blogs, 1);
        return $blogs;
    }

    public function get_gallery_by_post_id($gallery_post_id)
    {
        $this->db->select('g.id,post_id,title,description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type');
//        $this->db->join('user_post up', 'up.id = g.post_id', 'left');
//        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
//        $this->db->join('users u', 'u.id = c.user_id', 'left');
//        $this->db->where('g.id = ', $gallery_id);
//        $this->db->where('g.is_deleted !=', '1');
        $this->db->join('user_post up', 'up.id = g.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('g.is_deleted !=', 1);
        $this->db->where('g.post_id', $gallery_post_id);
        $gallery = $this->db->get('gallery g')->result_array();
        qry();
        pr($gallery, 1);
        return $gallery;
    }

    public function get_video_by_id($video_id)
    {
        $this->db->select('v.id,post_id,title,description,upload_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type');
        $this->db->join('user_post up', 'up.id = v.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('v.id = ', $video_id);
        $this->db->where('v.is_deleted !=', '1');
        $video = $this->db->get('video v')->row_array();
        qry();
        pr($video, 1);
        return $video;
    }

    public function get_all_posts()
    {
        $this->db->select('COUNT(DISTINCT b.id) as blog,COUNT(DISTINCT v.id) as video,COUNT(DISTINCT g.id) as gallery');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
//        $this->db->group_by('up.id');
//        $this->db->where('up.id = ', $user_post_id);
        $posts = $this->db->get('user_post up')->row_array();
        return $posts;
    }

}

?>