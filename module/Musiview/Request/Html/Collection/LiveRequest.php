<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Musiview\Request\Html\Collection;

use Module\Lipupini\Collection;
use Module\Lipupini\Collection\MediaProcessor\Parsedown;
use Module\Lipupini\Request;

class LiveRequest extends Request\Html {
	public string|null $pageImagePreviewUri = null;
	protected array $sections = [];

	use Collection\Trait\CollectionRequest;

	public function initialize(): void {
		// The URL path must be `/@` or `/@/`
		if (!preg_match('#^' . preg_quote($this->system->baseUriPath) . 'live/(?!\?|$)#', parse_url($_SERVER['REQUEST_URI_DECODED'], PHP_URL_PATH))) {
			return;
		}
		$this->collectionNameFromSegment(2);
		$this->pageTitle = 'live@' . $this->collectionName;
		$this->addStyle('/css/Global.css');
		$this->addStyle('/css/Markdown.css');
		$this->addStyle('/css/Live.css');
		$this->addStyle('/lib/videojs/video-js.min.css');
		$this->addScript('/lib/videojs/video.min.js');
		$this->addScript('/lib/videojs/videojs-http-streaming.min.js');

		$avatarUrlPath = Collection\MediaProcessor\Avatar::avatarUrlPath($this->system, $this->collectionName);
		$this->pageImagePreviewUri = $avatarUrlPath ?? null;

		$contentDirectory = __DIR__ . '/../../../Content';
		$this->sections = [
			'about-stream' => Parsedown::instance()->text(file_get_contents($contentDirectory . '/AboutStream.md')),
		];

		$this->htmlFoot .= <<<HEREDOC
<script>
(function() {
	const vidURL = '{$this->system->env['STREAM_HOST']}/hls/{$this->collectionName}.m3u8'
	const statusURL = '{$this->system->env['STREAM_HOST']}/status?c={$this->collectionName}'
	const streamStatus = document.getElementById('stream-status')
	streamStatus.innerHTML = 'Checking stream status... <img src="/img/loading.gif" alt="Please wait...">'
	fetch(statusURL, {cache: 'no-store'})
	.then(response => response.text())
	.then(response => {
		streamStatus.remove()
		if (response !== 'online') {
			document.getElementById('about-stream').style.display = 'block';
			return
		}
		document.getElementById('livestream').style.display = 'block';
		const player = videojs('livestream', {
			liveui: true
		})
		player.src({ type: 'application/x-mpegurl', src: vidURL })
		player.ready(function(){
			player.muted(true);
			player.play()
		})
	})
})();
</script>
HEREDOC;

		$this->renderHtml();
		$this->system->shutdown = true;
	}

	public function renderHtml(): void {
		ob_start();
		require($this->system->dirModule . '/' . $this->system->frontendModule . '/Html/Collection/Live.php');
		$this->system->responseContent = ob_get_clean();
		$this->system->responseType = 'text/html';
	}
}
