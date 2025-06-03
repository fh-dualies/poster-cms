<?php
if (!isset($headline) || !isset($text) || !isset($image) || !isset($alt)) {
  throw new Exception('Missing required properties: title, text, image, alt');
} ?>

<section>
  <h3><?php echo $headline; ?></h3>
  <div class="content">
    <p class="content">
        <?php echo $text; ?>
    </p>
    <img
      src="<?php echo $image; ?>"
      alt="<?php echo $alt; ?>"
    />
  </div>
</section>