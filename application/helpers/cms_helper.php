<?php

function pr($data, $is_die = null)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if (!empty($is_die))
    {
        die();
    }
}

function byteFormat($bytes, $unit = "", $decimals = 2)
{
    $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4,
        'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);

    $value = 0;
    if ($bytes > 0)
    {
        // Generate automatic prefix by bytes 
        // If wrong prefix given
        if (!array_key_exists($unit, $units))
        {
            $pow = floor(log($bytes) / log(1024));
            $unit = array_search($pow, $units);
        }

        // Calculate byte value by prefix
        $value = ($bytes / pow(1024, floor($units[$unit])));
    }

    // If decimals is not numeric or decimals is less than 0 
    // then set default value
    if (!is_numeric($decimals) || $decimals < 0)
    {
        $decimals = 2;
    }

    // Format output
    return sprintf('%.' . $decimals . 'f', $value);
}

function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text))
    {
        return 'n-a';
    }
    return $text;
}

function getMimeType($filename)
{
    $mimetype = false;
    if (function_exists('finfo_fopen'))
    {
        // open with FileInfo
    }
    elseif (function_exists('getimagesize'))
    {
        // open with GD
    }
    elseif (function_exists('exif_imagetype'))
    {
        // open with EXIF
    }
    elseif (function_exists('mime_content_type'))
    {
        $mimetype = mime_content_type($filename);
    }
    return $mimetype;
}

function qry($is_die = false)
{
    $CI = & get_instance();
    print_r($CI->db->last_query());
    if ($is_die == true)
    {
        die();
    }
}

function is_loggedin()
{
    $CI = & get_instance();
    return $CI->session->userdata('loggedin');
}

function is_client_loggedin()
{
    $CI = & get_instance();
    return $CI->session->userdata('client');
}

// v! Custom Flash message to dispay flash message dynamically
// For use this func you need to set flash message in an array
// class 'danger' can be replace with success or primary
// $this->session->set_flashdata('message',['message'=>'my message','class'=>'danger']);
function my_flash($message)
{
    $ret_str = '';
    if (!empty($message))
    {
        $ret_str .= '<div class="alert alert-' . $message['class'] . ' alert-styled-left alert-arrow-left alert-bordered">';
        $ret_str .= '<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>';
        $ret_str .= '<span class="text-semibold">' . $message['message'] . '</span></div>';
    }
    return $ret_str;
}

function pagination_config()
{

    $config['full_tag_open'] = '<div><ul class="pagination pagination-small pagination-centered">';
    $config['full_tag_close'] = '</ul></div>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
    $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

    $config['next_tag_open'] = "<li>";
    $config['next_tagl_close'] = "</li>";

    $config['prev_tag_open'] = "<li>";
    $config['prev_tagl_close'] = "</li>";

    $config['first_tag_open'] = "<li>";
    $config['first_tagl_close'] = "</li>";

    $config['last_tag_open'] = "<li>";
    $config['last_tagl_close'] = "</li>";
    $config['num_links'] = 5;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'per_page';
    return $config;
}

function pagination_front_config()
{

    $config['full_tag_open'] = '<div><ul class="pagination">';
    $config['full_tag_close'] = '</ul></div>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
    $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

    $config['next_tag_open'] = "<li>";
    $config['next_tagl_close'] = "</li>";

    $config['prev_tag_open'] = "<li>";
    $config['prev_tagl_close'] = "</li>";

    $config['first_tag_open'] = "<li>";
    $config['first_tagl_close'] = "</li>";

    $config['last_tag_open'] = "<li>";
    $config['last_tagl_close'] = "</li>";
    $config['num_links'] = 5;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'per_page';
    return $config;
}

function mail_config()
{

    $configs = array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'demo.narola@gmail.com',
        'smtp_pass' => 'Narola21#',
        'smtp_crypto' => 'ssl',
        'transport' => 'Smtp',
        'charset' => 'utf-8',
        'newline' => "\r\n",
        'headerCharset' => 'iso-8859-1',
        'mailtype' => 'html'
    );

    return $configs;
}


function send_mail($to = '', $template = '', $data = []) {
    if (empty($to) || empty($template) || empty($data)) {
        return false;
    }
    $ci = &get_instance();
    $ci->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'demo.narola@gmail.com';
//    $config['smtp_user'] = 'hpa.narola1111@gmail.com';
//    $config['smtp_pass'] = 'narola21';
    $config['smtp_pass'] = 'Narola21#';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $ci->email->initialize($config);

    $ci->email->to($to);
    $ci->email->from('no-reply@videosite.com');
    $ci->email->subject($data['subject']);
    $view = $ci->load->view('email_templates/' . $template, $data, TRUE);
    $ci->email->message($view);
    $ci->email->send();
}
/* For Encode ID  (DHK)
  /* Param 1 : ID
 */

function encode($input)
{
    return urlencode(base64_encode($input));
}

