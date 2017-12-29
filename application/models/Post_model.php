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

    public function get_all_posts_by_user_id($user_id, $limit)
    {
//        b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.fname,u.lname,u.username,u.avatar,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
//        $this->db->join('blog b', 'b.post_id = up.id', 'left');
//        $this->db->join('video v', 'v.post_id = up.id', 'left');
//        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('u.id = ', $user_id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('up.id');
        $this->db->order_by('up.id', 'desc');
        $this->db->limit($limit);
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_all_posts_by_slug($post_slug)
    {
        $this->db->select('up.id,up.post_title,up.main_image,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,cat.category_name as category,sc.category_name as sub_category,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y <br> %l:%i %p") AS blogcreated_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y <br> %l:%i %p") AS gallerycreated_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description,v.upload_path,v.embed_link,DATE_FORMAT(v.created_at,"%d %b %Y <br> %l:%i %p") AS videocreated_date,COUNT(distinct upc.id) as total_views');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sc', 'sc.id = up.sub_category_id', 'left');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.slug', $post_slug);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $posts = $this->db->get('user_post up')->row_array();
        return $posts;
    }

    public function get_bookmarked_post_by_slug($post_slug)
    {
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.slug', $post_slug);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
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

    public function get_posts_category_id($cat_id, $sub_id = null)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        if (is_null($sub_id))
        {
            $this->db->where('up.category_id = ', $cat_id);
        }
        else
        {
            $this->db->where('up.sub_category_id = ', $sub_id);
        }
        $this->db->group_by('up.id');
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    // ------------------------------------------------------------------------
    // Get all posts from the category and sub category
    // ------------------------------------------------------------------------
    public function get_posts_from_category($cat_id, $sub_id = null, $limit, $offset = "0")
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,
                           c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,
                           upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');

        if (is_null($sub_id))
        {
            $this->db->where('up.category_id = ', $cat_id);
        }
        else
        {
            $this->db->where('up.sub_category_id = ', $sub_id);
        }

        $this->db->limit($limit, $offset);
        $this->db->group_by('up.id');

        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_posts_from_category_count($cat_id, $sub_id = null)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,
                           c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,
                           upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');

        if (is_null($sub_id))
        {
            $this->db->where('up.category_id = ', $cat_id);
        }
        else
        {
            $this->db->where('up.sub_category_id = ', $sub_id);
        }

        $this->db->group_by('up.id');

        $posts = $this->db->get('user_post up')->num_rows();
        return $posts;
    }

    // ------------------------------------------------------------------------
    // ################################ END ###################################
    // ------------------------------------------------------------------------

    public function get_related_posts_category_id($id, $post_id, $limit)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.username,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('up.category_id = ', $id);
        $this->db->group_by('up.id');
        $this->db->limit($limit);
        $this->db->where('up.id > ', $post_id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_total_no_of_views($post_id)
    {
        $this->db->select('post_id, count(post_id) as total_views');
        $this->db->join('user_post up', 'up.id = upc.post_id');
        $this->db->where('up.id', $post_id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('upc.post_id');
        $views = $this->db->get('user_post_counts upc')->row_array();
        return $views;
    }

    public function get_bookmarked_post($id, $limit, $offset)
    {
        $q = $this->input->get('q');
        $this->db->select('ub.user_id,ub.post_id,u.username,post_type,slug,post_title,main_image,COUNT(distinct upc.id) as total_views');
        $this->db->join('user_post up', 'up.id = ub.post_id');
        $this->db->join('user_channels uc', 'uc.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = uc.user_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('ub.user_id', $id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('ub.post_id');
        $this->db->order_by('ub.id', 'desc');
        $this->db->like('post_title', $q);
        $this->db->limit($limit, $offset);
        $bookmarks = $this->db->get('user_bookmarks ub')->result_array();
//        qry(1);
        
        return $bookmarks;
    }

    public function get_bookmarked_post_count($id)
    {
        $q = $this->input->get('q');
        $this->db->select('ub.user_id,ub.post_id,u.username,post_type,slug,post_title,main_image,COUNT(distinct upc.id) as total_views');
//        $this->db->join('users u', 'u.id = ub.user_id');
//        $this->db->join('user_post up', 'up.id = ub.post_id');
         $this->db->join('user_post up', 'up.id = ub.post_id');
        $this->db->join('user_channels uc', 'uc.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = uc.user_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('ub.user_id', $id['user_id']);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('ub.post_id');
        $this->db->like('post_title', $q);
        $this->db->order_by('ub.id', 'desc');
        $bookmarks = $this->db->get('user_bookmarks ub')->num_rows();
        return $bookmarks;
    }

    public function get_history($id, $limit, $offset)
    {
        $q = $this->input->get('q');
        $this->db->select('uh.user_id,uh.post_id,u.username,post_type,slug,post_title,main_image,COUNT(distinct upc.id) as total_views');
        $this->db->join('user_post up', 'up.id = uh.post_id');
        $this->db->join('user_channels uc', 'uc.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = uc.user_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('uh.user_id', $id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('uh.post_id');
        $this->db->order_by('uh.id', 'desc');
        $this->db->like('post_title', $q);
        $this->db->limit($limit, $offset);
        $history = $this->db->get('user_history uh')->result_array();
        return $history;
    }

    public function get_history_count($id)
    {
        $q = $this->input->get('q');
        $this->db->select('uh.user_id,uh.post_id,u.username,post_type,slug,post_title,main_image,COUNT(distinct upc.id) as total_views');
        $this->db->join('user_post up', 'up.id = uh.post_id');
        $this->db->join('user_channels uc', 'uc.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = uc.user_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('uh.user_id', $id['user_id']);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('uh.post_id');
        $this->db->like('post_title', $q);
        $this->db->order_by('uh.id', 'desc');
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

    public function get_posts_front_count($table, $where = array())
    {
        $this->db->where($where);
        $res_data = $this->db->get($table)->num_rows();
        return $res_data;
    }

    // ------------------------------------------------------------------------

    public function get_my_posts_count($user_id)
    {

        $q = $this->input->get('q');

        $all_channel_data = $this->db->select('id')->get_where('user_channels', ['user_id' => $user_id, 'is_deleted' => '0', 'is_blocked' => '0'])->result_array();
        $all_channel_id = array_column($all_channel_data, 'id');
        // ------------------------------------------------------------------------
        $this->db->where_in('channel_id', $all_channel_id);
        $this->db->like('post_title', $q);
        $all_u_posts_cnt = $this->db->get_where('user_post', ['is_deleted' => '0', 'is_blocked' => '0'])->num_rows();
        return $all_u_posts_cnt;
    }

    public function get_my_posts_data($user_id, $limit, $offset)
    {
        $all_channel_data = $this->db->select('id')->get_where('user_channels', ['user_id' => $user_id, 'is_deleted' => '0', 'is_blocked' => '0'])->result_array();
        $all_channel_id = array_column($all_channel_data, 'id');
        // ------------------------------------------------------------------------
        $q = $this->input->get('q');

        $this->db->select('user_post.id,user_post.upload_user_id,user_post.channel_id,user_post.is_approved,user_post.slug,user_post.post_type,user_post.post_title,user_post.main_image,COUNT(distinct upc.id) as total_views');
        $this->db->join('user_post_counts upc', 'user_post.id = upc.post_id', 'left');
        $this->db->group_by('user_post.id');
        $this->db->order_by('user_post.created_at','desc');
        $this->db->limit($limit, $offset);
        $this->db->like('post_title', $q);
        $this->db->where_in('channel_id', $all_channel_id);
        $all_u_posts_cnt = $this->db->get_where('user_post', ['is_deleted' => '0', 'is_blocked' => '0'])->result_array();        
        return $all_u_posts_cnt;
    }

    public function get_total_views($post_id)
    {
        $this->db->select('COUNT(distinct upc.id) as total_views');
        $this->db->join('user_post up', 'up.id = upc.post_id');
        $this->db->where('post_id', $post_id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $views = $this->db->get('user_post_counts upc')->num_rows();
        return $views;
    }

    // ------------------------------------------------------------------------

    function loadcategories()
    {
        $query = $this->db->query("SELECT DISTINCT category_name FROM categories");

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
    }

    function loadsubcategorycategories($category_id)
    {

        $query = $this->db->query("SELECT * FROM sub_categories WHERE main_cat_id = '{$category_id}'");

        if ($query->num_rows() > 0)
        {
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

    public function get_comments_by_post_id($post_id = array())
    {
        $this->db->select('comments.id,message,user_id,post_id,comments.created_at,u.username,u.avatar');
        $this->db->join('users u', 'u.id = comments.user_id');
        $this->db->where_in('comments.post_id',$post_id);
        $this->db->order_by('comments.created_at', 'desc');
        $this->db->limit(20);
        $comments = $this->db->get('comments')->result_array();
        return $comments;
    }

    public function get_comments_by_post($post_id, $limit, $offset)
    {
        $this->db->select('comments.id,message,user_id,post_id,comments.created_at,u.username,u.avatar');
        $this->db->join('users u', 'u.id = comments.user_id');
        $this->db->where('post_id', $post_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('comments.created_at', 'desc');
        $comments = $this->db->get('comments')->result_array();
        return $comments;
    }

    public function get_comments_by_post_count($post_id)
    {
        $this->db->select('comments.id,message,user_id,post_id,comments.created_at,u.username,u.avatar');
        $this->db->join('users u', 'u.id = comments.user_id');
        $this->db->where('post_id', $post_id);
        $this->db->order_by('comments.created_at', 'desc');
        $comments = $this->db->get('comments')->num_rows();
        return $comments;
    }

    public function get_all_posts_by_channel_id($channel_id, $limit)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,up.post_title,up.main_image,uc.id as channelid,uc.user_id as chaneeluserid,uc.channel_name,uc.channel_slug,u.id as userid,u.fname,u.lname,u.username,u.avatar,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels uc', 'uc.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = uc.user_id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('uc.id = ', $channel_id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('up.id');
        $this->db->order_by('uc.id', 'desc');
        $this->db->limit($limit);
        $channels = $this->db->get('user_post up')->result_array();
        return $channels;
    }

    public function get_user_channel($slug)
    {
        $this->db->select('c.id,c.channel_name,channel_slug,c.user_id,u.id as userid,u.fname,u.lname,u.username,u.avatar,u.designation');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->where('c.channel_slug', $slug);
        $this->db->where('c.is_deleted != 1');
        $this->db->where('c.is_blocked != 1');
        $user = $this->db->get('user_channels c')->row_array();
        return $user;
    }

    public function get_total_likes($id)
    {
        $this->db->select('COUNT(distinct uk.id)');
        $this->db->join('user_post up', 'up.id = uk.post_id');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $likes = $this->db->get('user_likes')->num_rows();
        return $likes;
    }

    public function get_all_posts_by_user($user_id, $limit, $offset)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.slug,up.category_id,up.sub_category_id,c.id as channelid,c.user_id as chaneeluserid,c.channel_name,c.channel_slug,u.id as userid,u.fname,u.lname,u.username,u.avatar,b.id as blogid,b.post_id as blogpostid,b.blog_title,b.blog_description,b.img_path as bimg,DATE_FORMAT(b.created_at,"%d %b %Y %l:%i %p") AS blog_created_date,g.id as galleryid,g.post_id as gallerypost_id,g.title as gtitle,g.description as gdesc,g.img_path as gimg,DATE_FORMAT(g.created_at,"%d %b %Y %l:%i %p") AS gallery_created_date,v.id as videoid,v.post_id as videopostid,v.title as vtitle,v.description as vdesc,v.upload_path,DATE_FORMAT(v.created_at,"%d %b %Y %l:%i %p") AS video_created_date,upc.post_id as upcpostid, COUNT(distinct upc.id) as total_views');
        $this->db->join('user_channels c', 'c.id = up.channel_id', 'left');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->join('categories cat', 'cat.id = up.category_id', 'left');
        $this->db->join('sub_categories sub_cat', 'sub_cat.id = up.sub_category_id', 'left');
        $this->db->join('blog b', 'b.post_id = up.id', 'left');
        $this->db->join('video v', 'v.post_id = up.id', 'left');
        $this->db->join('gallery g', 'g.post_id = up.id', 'left');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->where('u.id = ', $user_id);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('up.id');
        $this->db->order_by('up.id', 'desc');
        $this->db->limit($limit, $offset);
        $posts = $this->db->get('user_post up')->result_array();
        return $posts;
    }

    public function get_sub_cat()
    {
        $this->db->select('s.id,s.category_name as sub_cat,main_cat_id,s.icon');
        $this->db->join('categories c', 'c.id = s.main_cat_id');
        $this->db->where('s.main_cat_id = c.id');
        $sub = $this->db->get('sub_categories s')->result_array();
        return $sub;
    }

    public function get_most_liked_post($limit, $offset)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.post_title,up.main_image,up.slug,u.username,count(distinct upc.id) as total_views, count(distinct uk.id) as total_likes');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->join('user_likes uk', 'uk.post_id = up.id', 'left');
        $this->db->join('user_channels uc','uc.id = up.channel_id');
        $this->db->join('users u', 'u.id = uc.user_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id');
        $this->db->group_by('uk.post_id');
        $this->db->order_by('total_views', 'desc');
        $this->db->limit($limit, $offset);
        $likes = $this->db->get('user_post up')->result_array();
        return $likes;
    }

    public function get_most_viewed_post($limit, $offset)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.post_title,up.main_image,up.slug,u.username,count(distinct upc.id) as total_views');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->join('user_channels uc','uc.id = up.channel_id');
        $this->db->join('users u', 'u.id = uc.user_id', 'left');
        $this->db->join('user_likes uk', 'uk.post_id = up.id', 'left');
        $this->db->group_by('upc.post_id');
        $this->db->order_by('total_views', 'desc');
        $this->db->limit($limit, $offset);
        $views = $this->db->get('user_post up')->result_array();
        return $views;
    }

    public function get_most_popular_post($limit = null, $offset = null)
    {
        $this->db->select('up.id,up.channel_id,up.post_type,up.post_title,up.main_image,up.slug,u.username,count(distinct upc.id) as total_views, count(distinct uk.id) as total_likes');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->join('user_likes uk', 'uk.post_id = up.id', 'left');
        $this->db->join('user_channels uc','uc.id = up.channel_id');
        $this->db->join('users u', 'u.id = uc.user_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id');        
        
        $this->db->group_by('upc.post_id');
        $this->db->order_by('total_views', 'desc');
        $this->db->order_by('total_likes', 'desc');

        $this->db->limit($limit, $offset);

        $likes = $this->db->get('user_post up')->result_array();        
        return $likes;
    }

    public function get_most_recent_posts($limit = null,$offset = null)
    {
        $this->db->select('up.id as userpostid,up.channel_id,up.post_type,up.post_title,up.main_image,up.slug,up.created_at,upc.id as upcid,upc.user_id as upcuserid,upc.post_id as upcpostid,u.id as userid,u.username,count(distinct upc.id) as total_views');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id', 'left');
        $this->db->join('user_channels uc','uc.id = up.channel_id');
        $this->db->join('users u', 'u.id = uc.user_id', 'left');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->group_by('up.id');
        $this->db->order_by('up.created_at', 'desc');
        $this->db->limit($limit, $offset);
        $recent = $this->db->get('user_post up')->result_array();
        return $recent;
  
    }

        public function get_recently_posted_videos($limit, $offset)
    {
//            u.username,count(distinct upc.id) as total_views
        $this->db->select('post_title,main_image,slug,post_type');
//        $this->db->join('user_post_counts upc','up.id = upc.post_id');
//        $this->db->join('users u','u.id = upc.user_id');
        $this->db->where('post_type', 'video');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->order_by('up.created_at', 'desc');
        $this->db->limit($limit, $offset);
        $recent_video = $this->db->get('user_post up')->result_array();
        return $recent_video;
    }

    public function get_recently_posted_blogs($limit, $offset)
    {
//        u.username,count(distinct upc.id) as total_views
        $this->db->select('post_title,main_image,slug,post_type');
//        $this->db->join('user_post_counts upc','up.id = upc.post_id');
//        $this->db->join('users u','u.id = upc.user_id');
        $this->db->where('post_type', 'blog');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->order_by('up.created_at', 'desc');
        $this->db->limit($limit, $offset);
        $recent_blog = $this->db->get('user_post up')->result_array();
        return $recent_blog;
    }

    public function get_recently_posted_gallery($limit, $offset)
    {
//        u.username,count(distinct upc.id) as total_views
        $this->db->select('post_title,main_image,slug,post_type');
//        $this->db->join('user_post_counts upc','up.id = upc.post_id');
//        $this->db->join('users u','u.id = upc.user_id');
        $this->db->where('post_type', 'gallery');
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->order_by('up.created_at', 'desc');
        $this->db->limit($limit, $offset);
        $recent_gallery = $this->db->get('user_post up')->result_array();
        return $recent_gallery;
    }
    

    public function get_recommended_post_count($id = null,$limit = null, $offset = null)
    {
        $q = $this->input->get('q');
        //category id
        $this->db->select('c.id');
        $this->db->join('user_post up', 'c.id = up.category_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id AND upc.user_id = ' . $id['user_id']);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->like('post_title', $q);
        $this->db->limit($limit,$offset);
        $category = $this->db->get('categories c')->result_array();

        $cat_id = array_column($category, 'id');
        //category id
        $cat_post = [];
        $cat_post_id = [];
        if (!empty($cat_id))
        {
            $this->db->select('up.*,u.username,count(upc.id) as total_views');
            $this->db->join('user_post_counts upc', 'up.id = upc.post_id');
            $this->db->join('users u', 'u.id = upc.user_id');
            $this->db->where_in('up.category_id', $cat_id);
            $this->db->group_by('up.id');
            $this->db->order_by('total_views', 'desc');
            $this->db->like('post_title', $q);
            $this->db->limit($limit,$offset);
            $cat_post = $this->db->get('user_post up')->result_array();

            $cat_post_id = array_column($cat_post, 'category_id');
        }
        //channel id
        $this->db->select('uc.id');
        $this->db->join('user_post up', 'uc.id = up.channel_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id AND upc.user_id = ' . $id['user_id']);
        $this->db->where('up.is_deleted != 1');
        $this->db->where('up.is_blocked != 1');
        $this->db->like('post_title', $q);
        $this->db->limit($limit,$offset);
        $channel = $this->db->get('user_channels uc')->result_array();

        $channel_id = array_column($channel, 'category_id');
        //channel id
        $chl_post = [];

        if (!empty($channel_id))
        {
            $this->db->select('up.*,u.username,count(upc.id) as total_views');
            $this->db->join('user_post_counts upc', 'up.id = upc.post_id');
            $this->db->join('user_channels uc', 'uc.id = up.channel_id');
            $this->db->join('users u', 'u.id = uc.user_id');
            $this->db->where_in('up.channel_id', $channel_id);

            if (!empty($cat_post_id))
            {
                $this->db->where_not_in('up.category_id', $cat_post_id);
            }
            $this->db->group_by('up.id');
            $this->db->order_by('total_views', 'desc');
            $this->db->like('post_title', $q);
            $this->db->limit($limit,$offset);
            $chl_post = $this->db->get('user_post up')->result_array();
        }

        $recommended = array_merge($chl_post, $cat_post);
        $post = count($recommended);

        if (empty($recommended))
        {
            $popular = $this->get_most_popular_post();
            $popular_post = count($popular);
            if (empty($popular))
            {
                $recent = $this->get_most_recent_posts();
                $recent_post = count($recent);
                return $recent_post;
            }
            else
            {
                return $popular_post;
            }
        }
        else
        {
            return $post;
        }
    }
    
    public function get_recommended_post($id = null,$limit = null, $offset = null) {

        // Step - 4
        if (is_null($id) ) {
            $popular = $this->get_most_popular_post(10);
            if (empty($popular))  {
                $recent = $this->get_most_recent_posts(10);
                return $recent;
            } else {
                return $popular;
            }
        }

        $q = $this->input->get('q');

        //category id
        $this->db->select('c.id');
        $this->db->join('user_post up', 'c.id = up.category_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id AND upc.user_id = ' . $id);
        $this->db->where(['up.is_deleted !='=>'1','up.is_blocked !='=>'1']);
        $this->db->like('post_title', $q);
        $this->db->limit($limit,$offset);
        $category = $this->db->get('categories c')->result_array();

        $cat_id = array_column($category, 'id');

        //category id
        $cat_post = [];
        $cat_post_id = [];

        if (!empty($cat_id)) {

            $this->db->select('up.*,users.username,count(upc.id) as total_views');
            $this->db->join('user_post_counts upc', 'up.id = upc.post_id');
            
            $this->db->join('user_channels', 'user_channels.id = up.channel_id','left');
            $this->db->join('users', 'users.id = user_channels.user_id','left');

            $this->db->join('users u', 'u.id = upc.user_id','left');

            $this->db->where_in('up.category_id', $cat_id);
            $this->db->group_by('up.id');
            $this->db->order_by('total_views', 'desc');
            $this->db->like('post_title', $q);
            $this->db->limit($limit,$offset);
            $cat_post = $this->db->get('user_post up')->result_array();

            $cat_post_id = array_column($cat_post, 'category_id');
        }

        //channel id
        $this->db->select('uc.id');
        $this->db->join('user_post up', 'uc.id = up.channel_id');
        $this->db->join('user_post_counts upc', 'up.id = upc.post_id AND upc.user_id = ' . $id);
        $this->db->where(['up.is_deleted !='=>'1','up.is_blocked !='=>'1']);
        $this->db->like('post_title', $q);
        $this->db->limit($limit,$offset);
        $channel = $this->db->get('user_channels uc')->result_array();

        $channel_id = array_column($channel, 'category_id');
        //channel id
        $chl_post = [];

        if (!empty($channel_id)) {

            $this->db->select('up.*,u.username,count(upc.id) as total_views');
            $this->db->join('user_post_counts upc', 'up.id = upc.post_id');
            $this->db->join('user_channels uc', 'uc.id = up.channel_id');
            $this->db->join('users u', 'u.id = uc.user_id');
            $this->db->where_in('up.channel_id', $channel_id);

            if (!empty($cat_post_id)) {
                $this->db->where_not_in('up.category_id', $cat_post_id);
            }
            
            $this->db->group_by('upc.post_id');
            $this->db->order_by('total_views', 'desc');            

            $this->db->like('post_title', $q);
            $this->db->limit($limit,$offset);
            $chl_post = $this->db->get('user_post up')->result_array();
        }

        $recommended = array_merge($chl_post, $cat_post);

        // Step - 4
        if (empty($recommended)) {
            $popular = $this->get_most_popular_post(10);
            if (empty($popular)) {
                $recent = $this->get_most_recent_posts(10);
                return $recent;
            } else {
                return $popular;
            }
        } else {
            return $recommended;
        }

    }

}

?> 