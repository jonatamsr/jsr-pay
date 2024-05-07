<?php

namespace App\Adapters\Outbound;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected function buildEntity(?Model $model, string $entityClassName)
    {
        if (is_null($model)) {
            return null;
        }

        return new $entityClassName($model->toArray());
    }
}
