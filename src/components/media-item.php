<?php
if (!isset($image) || !isset($alt) || !isset($name)) {
  throw new Exception('Missing required properties: image, alt, name');
} ?>

<article>
  <div class="preview">
    <img
      src="<?php echo $image; ?>"
      alt="<?php echo $alt; ?>"
    />
  </div>

  <div class="info">
    <h5><?php echo $name; ?></h5>
    <button>Delete</button>
  </div>
</article>