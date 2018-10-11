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

	public function connect($connection) {

		try {
			$this->mkconnection = $this->getConnection($connection);
		} catch (DataFlowException $e) {
			throw new MKConnectorInvalidCredentials();
		} catch (SocketException $e) {
			throw new MKConnectorConnectionTimeout();
		}


		return $this->mkconnection;
	}

	private function getConnection($connection) {
		if ($connection == 'pppoe') {
			return (new Client(config('mk-connect.connections.pppoe.mk-ip'), config('mk-connect.connections.pppoe.mk-user'), config('mk-connect.connections.pppoe.mk-password')));
		} else if ($connection == 'hotspot') {
			return (new Client(config('mk-connect.connections.hotspot.mk-ip'), config('mk-connect.connections.hotspot.mk-user'), config('mk-connect.connections.hotspot.mk-password')));
		} else {
			throw new MKConnectorInvalidConnection();
		}
	}

	public function setRequest($command) {
		return new MKRequest($command);
	}
}
