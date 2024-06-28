<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

require(__DIR__ . '/../Core/Open.php') ?>

<div class="centered-content">
	<span id="stream-status"></span>
	<video class="video-js" id="livestream" controls style="display:none;"></video>
	<?php foreach ($this->sections as $section => $content): ?>

	<section id="<?php echo htmlentities($section) ?>" style="display:none;"><?php echo $content ?></section>
	<?php endforeach ?>
</div>

<?php require(__DIR__ . '/../Core/Close.php') ?>
