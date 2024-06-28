<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

namespace Module\Lipupini\Collection\MediaProcessor;

class Parsedown extends \Parsedown {
	public static string $baseUri = '';

	private function addTargetBlank(string $method, array $Excerpt): array|null {
		$return = parent::$method($Excerpt);
		if (!$return) {
			return null;
		}
		if (
			// If URL starts with "/" (but not "//")
			preg_match('#^/[^/]#', $return['element']['attributes']['href']) ||
			(static::$baseUri && str_starts_with($return['element']['attributes']['href'], static::$baseUri))
		) return $return;
		$return['element']['attributes']['target'] = '_blank';
		$return['element']['attributes']['rel'] = 'noopener noreferrer';
		return $return;
	}

	protected function inlineUrl($Excerpt) {
		return $this->addTargetBlank('inlineUrl', $Excerpt);
	}

	protected function inlineLink($Excerpt) {
		return $this->addTargetBlank('inlineLink', $Excerpt);
	}

	protected function inlineUrlTag($Excerpt) {
		return $this->addTargetBlank('inlineUrlTag', $Excerpt);
	}
}
