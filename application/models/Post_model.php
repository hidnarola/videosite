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

    public function get_all_posts_by_user_id($user_id,$limit)
    {
//        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path');
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.fname,u.lname,u.username,u.avatar,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
//        COUNT(distinct us.id) as total_subscribers
//        COUNT(distinct uk.id) as total_likes?
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
//        $this->db->join('user_subscribers us', 'c.id = us.channel_id', 'left');
//        $this->db->join('user_likes uk', 'up.id = uk.post_id', 'left');
        $this->db->where('u.id = ', $user_id);
        $this->db->group_by('up.id');
        $this->db->order_by('up.id', 'desc');
        $this->db->limit($limit);
        $posts = $this->db->get('user_post up')->result_array();
//        qry();
        return $posts;
    }

    public function get_all_posts_by_slug($post_slug)
    {
        $this->db->select('up.id,up.post_title,up.main_image,up.channel_id,up.post_type,up.slug,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS blogcreated_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y <br> %l:%i %p") AS gallerycreated_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS videocreated_date,COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.slug', $post_slug);
        $posts = $this->db->get('user_post up')->row_array();
        return $posts;
    }
    
    public function get_bookmarked_post_by_slug($post_slug)
    {
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.slug',$post_slug);
        $this->db->group_by('up.id');
        $bookmark = $this->db->get('user_bookmarks ub')->result_array();
        return $bookmark;
    }

    public function get_blogs_by_post_slug($post_slug)
    {
        $this->db->select('up.id,up.channel_id as userpostchannelid,up.post_type,up.slug,b.id as blogid,post_id,blog_title,blog_description,img_path,u.id as user_id, u.username,c.id as channelid, c.user_id as channeluserid,c.channel_name');
        $this->db->join('blog b', 'up.id = b.post_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('up.slug', $post_slug);
        $blogs = $this->db->get('user_post up')->row_array();
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
//        b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
//        $this->db->join('blog b', 'b.post_id = up.id', 'left');
//        $this->db->join('video v', 'v.post_id = up.id', 'left');
//        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.category_id = ', $id);
        $this->db->group_by('up.id');
        $posts = $this->db->get('user_post up')->result_array();
//        qry();die;
        return $posts;
    }
    public function get_related_posts_category_id($id,$post_id,$limit)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.category_id = ', $id);
        $this->db->group_by('up.id');
        $this->db->limit($limit);
        $this->db->where('up.id > ',$post_id);
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_total_no_of_views($post_id)
    {
        $this->db->select('post_id, count(post_id) as total_views');
        $this->db->join('user_post up', 'up.id = upc.post_id');
        $this->db->where('up.id', $post_id);
        $this->db->group_by('upc.post_id');
        $views = $this->db->get('user_post_counts upc')->row_array();
        return $views;
    }

    public function get_bookmarked_post($id, $limit, $offset)
    {
        $this->db->select('ub.user_id,ub.post_id,u.username,post_type,slug,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,COUNT(distinct upc.id) as total_views');
        $this->db->join('users u', 'u.id = ub.user_id');
        $this->db->join('user_post up', 'up.id = ub.post_id');
        $this->db->join('blog b', 'b.post_id = ub.post_id', 'left');
        $this->db->join('video v', 'v.post_id = ub.post_id', 'left');
        $this->db->join('gallery g', 'g.post_id = ub.post_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('ub.user_id',$id);
        $this->db->group_by('up.id');
        $this->db->order_by('ub.id', 'desc');
        $this->db->limit($limit, $offset);
        $bookmark = $this->db->get('user_bookmarks ub')->result_array();
        return $bookmark;
    }
    
    public function get_history($id, $limit, $offset)
    {
        $this->db->select('uh.user_id,uh.post_id,u.username,post_type,slug,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,COUNT(distinct upc.id) as total_views');
        $this->db->join('users u', 'u.id = uh.user_id');
        $this->db->join('user_post up', 'up.id = uh.post_id');
        $this->db->join('blog b', 'b.post_id = uh.post_id', 'left');
        $this->db->join('video v', 'v.post_id = uh.post_id', 'left');
        $this->db->join('gallery g', 'g.post_id = uh.post_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('uh.user_id',$id);
        $this->db->group_by('uh.post_id');
        $this->db->order_by('uh.id', 'desc');
        $this->db->limit($limit, $offset);
        $history = $this->db->get('user_history uh')->result_array();
        return $history;
    }
    
    public function get_history_count($id)
    {
        $this->db->select('uh.user_id,uh.post_id,u.username,post_type,slug,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,COUNT(distinct upc.id) as total_views');
        $this->db->join('users u', 'u.id = uh.user_id');
        $this->db->join('user_post up', 'up.id = uh.post_id');
        $this->db->join('blog b', 'b.post_id = uh.post_id', 'left');
        $this->db->join('video v', 'v.post_id = uh.post_id', 'left');
        $this->db->join('gallery g', 'g.post_id = uh.post_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
//        $this->db->where('uh.user_id',$id);
        $this->db->group_by('uh.post_id');
        $this->db->order_by('uh.id', 'desc');
//        $this->db->limit($limit, $offset);
        $history = $this->db->get('user_history uh')->num_rows();
        return $history;
    }

    public function get_front_result($table, $condition = null, $limit, $offset)
    {
        $this->db->select('*');
        if (!is_null($condition))
        {
            $this->db->where($condition);
        }
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function get_front_result_join($table, $condition = null, $limit, $offset)
    {
        $this->db->select('*');
        if (!is_null($condition))
        {
            $this->db->where($condition);
        }
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        $this->db->join('users u', 'u.id = ub.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = ub.post_id', 'left');
        $this->db->join('video v', 'v.post_id = ub.post_id', 'left');
        $this->db->join('gallery g', 'g.post_id = ub.post_id', 'left');
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_posts_front_count($table,$where = array())
    {
        $this->db->where($where);
        $res_data = $this->db->get($table)->num_rows();
        return $res_data;
    }

    // ------------------------------------------------------------------------

    public function get_my_posts_count($user_id) {
        
        $all_channel_data = $this->db->select('id')->get_where('user_channels',['user_id'=>$user_id,'is_deleted'=>'0','is_blocked'=>'0'])->result_array();
        $all_channel_id = array_column($all_channel_data,'id');        
        // ------------------------------------------------------------------------
        $this->db->where_in('channel_id',$all_channel_id);
        $all_u_posts_cnt = $this->db->get_where('user_post',['is_deleted'=>'0','is_blocked'=>'0'])->num_rows();
        return $all_u_posts_cnt;
    }

    public function get_my_posts_data($user_id,$limit,$offset) {
//        b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date
        $all_channel_data = $this->db->select('id')->get_where('user_channels',['user_id'=>$user_id,'is_deleted'=>'0','is_blocked'=>'0'])->result_array();
        $all_channel_id = array_column($all_channel_data,'id');        
        // ------------------------------------------------------------------------
        $this->db->select('user_post.id,user_post.channel_id,user_post.slug,user_post.post_type,user_post.post_title,user_post.main_image,COUNT(distinct upc.id) as total_views');
//        $this->db->join('blog b', 'b.post_id = user_post.id', 'left');
//        $this->db->join('video v', 'v.post_id = user_post.id', 'left');
//        $this->db->join('gallery g', 'g.post_id = user_post.id', 'left');
        $this->db->join('user_post_counts upc', 'user_post.id = upc.post_id', 'left');
        $this->db->group_by('user_post.id');
        $this->db->limit($limit,$offset);
        $this->db->where_in('channel_id',$all_channel_id);
        $all_u_posts_cnt = $this->db->get_where('user_post',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();
//        qry();
        return $all_u_posts_cnt;        
    }
    
    public function get_total_views($post_id)
    {
        $this->db->select('COUNT(distinct upc.id) as total_views');
        $this->db->join('user_post up','up.id = upc.post_id');
        $this->db->where('post_id',$post_id);
        $views = $this->db->get('user_post_counts upc')->num_rows();
//        echo"views";pr($views);
        return $views;
    }

    // ------------------------------------------------------------------------

    function loadcategories() {
        $query = $this->db->query("SELECT DISTINCT category_name FROM categories");
         
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
     
    function loadsubcategorycategories($category_id) {
	
        $query = $this->db->query("SELECT * FROM sub_categories WHERE main_cat_id = '{$category_id}'");
         
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    
    public function get_content_by_slug($slug)
    {
        $this->db->select('*');
        $this->db->where('is_deleted', '0');
        $this->db->where('is_blocked', '0');
        $this->db->where('slug', $slug);
        $slug = $this->db->get('cms_page')->row_array();
        return $slug;
    }

    public function get_slug($slug)
    {
        $this->db->select('title,slug');
        $this->db->where('title', $slug);
        $pages = $this->db->get('cms_page')->row_array();
        return $pages;
    }
    
    public function get_comments_by_post_id($post_id)
    {
        $this->db->select('message,user_id,post_id');
        $this->db->where('post_id',$post_id);
        $comments = $this->db->get('comments')->result_array();
        return $comments;
    }
    
    
    public function get_all_posts_by_channel_id($id)
    {
        $this->db->select('uc.id,uc.user_id as ucuserid,channel_name,channel_slug,up.channel_id,up.post_type,up.slug,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS blogcreated_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y <br> %l:%i %p") AS gallerycreated_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS videocreated_date,count(distinct upc.id) as total_views');
        $this->db->join('user_post up','up.channel_id = uc.id');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc','upc.post_id = up.id');
        $this->db->where('uc.id',$id);
        $channels = $this->db->get('user_channels uc')->result_array();
        
        return $channels;
    }
    
    public function get_total_likes($id)
    {
        $this->db->select('COUNT(distinct uk.id)');
        $this->db->join('user_post up','up.id = uk.post_id');
        $likes = $this->db->get('user_likes')->num_rows();
        return $likes;
        
    }
    
    public function get_all_posts_by_user($user_id,$limit,$offset)
    {
         $this->db->select('up.id,up.channel_id,up.post_type,up.slug,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path');
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.fname,u.lname,u.username,u.avatar,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
//        COUNT(distinct us.id) as total_subscribers
//        COUNT(distinct uk.id) as total_likes?
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
//        $this->db->join('user_subscribers us', 'c.id = us.channel_id', 'left');
//        $this->db->join('user_likes uk', 'up.id = uk.post_id', 'left');
        $this->db->where('u.id = ', $user_id);
        $this->db->group_by('up.id');
        $this->db->order_by('up.id', 'desc');
        $this->db->limit($limit,$offset);
        $posts = $this->db->get('user_post up')->result_array();
//        qry();
        return $posts;
    }
    
    public function get_sub_cat()
    {
        $this->db->select('s.id,s.category_name as sub_cat,main_cat_id,s.icon');
        $this->db->join('categories c','c.id = s.main_cat_id');
        $this->db->where('s.main_cat_id = c.id');
        $sub = $this->db->get('sub_categories s')->result_array();
        return $sub;
    }
}

?> 