<?php

class Post_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
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
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->where('u.id = ', $user_id);
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_all_posts_by_slug($post_slug)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS blogcreated_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y <br> %l:%i %p") AS gallerycreated_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS videocreated_date');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
//        $this->db->where('u.id = ', $user_id);
        $this->db->where('up.slug', $post_slug);
        $posts = $this->db->get('user_post up')->row_array();
        return $posts;
    }

    public function get_blogs_by_post_slug($post_slug)
    {
        $this->db->select('up.id,up.channel_id as userpostchannelid,up.post_type,up.slug,b.id as blogid,post_id,blog_title,blog_description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name');
        $this->db->join('blog b', 'up.id = b.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('up.slug', $post_slug);
        $blogs = $this->db->get('user_post up')->row_array();
        qry();
//        pr($blogs, 1);
        return $blogs;
    }

    public function get_gallery_by_post_id($gallery_post_id)
    {
        $this->db->select('g.id,post_id,title,description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type');
        $this->db->join('user_post up', 'up.id = g.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('g.post_id', $gallery_post_id);
        $gallery = $this->db->get('gallery g')->result_array();
//        qry();
//        pr($gallery, 1);
        return $gallery;
    }

    public function get_video_by_id($video_id)
    {
        $this->db->select('v.id,post_id,title,description,upload_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name, up.id as userpostid,up.channel_id as userpostchannelid,up.post_type');
        $this->db->join('user_post up', 'up.id = v.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('v.id = ', $video_id);
        $video = $this->db->get('video v')->row_array();
//        qry();
//        pr($video, 1);
        return $video;
    }

    public function get_all_blogs($where = array())
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,b.id as blogid,post_id,blog_title,blog_description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'up.id = b.post_id');
        $this->db->where('up.is_deleted !=', 1);
        $this->db->where('up.post_type', 'blog');
        if (count($where) > 0)
        {
            $this->db->where($where);
        }

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('blog_title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('user_post up')->result_array();
        return $res_data;
    }

    public function get_blogs_count($where = array())
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,b.id as blogid,post_id,blog_title,blog_description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'up.id = b.post_id');
        $this->db->where('up.is_deleted !=', 1);
        $this->db->where('up.post_type', 'blog');
        if (count($where) > 0)
        {
            $this->db->where($where);
        }

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('blog_title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('user_post up')->num_rows();
        return $res_data;
    }

    public function get_all_videos($where = array())
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,v.id as videoid,post_id,title,description,upload_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('video v', 'up.id = v.post_id');
        $this->db->where('up.is_deleted !=', 1);
        $this->db->where('up.post_type', 'video');
        if (count($where) > 0)
        {
            $this->db->where($where);
        }

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('user_post up')->result_array();
        return $res_data;
    }

    public function get_videos_count($where = array())
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,v.id as videoid,post_id,title,description,upload_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('video v', 'up.id = v.post_id');
        $this->db->where('up.is_deleted !=', 1);
        $this->db->where('up.post_type', 'video');
        if (count($where) > 0)
        {
            $this->db->where($where);
        }

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('user_post up')->num_rows();
        return $res_data;
    }

    public function get_all_gallery($where = array())
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,g.id as galleryid,post_id,title,description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name,DATE_FORMAT(g.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('gallery g', 'up.id = g.post_id');
        $this->db->where('up.is_deleted !=', 1);
        $this->db->where('up.post_type', 'gallery');
        if (count($where) > 0)
        {
            $this->db->where($where);
        }

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        $res_data = $this->db->get('user_post up')->result_array();
        return $res_data;
    }

    public function get_gallery_count($where = array())
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,g.id as galleryid,post_id,title,description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name,DATE_FORMAT(g.created_at,"%d %b %Y <br> %l:%i %p") AS created_date,up.is_blocked', false);
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('gallery g', 'up.id = g.post_id');
        $this->db->where('up.is_deleted !=', 1);
        $this->db->where('up.post_type', 'gallery');
        if (count($where) > 0)
        {
            $this->db->where($where);
        }

        $keyword = $this->input->get('search');
        $keyword = str_replace('"', '', $keyword);

        if (!empty($keyword['value']))
        {
            $this->db->having('title LIKE "%' . $keyword['value'] . '%"', NULL);
        }

        $res_data = $this->db->get('user_post up')->num_rows();
        return $res_data;
    }

    public function get_posts_category_id($id)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,upc.post_id as upcpostid, count(upc.post_id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.category_id = ', $id);
        $this->db->group_by('upc.post_id');
//        $this->db->limit(4, 0);
        $posts = $this->db->get('user_post up')->result_array();
//        qry();
//        pr($posts,1);
        return $posts;
    }

    public function get_total_no_of_views($post_id)
    {
//        SELECT post_id,count(post_id) FROM `user_post_counts` GROUP by post_id
        $this->db->select('post_id, count(post_id) as total_views');
        $this->db->join('user_post up', 'up.id = upc.post_id');
        $this->db->where('up.id', $post_id);
        $this->db->group_by('upc.post_id');
        $views = $this->db->get('user_post_counts upc')->row_array();
        return $views;
    }

}

?> 