/* For Decode ID  (DHK)
  /* Param 1 : ID
 */

function decode($input)
{
    return base64_decode(urldecode($input));
}

/*  For time Ago 
 *   Param 1 : DateTime
 */

function time_ago($date)
{

    if (empty($date))
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
    $now = time();
    $unix_date = strtotime($date);

    // check validity of date

    if (empty($unix_date))
    {
        return "";
    }

    // is it future date or past date
    if ($now > $unix_date)
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }
    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++)
    {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if ($difference != 1)
    {
        $periods[$j] .= "s";
    }

    return "$difference $periods[$j] {$tense}";
}

/* For Fetch config value using key (DHK)
  /* Param 1 : $key value
 */

function config($key = '')
{
    $CI = & get_instance();
    $CI->db->where('key', $key);
    $query = $CI->db->get('config');
    $res = $query->row_array();
    return isset($res['val']) ? $res['val'] : '';
}

/* For Fetch Email Content (DHK)
  /* Param 1 :
 */

function fetch_email_content($template_name)
{
    $CI = & get_instance();
    $CI->db->where('slug', $template_name);
    $query = $CI->db->get('email_template');
    $res = $query->row_array();
    if ($res)
    {
        $res = $res['description'];
    }
    else
    {
        $res = '';
    }
    return $res;
}

/* For Fetch User Name By Id (DHK)
  /* Param 1 :
 */

function fetch_username($user_id)
{
    $CI = & get_instance();
    $CI->db->where('id', $user_id);
    $query = $CI->db->get('users');
    $res = $query->row_array();
    return $res['fname'] . " " . $res['lname'];
}

/* For Fetch Particular Data with field (DHK)
  /* Param 1 : Table Name
  /* Param 2 : Where Condition
  /* Param 3 : Field Name (Optional)
 */

function fetch_row_data($table, $where = '', $field = '')
{
    $CI = & get_instance();
    $CI->db->where($where);
    $query = $CI->db->get($table);
    $res = $query->row_array();
    if ($field)
    {
        return $res[$field];
    }
    else
    {
        return $res;
    }
}

function check_admin_login()
{
    $CI = & get_instance();
    $res_data = $CI->session->userdata('admin');

    $current_class = $CI->router->fetch_class();
    $allowed_class = ['dashboard', 'rfp', 'contact_inquiry', 'patient', 'doctor'];

    if (empty($res_data))
    {
        redirect('admin');
    }
    else
    {
        // v! condirion for role is an agent
        if ($res_data['role_id'] == '3')
        {
            if (in_array($current_class, $allowed_class) == false)
            {
                redirect('admin');
            }
        }
    }
}

function get_no_of_days($start_date)
{

    $current_date = date('Y-m-d');
    $start_date_timestamp = strtotime($start_date);
    $end_date_timestamp = strtotime($current_date);

    $timeDiff = abs($end_date_timestamp - $start_date_timestamp);
    $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
    // and you might want to convert to integer
    return $numberDays = intval($numberDays);
}

function detect_device()
{
    $CI = & get_instance();
    $CI->load->library('user_agent');
    $agent = $CI->agent->mobile();
    // return 'mobile';
    if ($agent != '')
    {
        return 'mobile';
    }
    else
    {
        return 'pc';
    }
}

function get_ago_time($start_date, $end_date)
{
    $start_date = new DateTime($start_date);
    $since_start = $start_date->diff(new DateTime($end_date));
    if ($since_start->y == 0)
    {
        if ($since_start->m == 0)
        {
            if ($since_start->d == 0)
            {
                if ($since_start->h == 0)
                {
                    if ($since_start->m == 0)
                    {
                        echo "just now";
                    }
                    else
                    {
                        echo $since_start->m . ' minutes ago';
                    }
                }
                else
                {
                    echo $since_start->h . ' hours ago';
                }
            }
            else
            {
                echo $since_start->d . ' days ago';
            }
        }
        else
        {
            echo $since_start->m . ' months ago';
        }
    }
    else
    {
        echo $since_start->y . ' years ago';
    }
//    echo $since_start->days . ' days total<br>';
//    echo $since_start->y . ' years<br>';
//    echo $since_start->m . ' months<br>';
//    echo $since_start->d . ' days<br>';
//    echo $since_start->h . ' hours<br>';
//    echo $since_start->i . ' minutes<br>';
//    echo $since_start->s . ' seconds<br>';
}

function custom_admin_show_404($page = '', $log_error = TRUE) {
    $CI = & get_instance();
    $CI->load->view('admin/layouts/show_404');
    echo $CI->output->get_output();
    exit; // EXIT_UNKNOWN_FILE
}

function custom_front_show_404($page = '', $log_error = TRUE) {
    $CI = & get_instance();
    $CI->load->view('front/layouts/show_404');
    echo $CI->output->get_output();
    exit; // EXIT_UNKNOWN_FILE
}