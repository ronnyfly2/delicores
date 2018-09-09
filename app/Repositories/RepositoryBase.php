<?php

namespace App\Repositories;

use Hashids;

class RepositoryBase
{
    protected function find($model, $_id, $hash = true, $exception = true)
    {

        if ($hash)
            $_id = $this->hashids_decode($_id);

        $record = $model::where([
            ['id', '=', $_id]
        ])->active()->first();

        if(!$record && $exception)
            throw new \Exception(_i("El ID ingresado no esa válido."), 400);

        return $record;
    }

    protected function hashids_decode($_id)
    {
        $arr_ids = Hashids::decode($_id);

        if ($arr_ids)
            return $arr_ids[0];

        return '';
    }
}
