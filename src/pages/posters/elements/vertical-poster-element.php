<?php
if (!isset($index) || !isset($headline) || !isset($text) || !isset($image) || !isset($alt)) {
  throw new Exception('Missing required properties: index, headline, text, image, alt');
} ?>

<article class="content-item" draggable="true">
    <?php if ($index % 2 != 0): ?>
      <div class="item-image">
        <img alt="<?php echo $alt; ?>" src="<?php echo $image; ?>" />
      </div>
    <?php endif; ?>

  <h2 class="item-headline"><?php echo $headline; ?></h2>
  <div class="item-text">
      <?php echo $text; ?>
  </div>

    <?php if ($index % 2 == 0): ?>
      <div class="item-image">
        <img alt="<?php echo $alt; ?>" src="<?php echo $image; ?>" />
      </div>
    <?php endif; ?>
</article>
