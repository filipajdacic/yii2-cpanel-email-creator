<?php

namespace filipajdacic\cpanelemailcreator;

use yii\base\Component;
use \Exception;

use xmlapi\xmlapi as cPanelAPI;

/**
 * EmailCreator Class
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 * @license MIT
 * @copyright (C) 2016, Filip Ajdacic
 * @see github.com/filipajdacic
 * */

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

    /**
     * __initApi()
     * This method is used to initialize needed cPanel API lib (xmlapi) and set
     * parameters provided in configuration file.
     * @return object $xmlapi;
     * */

	protected function __initApi() {
		$xmlapi = new xmlapi($this->ip);
		$xmlapi->set_port($this->port);
		$xmlapi->password_auth($this->cpanel_username, $this->cpanel_password);

		return $xmlapi;
	}


	/**
	 * createNewAccount()
	 * @param string $domain
	 * @param string $username
	 * @param string $password
	 * @param integer $quota
	 * 
	 * This method is used to create a new email account in cPanel mail server.
	 * 
	 * @return mixed boolean;
	 * */

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


	/**
	 * changeEmailQuota()
	 * @param string $domain
	 * @param string $username
	 * @param integer $newQuota
	 * 
	 * This method is used to change email account disk quota on cPanel mail server.
	 * 
	 * @return mixed boolean;
	 * */

	public function changeEmailQuota($domain, $username, $newQuota) {
		$api = $this->api;
		$call = array(
			"domain" => $domain,
			"email" => $username,
			"quota" => $newQuota
		);

		$result = $api->api2_query($this->cpanel_username, "Email", "editquota", $call); 
		if($result->data->result == 1) {
			return true;
		} else {
			return $result->data->reason;
		}

	}


	/**
	 * changeAccountPassword()
	 * @param string $domain
	 * @param string $username
	 * @param string $newPassword
	 * 
	 * This method is used to change mail account password in cPanel mail server.
	 * 
	 * @return mixed boolean;
	 * */

	public function changeAccountPassword($domain, $username, $newPassword) {
		$api = $this->api;
		$call = array(
			'domain' => $domain,
			'email' => $username,
			'password' => $newPassword
		);

		$result = $api->api2_query($this->cpanel_username, "Email", "passwdpop", $call);
		if($result->data->result == 1) {
			return true;
		} else {
			return $result->data->reason;
		}
	}

	/**
	 * deleteMailAccount()
	 * @param $domain
	 * @param $username
	 * 
	 * This method is used to delete existing email account from cPanel mail server.
	 * 
	 * @return mixed boolean;
	 * */

	public function deleteMailAccount($domain, $username) {
		$api = $this->api;
		$call = array(
			"domain" => $domain, 
			"email" => $username
		);
	
		$result = $api->api2_query($this->cpanel_username, "Email", "delpop", $call);
		if($result->data->result == 1) {
			return true;
		} else {
			return $result->data->reason;
		}
	}

}