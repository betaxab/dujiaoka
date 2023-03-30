<?php

namespace App\Admin\Repositories;

use App\Models\UserGroup as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class UserGroup extends EloquentRepository
{

    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

}
