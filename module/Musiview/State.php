<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Musiview;

class State extends \Module\Lipupini\State {
	public function __construct(public string $contactEmail, public string $stripeKey, ...$props) {
		parent::__construct(...$props);

		if (empty($this->env['STRIPE_KEY'])) {
			throw new Exception('Missing transaction key');
		}

		if (empty($this->env['STREAM_HOST'])) {
			throw new Exception('Missing stream host');
		}
	}
}
