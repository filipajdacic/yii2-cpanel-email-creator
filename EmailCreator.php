<?php

namespace filipajdacic\cpanelemailcreator;

use yii\base\Component;
use \Exception;

use xmlapi\xmlapi as cPanelAPI;
/**
 * This is just an example.
 */
class EmailCreator extends Component
{
    
	/*
	 IP address of a server where you have cPanel Installed.
	*/

	public $ip;

	/* 
	cPanel Port / usually is 2083 or 2086
	*/

	public $port;

	/* 
	cPanel account username
	*/

	public $cpanel_username;

	/*
	cPanel account password
	*/

	public $cpanel_password;


	public $api;

    public function init()
    {
        parent::init();
        $this->api = $this->__initApi();
    }

	protected function __initApi() {
		$xmlapi = new xmlapi($this->ip);
		$xmlapi->set_port($this->port);
		$xmlapi->password_auth($this->cpanel_username, $this->cpanel_password);

		return $xmlapi;
	}


	public function createNewAccount($domain, $username, $password, $quota) {
		$api = $this->api;
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
			return $result->data->reason;
		}
	}


}