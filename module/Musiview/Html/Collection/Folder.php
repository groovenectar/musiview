<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

use Module\Lipupini\Collection\Utility;
use Module\Lipupini\L18n\A;

$collectionUtility = new Utility($this->system);
$parentPathLastSegment = explode('/', preg_replace('#\?.*$#', '', $this->parentPath))[substr_count($this->parentPath, '/')];

$hasPages = $this->prevUrl || $this->nextUrl;
$showParentPath = $this->parentPath !== '@' || !empty($this->collectionProfile['showIndexLink']);
$showNav = $hasPages || $showParentPath;

require(__DIR__ . '/../Core/Open.php') ?>

<div id="folder" class="<?php echo $showNav ? 'show' : 'hide' ?>Nav">
	<?php if ($showNav) : ?>

<header>
	<nav>
		<?php if ($hasPages): ?>

		<div class="pagination previous"><a href="<?php echo $this->prevUrl ? htmlentities($this->prevUrl) : 'javascript:void(0)' ?>" class="button<?php if (! $this->prevUrl) : ?> disabled<?php endif ?>" title="<?php echo A::z('Previous') ?>"><img src="/img/arrow-left-bold.svg" alt="<?php echo A::z('Previous') ?>"></a></div>
		<?php endif ?>

		<div class="pagination parent">
			<?php if ($showParentPath) : ?>

			<a href="/<?php echo htmlentities($this->parentPath) ?>" class="button" title="<?php echo $this->parentPath ? htmlentities($parentPathLastSegment) : A::z('Homepage') ?>"><img src="/img/arrow-up-bold.svg" alt="<?php echo $this->parentPath ? htmlentities($parentPathLastSegment) : A::z('Homepage') ?>"></a>
			<?php endif ?>

		</div>
		<?php if ($hasPages): ?>

		<div class="pagination next"><a href="<?php echo $this->nextUrl ? htmlentities($this->nextUrl) : 'javascript:void(0)' ?>" class="button<?php if (!$this->nextUrl) : ?> disabled<?php endif ?>" title="<?php echo A::z('Next') ?>"><img src="/img/arrow-right-bold.svg" alt="<?php echo A::z('Next') ?>"></a></div>
		<?php endif ?>

	</nav>
</header>
<?php endif ?>
<?php if (!empty($this->collectionProfile['summary'])) : ?>

<div class="summary">
	<h4><?php echo htmlentities($this->collectionProfile['summary']) ?></h4>
</div>
<?php endif ?>

<?php if (!empty($this->folderInfo['description'])) : ?>

<div class="description">
	<p><?php echo htmlentities($this->folderInfo['description']) ?></p>
</div>
<?php endif ?>

<main class="grid">
<?php
foreach ($this->collectionData as $filename => $item) :
$extension = pathinfo($filename, PATHINFO_EXTENSION);
if ($extension) :
switch ($item['mediaType']) :
case 'audio' : ?>

<div class="audio-container<?php echo !empty($item['thumbnail']) ? ' has-thumbnail' : '' ?>" title="<?php echo htmlentities($item['caption']) ?>">
	<div class="caption">
		<a href="/@<?php echo $collectionUtility::urlEncodeUrl($this->collectionName . '/' . $filename) ?>.html"><?php echo htmlentities($item['caption']) ?></a>
	</div>
	<audio id="a-<?php echo sha1($filename) ?>" controls="controls" poster="<?php echo $collectionUtility::urlEncodeUrl($item['thumbnail'] ?? $item['waveform']) ?>" preload="none" class="video-js" data-setup="{}">
		<source src="<?php echo $collectionUtility::urlEncodeUrl($this->system->staticMediaBaseUri . $this->collectionName . '/audio/' . $filename) ?>" type="<?php echo htmlentities($item['mimeType']) ?>">
	</audio>
	<style>#a-<?php echo sha1($filename) ?> .vjs-progress-control{background-image:url('<?php echo $collectionUtility::urlEncodeUrl($item['waveform'] ?? '') ?>')}</style>
</div>
<?php break;
case 'image' : ?>

<a
	class="image-container"
	href="/@<?php echo $collectionUtility::urlEncodeUrl($this->collectionName . '/' . $filename) ?>.html"
	title="<?php echo htmlentities($item['caption']) ?>"
>
	<img src="<?php echo $collectionUtility::urlEncodeUrl($collectionUtility->assetUrl($this->collectionName, 'image/thumbnail', $filename)) ?>" loading="lazy">
</a>
<?php break;
case 'text' : ?>

<a class="text-container" href="/@<?php echo $collectionUtility::urlEncodeUrl($this->collectionName . '/' . $filename) ?>.html">
	<div><?php echo htmlentities($item['caption']) ?></div>
</a>
<?php break;
case 'video' : ?>

<div class="video-container" title="<?php echo htmlentities($item['caption']) ?>">
	<div class="caption"><a href="/@<?php echo $collectionUtility::urlEncodeUrl($this->collectionName . '/' . $filename) ?>.html"><?php echo htmlentities($item['caption']) ?></a></div>
	<video class="video-js" controls="" preload="metadata" loop="" poster="<?php echo $collectionUtility::urlEncodeUrl($item['thumbnail'] ?? '') ?>" data-setup="{}">
		<source src="<?php echo $collectionUtility::urlEncodeUrl($this->system->staticMediaBaseUri . $this->collectionName . '/video/' . $filename) ?>" type="<?php echo htmlentities($item['mimeType']) ?>">
	</video>
</div>
<?php break;
endswitch;
else : ?>

<a class="folder-container" href="/@<?php echo $collectionUtility::urlEncodeUrl($this->collectionName . '/' . $filename) ?>" title="<?php echo htmlentities($item['caption']) ?>">
	<span><?php echo htmlentities($item['caption']) ?></span>
</a>
<?php endif;
endforeach ?>

</main>
<footer>
<?php if ($showNav) : ?>

	<nav>
		<?php if ($hasPages): ?>

		<div class="pagination previous"><a href="<?php echo $this->prevUrl ? htmlentities($this->prevUrl) : 'javascript:void(0)' ?>" class="button<?php if (!$this->prevUrl) : ?> disabled<?php endif ?>" title="<?php echo A::z('Previous') ?>"><img src="/img/arrow-left-bold.svg" alt="<?php echo A::z('Previous') ?>"></a></div>
		<?php endif ?>

		<div class="pagination parent"></div>

		<?php if ($hasPages): ?>

		<div class="pagination next"><a href="<?php echo $this->nextUrl ? htmlentities($this->nextUrl) : 'javascript:void(0)' ?>" class="button<?php if (!$this->nextUrl) : ?> disabled<?php endif ?>" title="<?php echo A::z('Next') ?>"><img src="/img/arrow-right-bold.svg" alt="<?php echo A::z('Next') ?>"></a></div>
		<?php endif ?>

	</nav>
	<?php endif ?>
</footer>
</div>

<?php require(__DIR__ . '/../Core/Close.php') ?>
