<?php

namespace PLSS\MKConnector\Facades;

use Illuminate\Support\Facades\Facade;

class MKConnectorFacebookLoginFacade extends Facade {
	/**
	 * Get the binding in the IoC container
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'MKConnectorFacebookLogin';
	}
}