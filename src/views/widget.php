<?php

use \Yii\helpers\Html;

/** @var $this \yii\web\View
 * @var $model
 * @var $widget developit\jcrop\Jcrop
 */
?>

<div class="cropper-widget">
    <?= Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']); ?>
    <?= Html::hiddenInput('width', $widget->width, ['class' => 'width-input']); ?>
    <?= Html::hiddenInput('height', $widget->height, ['class' => 'height-input']); ?>

    <div class="new-photo-area bg-light" style="height: <?= $widget->cropAreaHeight; ?>; width: <?= $widget->cropAreaWidth; ?>;">
        <div class="cropper-label">
            <div><?= Yii::t('jcrop', 'Drag Photo'); ?></div>
            <div><?= Yii::t('jcrop', 'Or'); ?></div>
            <div><?= Html::button(Yii::t('jcrop', 'Select Photo'), ['class' => 'btn btn-primary']) ?></div>
        </div>
    </div>

    <div class="cropper-buttons pb-3">
        <?= Html::button(Yii::t('jcrop', 'Crop Photo'), ['class' => 'btn btn-sm btn-success crop-photo d-none']) ?>
        <?= Html::button(Yii::t('jcrop', 'Select Another Photo'),
            ['class' => 'btn btn-sm btn-info upload-new-photo d-none']) ?>
    </div>

    <div class="progress d-none mb-3" style="width: <?= $widget->cropAreaWidth; ?>; height: 1px;">
        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <?= Html::img(
        $model->{$widget->attribute} != ''
            ? $model->{$widget->attribute}
            : null,
        [
            'style' => 'height: ' . $widget->height . 'px; width: ' . $widget->width . 'px',
            'class' => 'img-thumbnail jcrop-thumbnail d-none'
        ]
    ); ?>

</div>