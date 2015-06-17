<fieldset>
    <legend><?= t('Select Options') ?></legend>
    <div class="clearfix">
        <label><?= t('Mask') ?></label>

        <div class="input">
            <ul class="inputs-list">
                <li>
                    <?= $form->text('mask', $mask) ?>
                </li>
            </ul>
        </div>
    </div>
</fieldset>