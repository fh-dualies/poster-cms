<?php
if (!isset($headline) || !isset($text) || !isset($image) || !isset($alt)) {
  throw new Exception('Missing required properties: title, text, image, alt');
} ?>

<section>
  <h3><?php echo $headline; ?></h3>
  <div class="content">
    <p>
        <?php echo $text; ?>
    </p>
      <?php include_with_prop(__DIR__ . '/lazy-image.php', [
        'src' => $image,
        'alt' => $alt,
      ]); ?>
  </div>
</section>