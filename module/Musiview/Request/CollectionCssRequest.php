<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Musiview\Request;

use Module\Lipupini\Collection;
use Module\Lipupini\Collection\MediaProcessor\Request\MediaProcessorRequest;

class CollectionCssRequest extends MediaProcessorRequest {
	use Collection\Trait\CollectionRequest;
	public function initialize(): void {
		if (!($mediaRequest = $this->validateMediaProcessorRequest())) return;

		if (!preg_match('#^style.css$#', $mediaRequest, $matches)) {
			return;
		}

		$collectionCssFile = $this->system->dirCollection . '/' . $this->collectionName . '/.lipupini/style.css';
		$collectionCssCacheFile = $this->system->dirCollection . '/' . $this->collectionName . '/.lipupini/.cache/style.css';

		$this->system->responseType = 'text/css';

		if (!file_exists($collectionCssFile)) {
			file_put_contents($collectionCssFile, '');
			$this->system->responseContent = '';
		} else {
			$this->system->responseContent = file_get_contents($collectionCssFile);
		}

		Collection\Cache::createSymlink($collectionCssFile, $collectionCssCacheFile);
	}
}
