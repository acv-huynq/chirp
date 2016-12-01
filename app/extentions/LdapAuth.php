<?php

use Illuminate\Support\Facades\Facade;

class LdapAuth extends Facade {

	protected static function getFacadeAccessor() { return 'LdapAuth'; }

}