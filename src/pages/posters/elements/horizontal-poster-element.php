<?php
if (!isset($index) || !isset($headline) || !isset($text) || !isset($image) || !isset($alt)) {
  throw new Exception('Missing required properties: index, headline, text, image, alt');
} ?>

<article class="content-item">
  <div class="item-column item-column-left">
      <?php if ($index % 2 == 0): ?>
        <div class="item-image">
          <img alt="<?php echo $alt; ?>" src="<?php echo $image; ?>" />
        </div>
      <?php else: ?>
        <h2 class="item-headline"><?php echo $headline; ?></h2>
        <div class="item-text">
          <p>
              <?php echo $text; ?>
          </p>
        </div>
      <?php endif; ?>
  </div>
  <div class="item-column item-column-right">
      <?php if ($index % 2 != 0): ?>
        <div class="item-image">
          <img alt="<?php echo $alt; ?>" src="<?php echo $image; ?>" />
        </div>
      <?php else: ?>
        <h2 class="item-headline"><?php echo $headline; ?></h2>
        <div class="item-text">
          <p>
              <?php echo $text; ?>
          </p>
        </div>
      <?php endif; ?>
  </div>
</article>