<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Musiview\Request\Html;

use Module\Lipupini\Collection\MediaProcessor\Parsedown;
use Module\Lipupini\Request;

class HomepageRequest extends Request\Html {
	protected array $sections = [];

	public function initialize(): void  {
		if (parse_url($_SERVER['REQUEST_URI_DECODED'], PHP_URL_PATH) !== $this->system->baseUriPath) {
			return;
		}

		Parsedown::$baseUri = $this->system->baseUri;
		$contentDirectory = __DIR__ . '/../../Content';
		$this->sections = [
			'intro' => Parsedown::instance()->text(file_get_contents($contentDirectory . '/Homepage.md')),
		];

		$this->pageTitle = 'Homepage@' . $this->system->host;
		$this->addStyle('/css/Global.css');
		$this->addStyle('/css/Homepage.css');
		$this->addStyle('/css/Markdown.css');

		$this->htmlFoot .= <<<HEREDOC
<script>
(function() {
	const streams = ['groovenectar', 'insomniscene']
	streams.forEach(stream => {
		const statusURL = '{$this->system->env['STREAM_HOST']}/status?c=' + stream
		fetch(statusURL, {cache: 'no-store'})
		.then(response => response.text())
		.then(response => {
			if (response !== 'online') {
				return
			}
			document.querySelector('a[href="{$this->system->baseUri}live/' + stream + '"]').parentElement.classList.add('online')
		})
	})
})();
</script>
HEREDOC;

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
