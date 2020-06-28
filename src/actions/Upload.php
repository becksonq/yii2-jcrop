<?php

namespace developit\jcrop\actions;

use DeepCopy\f001\B;
use Imagine\Image\Point;
use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use developit\jcrop\Jcrop;

/**
 * Class Upload
 * @package developit\jcrop\actions
 */
class Upload extends Action
{
    public $path;
    public $url;
    public $uploadParam = 'file';
    public $name;
    public $maxSize;
    public $extensions = 'jpeg, jpg, png, gif';
    public $width = 200;
    public $height = 200;
    public $jpegQuality = 100;
    public $pngCompressionLevel = 1;

    /**
     * @inheritdoc
     */
    public function init()
    {
        Jcrop::registerTranslations();
        if ($this->url === null) {
            throw new InvalidConfigException(Yii::t('jcrop', 'Missing Attribute', ['attribute' => 'url']));
        } else {
            $this->url = rtrim($this->url, '/') . '/';
        }
        if ($this->path === null) {
            throw new InvalidConfigException(Yii::t('jcrop', 'Missing Attribute', ['attribute' => 'path']));
        } else {
            $this->path = rtrim(Yii::getAlias($this->path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $this->maxSize = (int)$request->post('maxSize');
            $width = $request->post('width', $this->width);
            $height = $request->post('height', $this->height);
            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $saveOptions = [
                'jpeg_quality'          => $request->post('jpegQuality', $this->jpegQuality),
                'png_compression_level' => $request->post('pngCompressionLevel'),
                $this->pngCompressionLevel
            ];

            $model = new DynamicModel(compact($this->uploadParam));
            $model->addRule($this->uploadParam, 'image', [
                'maxSize'        => $this->maxSize,
                'tooBig'         => Yii::t('jcrop', 'File Size Error', ['size' => $this->maxSize / (1024 * 1024)]),
                'extensions'     => explode(', ', $this->extensions),
                'wrongExtension' => Yii::t('jcrop', 'File Extension Error', ['formats' => $this->extensions])
            ])->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError($this->uploadParam)
                ];
            } else {
                $this->name === null ? $this->name = uniqid() : $model->{$this->uploadParam}->name = $this->name . '.jpg';

                $image = Image::getImagine()->open($file->tempName . $request->post('filename'))->resize(new Box($request->post('imgWidth'),
                    $request->post('imgHeight')));
                $image = Image::crop(
                    $image,
                    intval($request->post('w')),
                    intval($request->post('h')),
                    [intval($request->post('x')), intval($request->post('y'))]
                )->resize(new Box($width, $height));

                if ($image->save($this->path . $model->{$this->uploadParam}->name, $saveOptions)) {
                    $image = $this->path . $model->{$this->uploadParam}->name;
                    $result = [
                        'filelink' => $this->url . $model->{$this->uploadParam}->name . '?' . microtime()
                    ];
                } else {
                    $result = ['error' => Yii::t('jcrop', 'Can Not Upload File')];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException(Yii::t('jcrop', 'Only POST Request'));
        }
    }
}