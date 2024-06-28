<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Musiview\Request\Html;

use Module\Lipupini\Collection\MediaProcessor\Parsedown;
use Module\Lipupini\Request;

class MoneyRequest extends Request\Html {
	protected array $sections = [];

	public function initialize(): void  {
		if (parse_url($_SERVER['REQUEST_URI_DECODED'], PHP_URL_PATH) !== $this->system->baseUriPath . 'money') {
			return;
		}

		$contentDirectory = __DIR__ . '/../../Content';
		$this->sections = [
			'donate-info' => Parsedown::instance()->text(file_get_contents($contentDirectory . '/Money.md')),
		];

		$this->pageTitle = 'Money@' . $this->system->host;
		$this->addStyle('/css/Global.css');
		$this->addStyle('/css/Markdown.css');
		$this->renderHtml();
		$this->system->responseType = 'text/html';
		$this->system->shutdown = true;
	}

	public function renderHtml(): void {
		ob_start();
		header('Content-type: text/html');
		require(__DIR__ . '/../../Html/Content.php');
		$this->system->responseContent = ob_get_clean();
	}
}
