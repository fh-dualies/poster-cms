<?php
if (!isset($title) || !isset($alt) || !isset($image) || !isset($link) || !isset($date) || !isset($datetime)) {
  throw new Exception('Missing required properties: title, alt, image/thumbnail');
} ?>
<article>
    <a href=<?php echo $link; ?>>
        <div class="thumbnail">
            <img
                src="<?php echo $image; ?>">
                alt="<?php echo $alt; ?>"
            />
        </div>
    </a>
    <div class="info">
        <h2><?php echo $title; ?></h2>
        <time datetime="<?php echo $date; ?>"><?php echo $datetime; ?></time>
    </div>
</article>