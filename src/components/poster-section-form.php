<div class="section-editor">
    <div>
        <label for="<?php echo $prefix; ?>headline"><?php echo $name; ?> Headline:</label>
        <input type="text" id="<?php echo $prefix; ?>headline" name="<?php echo $prefix; ?>headline" />
    </div>

    <div>
        <label for="<?php echo $prefix; ?>text"><?php echo $name; ?> Text:</label>
        <textarea id="<?php echo $prefix; ?>text" name="<?php echo $prefix; ?>text"></textarea>
    </div>

    <div>
        <label for="<?php echo $prefix; ?>img">Image (Optional):</label>
        <input type="file" id="<?php echo $prefix; ?>img" name="<?php echo $prefix; ?>img" />
    </div>
</div>