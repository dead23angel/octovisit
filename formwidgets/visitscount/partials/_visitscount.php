<?php if ($this->previewMode): ?>

    <div class="form-control">
        <?= $value ?>
    </div>

<?php else: ?>

    <input
        type="number"
        id="<?= $this->getId('input') ?>"
        name="<?= $name ?>"
	disabled
        value="<?= $value ?>"
        class="form-control"
        readonly="readonly"
        autocomplete="off" />

<?php endif ?>
