<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['Users_model', 'Post_model']);
	}

 

	public function add_user(){
		$faker = Faker\Factory::create();

		$img_url = $faker->imageUrl($width = 640, $height = 480);		
		$random_name = random_string('alnum',20).'.jpg';
		$contents=file_get_contents($img_url);
		$save_path="uploads/avatars/".$random_name;
		file_put_contents($save_path,$contents);

		$ins_user = [
						'role_id'=>'1',
						'fname'=>rand(0, 1) ? $faker->firstNameMale : $faker->firstNameFemale,
						'lname'=>$faker->lastName,
						'email_id'=>'admin@mail.com',
						'username'=>$faker->userName,
						'avatar'=>$random_name,
						'birth_date'=>$faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
						'password'=>$this->encrypt->encode('narola21'),
						'created_at'=>date('Y-m-d H:i:s'),
						'is_verified'=>'0'
					];
		$this->Users_model->insert_user_data($ins_user);

		for($i=0;$i<30;$i++){

			$img_url = $faker->imageUrl($width = 640, $height = 480);		
			$random_name = random_string('alnum',20).'.jpg';
			$contents=file_get_contents($img_url);
			$save_path="uploads/avatars/".$random_name;
			file_put_contents($save_path,$contents);

			$ins_user = [
							'role_id'=>'3',
							'fname'=>rand(0, 1) ? $faker->firstNameMale : $faker->firstNameFemale,
							'lname'=>$faker->lastName,
							'email_id'=>rand(0, 1) ? $faker->email : $faker->safeEmail,
							'username'=>$faker->userName,
							'avatar'=>$random_name,
							'birth_date'=>$faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
							'password'=>$this->encrypt->encode('narola21'),
							'created_at'=>date('Y-m-d H:i:s'),
							'is_verified'=>'1'
						];
			$last_id = $this->Users_model->insert_user_data($ins_user);

			for($j=0;$j<rand(2,3);$j++){
				$text = $faker->realText(25);
				$channel_slug = slugify($text);
				$this->db->insert('user_channels',['user_id'=>$last_id,'channel_name'=>$text,'channel_slug'=>$channel_slug]);
			}

			pr($ins_user);
		}

	}

	public function add_subscriber(){
		$faker = Faker\Factory::create();

		$res = $this->db->get_where('users',['role_id'=>'3'])->result_array();

		if(!empty($res)){
			foreach($res as $r){
				$all_channel = $this->db->select('id')->get_where('user_channels',['user_id'=>$r['id']])->result_array();
			}
		}
	}

	public function create_picture(){
		$faker = Faker\Factory::create();

		for($j=0;$j<rand(1,2);$j++){
			$text = $faker->realText(25);			
			echo slugify($text);
		}

		// echo '<img src="'.$faker->imageUrl($width = 640, $height = 480).'" width="640" height="480" />';
		// $img_url = $faker->imageUrl($width = 640, $height = 480);		
		// $random_name = random_string('alnum',20).'.jpg';
		// $contents=file_get_contents($img_url);
		// $save_path="uploads/avatars/".$random_name;
		// file_put_contents($save_path,$contents);	 
	}

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */