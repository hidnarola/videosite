<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other_model extends CI_Model {

	public function search_query_count($query){
		
		$this->db->select('u_p.id as post_id,u_p.post_type,u_p.post_title,u_p.main_image,u_p.slug as post_slug,
						   u_p.created_at as post_created_date,u_c.user_id as u_id,users.username,count(u_p_c.id) as post_count');
		$this->db->like('u_p.post_title',$query);
		$this->db->join('user_channels u_c','u_c.id = u_p.channel_id','left');
		$this->db->join('users','users.id = u_c.user_id','left');
		$this->db->join('user_post_counts u_p_c','u_p_c.post_id = u_p.id','left');
		$this->db->order_by('u_p.created_at','desc');
		$this->db->group_by('u_p.id');
		$res = $this->db->get('user_post u_p')->result_array();

		qry();
		echo "<br/>";
		echo "=========================";
		echo "<br/>";
		pr($res,1);
	}

}

/* End of file Other_model.php */
/* Location: ./application/models/Other_model.php */