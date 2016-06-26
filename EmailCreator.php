<?php

namespace filipajdacic\cpanelemailcreator;

use yii\base\Component;
use \Exception;

use vendor\xmlapi;

/**
 * This is just an example.
 */
class EmailCreator extends Component
{
    

	/*
	 IP address of a server where you have cPanel Installed.
	*/

	private $ip;

	/* 
	cPanel Port / usually is 2083 or 2086
	*/

	private $port;

	/* 
	cPanel account username
	*/

	private $cpanel_username;

	/*
	cPanel account password
	*/

	private $cpanel_password;



    public function init()
    {
        parent::init();

		$this->ip = $ip;
		$this->cpanel_username = $cpanel_username;
		$this->cpanel_password = $cpanel_password;
		$this->port = $port;
    }


	protected function __initApi() {
		$xmlapi = new xmlapi($this->ip);
		$xmlapi->set_port($this->port);
		$xmlapi->password_auth($this->cpanel_username, $this->cpanel_password);

		return $xmlapi;
	}


	public function createNewAccount($domain, $username, $password, $quota) {
		$api = $this->__initApi();
		$call = array(
			'domain' => $domain, 
			'email' => $username, 
			'password' => $password, 
			'quota' => $quota
		);

		$result = $api->api2_query($this->cpanel_username, "Email", "addpop", $call); 
		if($result->data->result == 1) {
			return true;
		} else {
			throw new CHttpException(404, 'E-mail account is not created: '.$result->data->reason);
		}
	}


}
