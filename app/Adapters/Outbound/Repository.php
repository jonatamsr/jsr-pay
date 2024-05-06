<?php

namespace App\Adapters\Outbound;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $entity = null;
    
    protected function buildEntity(?Model $model) {
        if (is_null($model)) {
            return null;
        }

        return new $this->entity($model->toArray());
    }
}
