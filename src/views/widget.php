<?php

use \Yii\helpers\Html;

/** @var $this \yii\web\View
 * @var $model
 * @var $widget developit\jcrop\Jcrop
 */
?>

<div class="cropper-widget">
    <?= Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']); ?>
    <?= Html::hiddenInput('width', $widget->width, ['id' => 'width-input']); ?>
    <?= Html::hiddenInput('height', $widget->height, ['id' => 'height-input']); ?>
    <?= Html::hiddenInput('size', $widget->maxSize, ['id' => 'size-input']); ?>
    <?= Html::hiddenInput('jpegQuality', $widget->maxSize, ['id' => 'jpeg-quality-input']); ?>
    <?= Html::hiddenInput('pngCompressionLevel', $widget->maxSize, ['id' => 'png-compression-level-input']); ?>

    <div class="new-photo-area bg-light mw-none "
         style="height: <?= $widget->cropAreaHeight; ?>; width: <?= $widget->cropAreaWidth ?>;">
        <div id="cropper-label">
            <div><?= Yii::t('jcrop', 'Drag Photo'); ?></div>
            <div><?= Yii::t('jcrop', 'Or'); ?></div>
            <div><?= Html::button(Yii::t('jcrop', 'Select Photo'), ['class' => 'btn btn-primary']) ?></div>

            <small class="form-text text-muted"><?= Yii::t('jcrop', 'File size cannot exceed',
                    ['size' => $widget->maxSize / (1024 * 1024)]) ?></small>
        </div>
    </div>

    <div id="cropper-buttons" class="pb-3">
        <?= Html::button(Yii::t('jcrop', 'Crop Photo'), ['class' => 'btn btn-sm btn-success crop-photo d-none']) ?>
        <?= Html::button(Yii::t('jcrop', 'Select Another Photo'),
            ['class' => 'btn btn-sm btn-info upload-new-photo d-none']) ?>
        <!-- Uncomment if you need delete img button -->
        <? /*= Html::button(Yii::t('jcrop', 'Delete'),
            ['class' => 'btn btn-sm btn-danger delete-photo d-none']) */ ?>
    </div>

    <div class="progress d-none mb-3" style="width: <?= $widget->cropAreaWidth; ?>; height: 1px;">
        <div id="progress-bar" class="bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0"
             aria-valuemax="100"></div>
    </div>

    <?= Html::img(
        $model->{$widget->attribute} != '' ? $model->{$widget->attribute} : $widget->noPhotoImage,
        [
            'style' => 'height: ' . $widget->height . 'px; width: ' . $widget->width . 'px',
            'class' => 'img-thumbnail jcrop-thumbnail d-none'
        ]
    ); ?>

    <!-- Uncomment if you need delete img action -->
    <? /*= Html::img(
        $model->{$widget->attribute} != '' ? $model->{$widget->attribute} : $widget->noPhotoImage,
        [
            'style'         => 'height: ' . $widget->height . 'px; width: ' . $widget->width . 'px',
            'class'         => 'img-thumbnail jcrop-thumbnail d-none',
            'data-no-photo' => $widget->noPhotoImage
        ]
    ); */ ?>

</div>