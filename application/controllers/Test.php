<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public $name = '';
    public $subscription_price = 20;

	public function __construct(){
		parent::__construct();
		$this->load->helper(['paypal_helper']);	
        $this->load->library('unirest');
        $this->load->model('Rfp_model');
        // $this->session->sess_destroy();
        // pr($this->session->all_userdata(),1);
	}
		
	public function index(){
		
		// $data['subscribe'] = base_url().'test/subscribe';
		// $this->load->view('test/newtest',$data);

        $this->test_demo_mail();
	}


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function my_func(){
        pr($this->Rfp_model->check_if_close_rfp('7'));
    }

	public function subscribe(){
        
        $currencyCodeType = "USD";
        $paymentType = "Sale";        
        $returnURL = base_url().'test/review';
        $cancelURL = base_url().'test/';

        //'-------------------------------------------------
        $resArray = CallShortcutExpressCheckout('37',$returnURL, $cancelURL);
        
        // pr($resArray,1);
        $ack = strtoupper($resArray["ACK"]);
    	if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
            RedirectToPayPal($resArray["TOKEN"]);
        } else {

        }
	}

	public function review() {
        $data = array();
        $PayerID = $this->input->get('PayerID');
        $data['back'] = base_url().'test';
        $data['subscribe'] = base_url().'test/subscribe';        

        if (isset($_REQUEST['token'])) {
            $token = $_REQUEST['token'];
            
            $ret_arr = CreateBillingAgreement($token);

            // pr($ret_arr,1);
            if($ret_arr != ''){
                $payer_id = $_REQUEST['PayerID'];
                $token= $_REQUEST['token'];
                $res1= DoExpressCheckoutPayment($payer_id,$token);
                echo "Billing Agreement : <br>";
                pr($ret_arr);
                echo "Payment Transaction : <br>";
                // pr($res1);
                // $retttt = DoReferenceTransaction($ret_arr['BILLINGAGREEMENTID']);
                echo "RefrenceTransaction : <br>";
                pr($retttt,1);
            }

        }

    }
 
    public function get_detail(){
        $res = GetRecurringPaymentsProfileDetails('B-0GP68457DN280314Y');
        pr($res);
    }

    public function new_test(){
        $str = 'B-8D922687M2395522M';
        // B-8D922687M2395522M
        $res = DoReferenceTransaction($str);
        pr($res,1);
    }

    public function paypal_info($token='3J738948YH795854P'){
        $data=GetTransactionDetails($token);
        pr($data,1);
    }
    
    public function mm(){
        $all_details = get_detail_billing_agreement('B-7B6764950D0480641');

        pr($all_details,1);
    }           

    public function cancel_agreement(){
         // B-039652215T6598427
        $res = cancel_billing_agreement();
        pr($res,1);
    }

    public function mycall(){
        $this->load->library('unirest');
        $url = base_url().'cron/check_status';
        $res = $this->unirest->get($url);   
                                
    }

    public function map(){

        $this->load->library('googlemaps');

        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'myPlaceTextBox';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'alert(\'You selected a place\');';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();

        $data['subview']="test_view";

        // $this->load->view('test_view', $data);
        $this->load->view('front/layouts/layout_main',$data);
    }

    public function test_page(){
        $data['subview']="test_view";
        $this->load->view('front/layouts/layout_main',$data);
    }

    public function send_mail(){
        // the message
        $msg = "First line of text\nSecond line of text";
        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);
        // send email
        $res=mail("dhk@narola.email","My subject",$msg);
        var_dump($res);
    }


    public function test_demo_mail(){
        $email_config = mail_config();
        $this->email->initialize($email_config);
        $subject= "Test Mail For Cron new";    
        $this->email->from('had@narola.email')
                    ->to('dhk@narola.email')
                    ->subject($subject)
                    ->message("Test demo Cron Mail Cron");
        $res = $this->email->send();
        var_dump($res); 
        // $txt = "user id date";
        // file_put_contents('logs_test.txt', $txt, FILE_APPEND);
        // echo file_exists("logs_test.txt");
    }
}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */
