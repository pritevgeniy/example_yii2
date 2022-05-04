<?php

declare(strict_types=1);

namespace common\exceptions\http;

use yii\web\BadRequestHttpException;
use yii\base\Model;
use JsonException;

class FormValidateHttpException extends BadRequestHttpException
{
    /**
     * @param Model $form
     * @param int $code
     * @throws JsonException
     */
    public function __construct(Model $form, int $code = 0)
    {
        $errorsList = [];
        if ($form->hasErrors()) {
            foreach ($form->getErrors() as $name => $errors) {
                $errorsList[] = "$name: (" . implode(';', $errors) . ")";
            }
        }

        parent::__construct('Form validate error: ' . json_encode($errorsList, JSON_THROW_ON_ERROR), $code);
    }

}