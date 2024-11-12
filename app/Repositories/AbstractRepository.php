<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

// @codeCoverageIgnoreStart

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
// @codeCoverageIgnoreEnd
