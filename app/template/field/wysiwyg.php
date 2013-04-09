<div class="btn-toolbar btn-group" data-role="editor-toolbar" data-target=".wysiwyg">
    <a class="btn" data-edit="bold"><i class="icon-bold"></i></a>
    <a class="btn" data-edit="italic"><i class="icon-italic"></i></a>
    <a class="btn" data-edit="underline"><i class="icon-underline"></i></a>
</div>
<p><div class="wysiwyg" data-wysiwyg-field="<?php echo $field; ?>"><?= $value; ?></div></p>
<input type="hidden" name="<?php echo $field; ?>" value="<?php e($value); ?>" />