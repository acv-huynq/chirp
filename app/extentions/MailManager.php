<?php

use Illuminate\Support\Facades\Facade;

class MailManager extends Facade {

	protected static function getFacadeAccessor() { return 'MailManager'; }

}