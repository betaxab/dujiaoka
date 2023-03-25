<?php

namespace App\Admin\Repositories;

use App\Models\CommissionLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CommissionLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
