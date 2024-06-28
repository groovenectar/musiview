<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

use Module\Lipupini\Collection;
use Module\Lipupini\L18n\A;
use Module\Lipupini\Collection\Utility;

$collectionUtility = new Collection\Utility($this->system);
$parentPathLastSegment = explode('/', preg_replace('#\?.*$#', '', $this->parentPath))[substr_count($this->parentPath, '/')];

require(__DIR__ . '/../Core/Open.php') ?>

<div id="media-item" class="<?php echo htmlentities($this->fileData['mediaType']) ?>-item">
<header>
	<nav>
		<div class="pagination parent"><a href="/<?php echo htmlentities($this->parentPath) ?>" class="button" title="<?php echo $this->parentPath ? htmlentities($parentPathLastSegment) : A::z('Homepage') ?>"><img src="/img/arrow-up-bold.svg" alt="<?php echo $this->parentPath ? htmlentities($parentPathLastSegment) : A::z('Homepage') ?>"></a></div>
	</nav>
</header>
<?php if ($this->purchased === true) : ?>

<div class="purchased">
	<div>
		<span>Thank you!</span><br><br>
		<strong><a href="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/large', $this->collectionFilePath)) ?>" target="_blank">Download Link</a></strong><br><br>
		Be sure to save your copy now.
	</div>
</div>
<?php endif ?>

<main>
<?php
switch ($this->fileData['mediaType']) :
case 'audio' : ?>

<div class="audio-container<?php echo !empty($this->fileData['thumbnail']) ? ' has-thumbnail' : '' ?>" title="<?php echo htmlentities($this->fileData['caption']) ?>">
	<div class="caption">
		<span><?php echo htmlentities($this->fileData['caption']) ?></span>
	</div>
	<audio id="a-<?php echo sha1($this->collectionFilePath) ?>" controls="controls" poster="<?php echo $collectionUtility::urlEncodeUrl($this->fileData['thumbnail'] ?? $this->fileData['waveform']) ?>" preload="none" class="video-js" data-setup="{}">
		<source src="<?php echo $collectionUtility::urlEncodeUrl($this->system->staticMediaBaseUri . $this->collectionName . '/audio/' . $this->collectionFilePath) ?>" type="<?php echo htmlentities($this->fileData['mimeType']) ?>">
	</audio>
	<style>#a-<?php echo sha1($this->collectionFilePath) ?> .vjs-progress-control{background-image:url('<?php echo $collectionUtility::urlEncodeUrl($this->fileData['waveform'] ?? '') ?>')}</style>
</div>
<?php break;
case 'image' : ?>

<?php if (!is_null($this->purchased)) : ?>

<div><a href="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/watermark', $this->collectionFilePath)) ?>" target="_blank" class="watermark-link">Watermarked Version</a></div>
<?php if ($this->purchased === true) : ?>
<a href="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/large', $this->collectionFilePath)) ?>" target="_blank" class="image-container">
	<img src="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/large', $this->collectionFilePath)) ?>" title="<?php echo htmlentities($this->fileData['caption']) ?>">
</a>
<?php else : ?>
<a href="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/medium', $this->collectionFilePath)) ?>" target="_blank" class="image-container">
	<img src="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/medium', $this->collectionFilePath)) ?>" title="<?php echo htmlentities($this->fileData['caption']) ?>">
</a>
<?php endif ?>
<?php else : ?>
<a href="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/large', $this->collectionFilePath)) ?>" target="_blank" class="image-container">
	<img src="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/medium', $this->collectionFilePath)) ?>" title="<?php echo htmlentities($this->fileData['caption']) ?>">
</a>
<?php endif ?>

<?php break;
case 'text' : ?>

<div class="text-container">
	<object type="text/html" data="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl( $this->collectionName, 'text/html', $this->collectionFilePath)) ?>.html"></object>
</div>
<?php break;
case 'video' : ?>

<div class="video-container">
	<video class="video-js" controls loop preload="metadata" title="<?php echo htmlentities($this->fileData['caption']) ?>" poster="<?php echo $collectionUtility::urlEncodeUrl($this->fileData['thumbnail'] ?? '') ?>" data-setup="{}">
		<source src="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'video', $this->collectionFilePath)) ?>" type="<?php echo htmlentities($this->fileData['mimeType']) ?>">
	</video>
</div>
<?php break;
endswitch;

if (!is_null($this->purchased)) : ?>
<?php if (!$this->purchased) : ?>

<form class="purchase" action="/purchase/<?php echo $collectionUtility::urlEncodeUrl($this->collectionName . '/' . $this->collectionFilePath) ?>" method="get">
	<div>
		<button type="submit">
			<strong><?php echo htmlentities($this->purchaseButtonLabel['h1']) ?></strong><br>
			<small><?php echo htmlentities($this->purchaseButtonLabel['h2']) ?></small>
		</button>
	</div>
</form>
<?php endif ?>

<div class="qr-image">
	<img src="<?php echo Utility::urlEncodeUrl($this->system->baseUri . 'qr/' . $this->collectionName . '/' . $this->collectionFilePath . '.html') ?>">
</div>
<?php endif ?>

</main>
</div>

<?php require(__DIR__ . '/../Core/Close.php') ?>
