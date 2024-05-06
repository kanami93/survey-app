<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Survey $survey
 */
?>
<div class="row">
    <div class="column">
        <?= $this->Flash->render() ?>
        <div class="surveys form content">
            <h1 class="page-title">LIVEアンケート</h1>
            <p class="description">
                <b>ライブ終了後のアンケートへのご協力をお願いたします。</b><br>
                この度は当イベントにご参加いただき、誠にありがとうございました。<br>
                貴重なご意見をお聞かせいただくために、ライブ終了後に簡単なアンケートへのご協力をお願い申し上げます。<br>
                ライブ中に撮影された写真や、ライブに関する素敵な瞬間をお持ちでしたら、ぜひお送りください。<br>
                皆様からの感想と写真は、ライブの思い出をより特別なものにするだけでなく、<br>
                今後の企画や宣伝活動にも活かしていきたいと考えております。<br>
                <span class="text-red">(※)</span>は必須項目です。
            </p>
            <?= $this->Form->create($survey, ['type' => 'file']) ?>
            <fieldset>
                <label><i class="fa-regular fa-pen-to-square icon"></i>感想<span class="text-red">(※)</span></label>
                <?= $this->Form->control('thoughts', ['label' => false]); ?>
                <label><i class="fa-solid fa-camera-retro icon"></i>画像</label>
                <?= $this->Form->control('survey_images[].filename', [
                    'label' => false,
                    'type' => 'file',
                    'accept' => 'image/*',
                    'multiple' => true,
                ]) ?>
                <?= $this->Form->error('survey_images') ?>
                <p class="footnote">※画像は<?= \App\Model\Entity\Survey::MAX_NUMBER_OF_IMAGES ?>枚まで登録可能です</p>
            </fieldset>
            <?= $this->Form->button(__('回答する')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
