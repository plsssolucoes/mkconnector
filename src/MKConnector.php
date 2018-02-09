<?php

namespace PLSS\MKConnector;

use PEAR2\Net\RouterOS\Client;
use PEAR2\Net\RouterOS\SocketException;
use PEAR2\Net\RouterOS\DataFlowException;
use PEAR2\Net\RouterOS\Request as MKRequest;
use PLSS\MKConnector\Exceptions\MKConnectorConnectionTimeout;
use PLSS\MKConnector\Exceptions\MKConnectorInvalidCredentials;

class MKConnector
{
	/*
	 * Variavel contendo a conexão com MK
	 */
	public $mkconnection;

	/*
	 * Variveis contendo respectivamente ip, usuario e senha para conexao com MK.
	 */
	private $mk_ip;
	private $mk_user;
	private $mk_password;

	public function __construct() {
		$this->mk_ip = config('mk-connect.mk-ip');
		$this->mk_user = config('mk-connect.mk-user');
		$this->mk_password = config('mk-connect.mk-password');
	}

	public function connect() {
		try {
			$this->mkconnection = new Client($this->mk_ip, $this->mk_user, $this->mk_password);
		} catch (DataFlowException $e) {
			throw new MKConnectorInvalidCredentials();
		} catch (SocketException $e) {
			throw new MKConnectorConnectionTimeout();
		}


		return $this->mkconnection;
	}

	public function setRequest($command) {
		return new MKRequest($command);
	}
}
