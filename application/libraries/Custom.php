<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Custom{
	public $CI;
    public function __contruct($params =array())
    {
        $this->CI->config->item('base_url');
        $this->CI->load->helper('url');
        $this->CI->load->database();
        $this->CI->library('session');
        $this->CI->library('email');
        $this->CI =& get_instance();
    }
    function sendEmailSmtp($subject,$body_email,$to,$attachment='',$company =array(),$attachment2='')
    {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
        $this->CI->email->from($company);
        $this->CI->email->reply_to($company);
        $this->CI->email->to($to);
        $this->CI->email->cc($cc);
        $this->CI->email->subject($subject);
        $this->CI->email->message($body_email);
        if (!empty($attachment)) {
                $this->CI->email->attach($attachment);
        }
        if (!empty($attachment2)) {
                $this->CI->email->attach($attachment2);
        }
        if(!empty($attachment))
        {
                unlink($attachment);
        }
        $this->CI->email->set_mailtype("html");
        $this->CI->email->send();
        //echo $this->CI->email->print_debugger();
   }
    function sendEmailSmtp_old($subject,$body_email,$to,$attachment='',$company,$attachment2='')
    {
		$CI =& get_instance();
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'tls://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'ingeniousglobalservices@gmail.com';
		$config['smtp_pass']    = 'lowolyomopnrbkvc';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not      
		$CI->email->initialize($config);
		$CI->email->from('no-reply@sse.accordance.co.in',$company);
		$CI->email->reply_to('no-reply@sse.accordance.co.in',$company);
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($body_email);
		if (!empty($attachment)) {
			$CI->email->attach($attachment);
		}
		if (!empty($attachment2)) {
			$CI->email->attach($attachment2);
		}
		if(!empty($attachment))
		{
			unlink($attachment);
		}
		$CI->email->send();
		//echo $CI->email->print_debugger();
   }
}

?> 