<?php

/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

require(__DIR__ . '/Core/Open.php') ?>

<div class="centered-content">
<?php foreach ($this->sections as $section => $content): ?>

<section id="<?php echo htmlentities($section) ?>"><?php echo $content ?></section>
<?php endforeach ?>

</div>
<?php
require(__DIR__ . '/Core/Close.php');
