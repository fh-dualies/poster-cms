<?php
if (!isset($headline) || !isset($meta_data) || !isset($image) || !isset($link) || !isset($creation_date)) {
  throw new Exception('Missing required properties: title, alt, image/thumbnail');
} ?>

<article>
    <a href=<?php echo $link; ?>>
        <div class="thumbnail">
            <img
                src="<?php $image; ?>">
                alt="<?php echo $meta_data; ?>"
            />
        </div>
    </a>
    <div class="info">
        <h2><?php echo $headline; ?></h2>
        <time datetime="<?php echo $creation_date; ?>"><?php echo $creation_date; ?></time>
    </div>
</article>