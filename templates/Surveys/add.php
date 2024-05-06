<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Survey $survey
 */
?>
<div class="row">
    <div class="column">
        <div class="surveys form content">
            <?= $this->Form->create($survey, ['type' => 'file']) ?>
            <fieldset>
                <?= $this->Form->control('thoughts', ['label' => '感想']); ?>
                <?= $this->Form->control('survey_images[].filename', [
                    'label' => '画像',
                    'type' => 'file',
                    'accept' => 'image/*',
                    'multiple' => true,
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('回答する')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
