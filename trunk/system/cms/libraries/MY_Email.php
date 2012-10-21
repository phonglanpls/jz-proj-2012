<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Email - Allows for email config settings to be stored in the db.
 *
 * @author      Stephen Cozart - PyroCMS dev team
 * @package 	PyroCMS
 * @subpackage  library
 * @category	email
 */
class MY_Email extends CI_Email {

    /**
     * Constructor method
     *
     * @access public
     * @return void
     */
    function __construct($config = array())
    {
        parent::__construct($config);

        //set mail protocol
        $config['protocol'] = Settings_class::get('mail_protocol');

        //set a few config items (duh)
        $config['mailtype']	= "html";
        $config['charset']	= "utf-8";
        $config['crlf']		= "\r\n";
        $config['newline']	= "\r\n";

        //sendmail options
        if (Settings_class::get('mail_protocol') == 'sendmail')
        {
                if(Settings_class::get('mail_sendmail_path') == '')
                {
                        //set a default
                        $config['mailpath'] = '/usr/sbin/sendmail';
                }
                else
                {
                        $config['mailpath'] = Settings_class::get('mail_sendmail_path');
                }
        }

        //smtp options
        if (Settings_class::get('mail_protocol') == 'smtp')
        {
                $config['smtp_host'] = Settings_class::get('mail_smtp_host');
                $config['smtp_user'] = Settings_class::get('mail_smtp_user');
                $config['smtp_pass'] = Settings_class::get('mail_smtp_pass');
                $config['smtp_port'] = Settings_class::get('mail_smtp_port');
        }

        $this->initialize($config);
    }
}


class Settings_class{	
	public static function get($slug){
		$CI = & get_instance();
		$rs = $CI->db->where('slug',$slug)->get('default_settings')->result();
		if(count($rs)){
			$value = ($rs[0]->value != '') ? $rs[0]->value : $rs[0]->default;
			return $value;
		}
		return '';
	}
}


/* End of file MY_Email.php */