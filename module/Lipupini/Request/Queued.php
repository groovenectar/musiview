<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Lipupini\Request;

use Module\Lipupini\State;

abstract class Queued {
	public function __construct(public State $system) {
		if ($this->system->debug) {
			error_log('DEBUG: Starting request module ' . get_called_class());
		}

		$this->initialize();
	}

	abstract public function initialize(): void;
}
