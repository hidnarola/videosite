<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['Users_model', 'Post_model']);
		$this->load->helper('directory');
	}
		
	public function img(){
		
		// ffmpeg -i input.jpg -vf scale=320:240 output_320x240.png
		echo $old_path = $_SERVER['DOCUMENT_ROOT'].'/videosite/uploads/test/6mb1.jpeg';
		echo "<br/>";
		echo $new_path = $_SERVER['DOCUMENT_ROOT'].'/videosite/uploads/test/optimize.jpg';

		exec(FFMPEG_PATH . ' -i '.$old_path.' -vf scale=500:-1 '.$new_path);

		// ffmpeg -i input.jpg -vf scale=320:240 output_320x240.png
	}

	// Step 1
	public function add_user(){
		$faker = Faker\Factory::create();

		$map = directory_map('./uploads/avatars');

		$ins_user = [
						'role_id'=>'1',
						'fname'=>rand(0, 1) ? $faker->firstNameMale : $faker->firstNameFemale,
						'lname'=>$faker->lastName,
						'email_id'=>'admin@mail.com',
						'username'=>$faker->userName,
						'avatar'=>'uploads/avatars/'.$map[array_rand($map)],
						'birth_date'=>$faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
						'password'=>$this->encrypt->encode('narola21'),
						'created_at'=>date('Y-m-d H:i:s'),
						'is_verified'=>'0'
					];
		$this->Users_model->insert_user_data($ins_user);

		for($i=0;$i<30;$i++){


			$ins_user = [
							'role_id'=>'3',
							'fname'=>rand(0, 1) ? $faker->firstNameMale : $faker->firstNameFemale,
							'lname'=>$faker->lastName,
							'email_id'=>rand(0, 1) ? $faker->email : $faker->safeEmail,
							'username'=>$faker->userName,
							'avatar'=>'uploads/avatars/'.$map[array_rand($map)],
							'birth_date'=>$faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
							'password'=>$this->encrypt->encode('narola21'),
							'created_at'=>date('Y-m-d H:i:s'),
							'is_verified'=>'1'
						];
			$last_id = $this->Users_model->insert_user_data($ins_user);

			for($j=0;$j<rand(1,3);$j++){
				$text = $faker->realText(25);
				$channel_slug = slugify($text);
				$this->db->insert('user_channels',['user_id'=>$last_id,'channel_name'=>$text,'channel_slug'=>$channel_slug,'created_at'=>date('Y-m-d H:i:s')]);
			}

			pr($ins_user);
		}
	}

	// Step 2
	public function add_subscriber(){
		$faker = Faker\Factory::create();

		$res = $this->db->get_where('users',['role_id'=>'3'])->result_array();

		if(!empty($res)){
			foreach($res as $r){
				$all_channel = $this->db->select('id')->get_where('user_channels',['user_id'=>$r['id']])->result_array();
				$all_ids = array_column($all_channel,'id');

				$fetch_channel = $this->db->where_not_in('id',$all_ids)->get('user_channels')->result_array();
				$fetch_ids = array_column($fetch_channel,'id');
				$random_ids = array_rand($fetch_ids,20);

				foreach($random_ids as $r_id){
					$this->db->insert('user_subscribers',['user_id'=>$r['id'],'channel_id'=>$fetch_ids[rand(0,count($fetch_ids)-1)]]);
				}				
			}
		}
	}

	// Step 3
	public function add_post(){
		$faker = Faker\Factory::create();		

		$res = $this->db->get_where('users',['role_id'=>'3'])->result_array();

		foreach($res as $r){

			$all_channel = $this->db->select('id')->get_where('user_channels',['user_id'=>$r['id']])->result_array();
			foreach($all_channel as $a_channel){

				$no_of_posts = [4,5,6,7,8,9,10,11,15,20];
				$select_posts = $no_of_posts[array_rand($no_of_posts)];

				$post_types = ['video', 'blog', 'gallery'];
				$select_post_type = $post_types[array_rand($post_types)];

				for($i=0;$i<$select_posts;$i++){
					
					$text = $faker->realText(30);
					$post_slug = slugify($text);

					if($select_post_type == 'blog'){
						$map = directory_map('./uploads/blogs');
						$post_img = 'uploads/blogs/'.$map[array_rand($map)];
					}else if($select_post_type == 'gallery'){
						$map = directory_map('./uploads/gallery');
						$post_img = 'uploads/gallery/'.$map[array_rand($map)];
					}else if($select_post_type == 'video'){
						$map = directory_map('./uploads/gallery');
						$post_img = 'uploads/videos/'.$map[array_rand($map)];
					}

					$ins_post = [
									'channel_id'=>$a_channel['id'],
									'post_type'=>$select_post_type,
									'post_title'=>$text,
									'main_image'=>$post_img,									
									'slug'=>$post_slug,
									'category_id'=>rand(1,12),
									'created_at'=>date('Y-m-d H:i:s')
								];
					$this->db->insert('user_post',$ins_post);
					$last_id = $this->db->insert_id();

					if($select_post_type == 'video'){
						$this->db->insert('video',[
													'post_id'=>$last_id,
													'title'=>$faker->realText(50),
													'description'=>$faker->realText(200),
													'upload_path'=>'uploads/videos/mov_bbb.mp4'
												]);
					}

					if($select_post_type == 'blog'){
						$map = directory_map('./uploads/blogs');
						$random_num = rand(1,5);

						for($j=0;$j<$random_num;$j++){
							$this->db->insert('blog',[
														'post_id'=>$last_id,
														'blog_title'=>$faker->realText(50),
														'blog_description'=>$faker->realText(200),
														'img_path'=>'uploads/blogs/'.$map[array_rand($map)]
													]);
						}
					}

					if($select_post_type == 'gallery'){
						$map = directory_map('./uploads/gallery');
						$random_num = rand(5,10);

						for($j=0;$j<$random_num;$j++){
							$this->db->insert('gallery',[
														'post_id'=>$last_id,
														'title'=>$faker->realText(50),
														'description'=>$faker->realText(200),
														'img_path'=>'uploads/gallery/'.$map[array_rand($map)]														
													]);
						}
					}

				}
			}
		}
	}

	// Step 4
	public function add_post_meta(){
		$faker = Faker\Factory::create();

		$all_post = $this->db->get('user_post')->result_array();

		$all_users = $this->db->get('users')->result_array();
		$all_users_ids = array_column($all_users,'id');

		echo $all_users_ids[rand(0,count($all_users_ids)-1)];

		$res = array_rand($all_users_ids,20);
		// pr($res,1);
		foreach($all_post as $a_post){

			$random_likes = rand(20,30);			
			$random_comment = rand(20,30);

			for($i=0;$i<$random_likes;$i++){
				$this->db->insert('user_likes',['user_id'=>$all_users_ids[rand(0,count($all_users_ids)-1)],'post_id'=>$a_post['id']]);
			}			

			for($j=0;$j<$random_comment;$j++){
				$this->db->insert('comments',[
												'message'=>$faker->realText(rand(10,50)),
												'post_id'=>$a_post['id'],
												'user_id'=>$all_users_ids[rand(0,count($all_users_ids)-1)],
												'created_at'=>date('Y-m-d H:i:s')
											]);
			}
			// user_likes
			// user_post_counts
			// comments
		}
	}

	public function create_picture(){


		$faker = Faker\Factory::create();

		for($j=0;$j<50;$j++){

			// echo '<img src="'.$faker->imageUrl($width = 640, $height = 480).'" width="640" height="480" />';
			$img_url = $faker->imageUrl($width = 640, $height = 480);
			$random_name = random_string('alnum',20).'.jpg';
			$contents=file_get_contents($img_url);
			$save_path="uploads/gallery/".$random_name;
			file_put_contents($save_path,$contents);	 
		}
	}

	public function allfiles(){
		$map = directory_map('./uploads/blogs');

		// $this
		pr($map);
	}

	// public function truncate_tables(){
	// 	$this->db->truncate('blog');
	// 	$this->db->truncate('comments');
	// 	$this->db->truncate('gallery');
	// 	$this->db->truncate('users');
	// 	$this->db->truncate('user_bookmarks');
	// 	$this->db->truncate('user_channels');
	// 	$this->db->truncate('user_history');
	// 	$this->db->truncate('user_likes');
	// 	$this->db->truncate('user_post');
	// 	$this->db->truncate('user_post_counts');
	// 	$this->db->truncate('user_subscribers');
	// 	$this->db->truncate('video');
	// }

	
	public function test_new(){
		$this->load->view('welcome_message');
	}	




}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */